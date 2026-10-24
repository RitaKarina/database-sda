<?php

namespace Tests\Feature;

use App\Models\DaerahIrigasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DaerahIrigasiRevisionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_create_form_uses_ntb_region_data_and_repeatable_institution_fields(): void
    {
        $response = $this->get(route('daerah-irigasi.create'));

        $response->assertOk()
            ->assertSee('Tambah Kelembagaan')
            ->assertSee('IP3A')
            ->assertSee('GP3A')
            ->assertSee('P3A')
            ->assertSee('Kelembagaan dan Ruas Kewenangan')
            ->assertSee('Ruas Kewenangan')
            ->assertSee('Organisasi Personalia')
            ->assertSee('Lombok Barat')
            ->assertSee('Kecamatan di Kota Bima')
            ->assertSee('ukuran maksimum 10 MB')
            ->assertSee('Upload Skema Ruas Kewenangan IP3A, GP3A, P3A')
            ->assertSee('Manggelewa')
            ->assertSee('Lenek')
            ->assertSee('Labuapi')
            ->assertDontSee('Jilung')
            ->assertDontSee('Luas Fungsional Teknis (Ha)')
            ->assertDontSee('Luas Irigasi Teknis')
            ->assertDontSee('Luas Irigasi Non Teknis');
    }

    public function test_store_saves_multiple_institutions_with_individual_ruas(): void
    {
        $response = $this->post(route('daerah-irigasi.store'), [
            'nama_di' => 'DI Contoh',
            'kabupaten' => ['Sumbawa'],
            'kecamatan' => ['Moyo Hulu'],
            'kelembagaan' => [
                'IP3A' => [
                    ['nama_kelembagaan' => 'IP3A Maju 1', 'ruas' => 'Ruas Utara'],
                    ['nama_kelembagaan' => 'IP3A Maju 2', 'ruas' => 'Ruas Tengah'],
                ],
                'GP3A' => [
                    ['nama_kelembagaan' => 'GP3A Sejahtera', 'ruas' => 'Ruas Barat'],
                ],
                'P3A' => [
                    ['nama_kelembagaan' => 'P3A Makmur', 'ruas' => 'Ruas Selatan'],
                ],
            ],
        ]);

        $di = DaerahIrigasi::query()->where('nama_di', 'DI Contoh')->firstOrFail();
        $response->assertRedirect(route('daerah-irigasi.show', $di));
        $this->assertDatabaseHas('daerah_irigasi_kelembagaans', [
            'daerah_irigasi_id' => $di->id,
            'jenis_kelembagaan' => 'IP3A',
            'nama_kelembagaan' => 'IP3A Maju 1',
            'ruas' => 'Ruas Utara',
        ]);
        $this->assertDatabaseHas('daerah_irigasi_kelembagaans', [
            'daerah_irigasi_id' => $di->id,
            'jenis_kelembagaan' => 'IP3A',
            'nama_kelembagaan' => 'IP3A Maju 2',
            'ruas' => 'Ruas Tengah',
        ]);
        $this->assertDatabaseHas('daerah_irigasi_kelembagaans', [
            'daerah_irigasi_id' => $di->id,
            'jenis_kelembagaan' => 'GP3A',
            'nama_kelembagaan' => 'GP3A Sejahtera',
            'ruas' => 'Ruas Barat',
        ]);
        $this->assertDatabaseHas('daerah_irigasi_kelembagaans', [
            'daerah_irigasi_id' => $di->id,
            'jenis_kelembagaan' => 'P3A',
            'nama_kelembagaan' => 'P3A Makmur',
            'ruas' => 'Ruas Selatan',
        ]);
        $this->assertSame(['Sumbawa'], $di->kabupaten);
        $this->assertSame(['Moyo Hulu'], $di->kecamatan);

        $this->get(route('daerah-irigasi.index'))
            ->assertOk()
            ->assertDontSee('IP3A Maju 1')
            ->assertDontSee('IP3A Maju 2')
            ->assertDontSee('GP3A Sejahtera')
            ->assertDontSee('P3A Makmur')
            ->assertDontSee('Ruas: Ruas Utara')
            ->assertDontSee('Ruas: Ruas Tengah')
            ->assertDontSee('Ruas: Ruas Barat')
            ->assertDontSee('Ruas: Ruas Selatan');
    }

    public function test_irrigation_index_shows_the_new_area_columns_without_institution_or_legacy_baku_area(): void
    {
        DaerahIrigasi::create([
            'nama_di' => 'DI Kolom',
            'luas_baku' => 12.5,
            'luas_fungsional' => 10.5,
        ]);

        $html = $this->get(route('daerah-irigasi.index'))
            ->assertOk()
            ->assertSee('Luas Baku Permen 14 (Ha)')
            ->assertSee('Luas Fungsional Irigasi Teknis (Ha)')
            ->assertSee('Luas Fungsional Irigasi Non Teknis (Ha)')
            ->assertSee('IP (%)')
            ->assertSee('Nilai IKSI')
            ->assertSee('Thn Dok. Perencanaan')
            ->assertSee('Kelengkapan Data')
            ->assertSee('Aksi')
            ->assertDontSee('Organisasi Personalia / Ruas')
            ->assertDontSee('Luas Baku (Ha)')
            ->getContent();

        preg_match('/<table class="table table-hover align-middle mb-0">.*?<thead\b.*?<\/thead>.*?<tbody\b.*?>(.*?)<\/tbody>/s', $html, $table);

        $this->assertCount(2, $table);
        $this->assertSame(11, preg_match_all('/<th(?=[\s>])/', $table[0]));
        preg_match_all('/<tr\b.*?<\/tr>/s', $table[1], $rows);
        $this->assertNotEmpty($rows[0]);

        foreach ($rows[0] as $row) {
            $this->assertSame(11, preg_match_all('/<td(?=[\s>])/', $row));
        }
    }

    public function test_area_and_funding_values_are_stored_displayed_and_updated(): void
    {
        $this->get(route('daerah-irigasi.create'))
            ->assertOk()
            ->assertSee('Luas Baku Permen 14 (Ha)')
            ->assertSee('Luas Fungsional Irigasi Teknis (Ha)')
            ->assertSee('Luas Fungsional Irigasi Non Teknis (Ha)')
            ->assertSee('Sumber Dana Penanganan')
            ->assertDontSee('Luas Fungsional Teknis (Ha)')
            ->assertDontSee('Luas Irigasi Teknis')
            ->assertDontSee('Luas Irigasi Non Teknis');

        $this->post(route('daerah-irigasi.store'), [
            'nama_di' => 'DI Area Baru',
            'luas_baku_permen_14' => '1250,75',
            'luas_fungsional_irigasi_teknis' => '987,50',
            'luas_fungsional_irigasi_non_teknis' => '263.25',
            'sumber_dana_penanganan' => 'APBD Provinsi',
        ])->assertRedirect();

        $di = DaerahIrigasi::query()->where('nama_di', 'DI Area Baru')->firstOrFail();
        $this->assertSame(1250.75, $di->luas_baku_permen_14);
        $this->assertSame(987.5, $di->luas_fungsional_irigasi_teknis);
        $this->assertSame(263.25, $di->luas_fungsional_irigasi_non_teknis);
        $this->assertSame('APBD Provinsi', $di->sumber_dana_penanganan);

        $this->get(route('daerah-irigasi.edit', $di))
            ->assertOk()
            ->assertSee('value="1250.75"', false)
            ->assertSee('value="987.5"', false)
            ->assertSee('value="263.25"', false)
            ->assertSee('value="APBD Provinsi"', false);

        $this->put(route('daerah-irigasi.update', $di), [
            'nama_di' => 'DI Area Baru',
            'luas_baku_permen_14' => '1300.00',
            'luas_fungsional_irigasi_teknis' => '1000',
            'luas_fungsional_irigasi_non_teknis' => '300',
            'sumber_dana_penanganan' => 'DAK',
        ])->assertRedirect(route('daerah-irigasi.show', $di));

        $this->get(route('daerah-irigasi.show', $di))
            ->assertOk()
            ->assertSee('1,300.00')
            ->assertSee('1,000.00')
            ->assertSee('300.00')
            ->assertSee('DAK');

        $this->get(route('daerah-irigasi.export', $di))
            ->assertOk()
            ->assertSee('Luas Baku Permen 14 (Ha)')
            ->assertSee('Luas Fungsional Irigasi Teknis (Ha)')
            ->assertSee('Luas Fungsional Irigasi Non Teknis (Ha)')
            ->assertSee('Sumber Dana Penanganan')
            ->assertDontSee('Luas Fungsional Teknis (Ha)')
            ->assertDontSee('Luas Irigasi Teknis (Ha)')
            ->assertDontSee('Luas Irigasi Non Teknis (Ha)');
    }

    public function test_area_decimal_validation_rejects_negative_values_and_funding_over_255_characters(): void
    {
        $this->from(route('daerah-irigasi.create'))
            ->post(route('daerah-irigasi.store'), [
                'nama_di' => 'DI Area Invalid',
                'luas_fungsional_irigasi_teknis' => '-1',
                'sumber_dana_penanganan' => str_repeat('a', 256),
            ])
            ->assertRedirect(route('daerah-irigasi.create'))
            ->assertSessionHasErrors([
                'luas_fungsional_irigasi_teknis',
                'sumber_dana_penanganan',
            ]);

        $this->assertDatabaseMissing('daerah_irigasis', ['nama_di' => 'DI Area Invalid']);
    }

    public function test_store_rejects_a_district_that_does_not_belong_to_the_selected_regency(): void
    {
        $response = $this->from(route('daerah-irigasi.create'))
            ->post(route('daerah-irigasi.store'), [
                'nama_di' => 'DI Tidak Valid',
                'kabupaten' => ['Sumbawa'],
                'kecamatan' => ['Ampenan'],
            ]);

        $response->assertRedirect(route('daerah-irigasi.create'))
            ->assertSessionHasErrors('kecamatan.0');
        $this->assertDatabaseMissing('daerah_irigasis', ['nama_di' => 'DI Tidak Valid']);
    }

    public function test_edit_updates_institutions_and_print_shows_all_names_and_ruas(): void
    {
        $di = DaerahIrigasi::create(['nama_di' => 'DI Cetak']);
        $di->kelembagaans()->createMany([
            ['jenis_kelembagaan' => 'IP3A', 'nama_kelembagaan' => 'IP3A Beringin', 'ruas' => 'Ruas A'],
            ['jenis_kelembagaan' => 'GP3A', 'nama_kelembagaan' => 'GP3A Tani', 'ruas' => 'Ruas B'],
        ]);

        $edit = $this->get(route('daerah-irigasi.edit', $di));
        $edit->assertOk()
            ->assertSee('IP3A Beringin')
            ->assertSee('Ruas A')
            ->assertSee('Ruas Kewenangan');

        $this->put(route('daerah-irigasi.update', $di), [
            'nama_di' => 'DI Cetak',
            'kelembagaan' => [
                'IP3A' => [
                    ['nama_kelembagaan' => 'IP3A Baru', 'ruas' => 'Ruas C'],
                ],
                'GP3A' => [
                    ['nama_kelembagaan' => 'GP3A Baru', 'ruas' => 'Ruas D'],
                ],
                'P3A' => [
                    ['nama_kelembagaan' => 'P3A Baru', 'ruas' => 'Ruas E'],
                ],
            ],
        ])->assertRedirect(route('daerah-irigasi.show', $di));

        $this->get(route('daerah-irigasi.show', $di))
            ->assertOk()
            ->assertSee('Ruas Kewenangan')
            ->assertSee('Ruas E');

        $print = $this->get(route('daerah-irigasi.print', $di));
        $print->assertOk()
            ->assertSee('Ruas Kewenangan')
            ->assertSee('P3A Baru')
            ->assertSee('Ruas E')
            ->assertSee('GP3A Baru')
            ->assertSee('Ruas D')
            ->assertSee('IP3A Baru')
            ->assertSee('Ruas C')
            ->assertDontSee('IP3A Beringin')
            ->assertDontSee('GP3A Tani');

        $this->get(route('daerah-irigasi.export', $di))
            ->assertOk()
            ->assertSee('Ruas Kewenangan')
            ->assertSee('P3A Baru')
            ->assertSee('Ruas E')
            ->assertSee('GP3A Baru')
            ->assertSee('Ruas D')
            ->assertSee('IP3A Baru')
            ->assertSee('Ruas C');
    }

    public function test_print_pages_validate_and_display_manual_signature_fields(): void
    {
        $di = DaerahIrigasi::create(['nama_di' => 'DI Tanda Tangan']);

        foreach ([
            route('daerah-irigasi.print', $di),
            route('daerah-irigasi.export', $di),
        ] as $url) {
            $html = $this->get($url)
                ->assertOk()
                ->assertDontSee('window.prompt')
                ->assertSee('Data Penanda Tangan')
                ->assertSee('Nama Penanda Tangan')
                ->assertSee('NIP (18 digit)')
                ->assertDontSee('NIK')
                ->assertSee('Batal')
                ->assertSee('Cetak / Simpan PDF')
                ->assertSee('Kepala Bidang Sumber Daya Air')
                ->getContent();

            $this->assertStringContainsString(
                'id="signature-name-output" class="signature-name"></div>',
                $html
            );
            $this->assertStringContainsString(
                'id="signature-nip-output" class="signature-nip"></div>',
                $html
            );
            $this->assertStringContainsString('<dialog id="signature-dialog"', $html);
            $this->assertStringContainsString('id="open-signature-dialog"', $html);
            $this->assertStringContainsString('maxlength="18"', $html);
            $this->assertStringContainsString('pattern="[0-9]{18}"', $html);
            $this->assertStringContainsString('NIP harus terdiri dari 18 digit angka.', $html);
            $this->assertStringContainsString("trimmedName ? '(' + trimmedName + ')' : ''", $html);
            $this->assertStringContainsString("nipInput.value ? 'NIP. ' + nipInput.value : ''", $html);
            $this->assertStringContainsString('window.print();', $html);
            $this->assertStringNotContainsString('signature-settings', $html);
            $this->assertMatchesRegularExpression(
                '/signature-nip-output.*?signature-print-control.*?signature-dialog/s',
                $html
            );
            $this->assertStringContainsString('.signature-space { height: 90px; }', $html);
            $this->assertMatchesRegularExpression(
                '/Kepala Bidang Sumber Daya Air.*?signature-space.*?signature-name-output.*?signature-nip-output/s',
                $html
            );
        }
    }

    public function test_store_rejects_an_unknown_institution_type(): void
    {
        $response = $this->from(route('daerah-irigasi.create'))
            ->post(route('daerah-irigasi.store'), [
                'nama_di' => 'DI Jenis Tidak Valid',
                'kelembagaan' => [
                    'LAINNYA' => [
                        ['nama_kelembagaan' => 'Nama Tidak Valid', 'ruas' => 'Ruas X'],
                    ],
                ],
            ]);

        $response->assertRedirect(route('daerah-irigasi.create'))
            ->assertSessionHasErrors('kelembagaan');
        $this->assertDatabaseMissing('daerah_irigasis', ['nama_di' => 'DI Jenis Tidak Valid']);
    }

    public function test_skema_ruas_upload_is_saved_and_existing_file_is_kept_when_not_replaced(): void
    {
        Storage::fake('public');
        $di = DaerahIrigasi::create(['nama_di' => 'DI Upload']);

        $this->post(route('daerah-irigasi.store'), [
            'nama_di' => 'DI Dengan File',
            'skema_ruas' => UploadedFile::fake()->create('skema-ruas.pdf', 200, 'application/pdf'),
        ])->assertRedirect();

        $uploadedDi = DaerahIrigasi::query()->where('nama_di', 'DI Dengan File')->firstOrFail();
        $this->assertNotNull($uploadedDi->skema_ruas_path);
        Storage::disk('public')->assertExists($uploadedDi->skema_ruas_path);

        $existingPath = UploadedFile::fake()
            ->create('skema-lama.pdf', 100, 'application/pdf')
            ->store('daerah-irigasi', 'public');
        $di->update(['skema_ruas_path' => $existingPath]);

        $this->put(route('daerah-irigasi.update', $di), [
            'nama_di' => 'DI Upload',
        ])->assertRedirect(route('daerah-irigasi.show', $di));

        $this->assertSame($existingPath, $di->fresh()->skema_ruas_path);
        Storage::disk('public')->assertExists($existingPath);
        $this->get(route('daerah-irigasi.show', $di))
            ->assertOk()
            ->assertSee('Lihat file')
            ->assertSee('Unduh');
    }

    public function test_skema_ruas_upload_rejects_unsupported_file_types(): void
    {
        Storage::fake('public');

        $this->from(route('daerah-irigasi.create'))
            ->post(route('daerah-irigasi.store'), [
                'nama_di' => 'DI Dengan File Tidak Valid',
                'skema_ruas' => UploadedFile::fake()->create('skema.exe', 10, 'application/octet-stream'),
            ])
            ->assertRedirect(route('daerah-irigasi.create'))
            ->assertSessionHasErrors('skema_ruas');

        $this->assertDatabaseMissing('daerah_irigasis', ['nama_di' => 'DI Dengan File Tidak Valid']);
        $this->assertSame([], Storage::disk('public')->allFiles('daerah-irigasi'));
    }

    public function test_peta_skema_accepts_files_up_to_10_mb_and_rejects_larger_files(): void
    {
        Storage::fake('public');

        $this->post(route('daerah-irigasi.store'), [
            'nama_di' => 'DI Peta 10 MB',
            'peta_skema' => UploadedFile::fake()->image('peta.png')->size(10240),
        ])->assertRedirect();

        $acceptedDi = DaerahIrigasi::query()->where('nama_di', 'DI Peta 10 MB')->firstOrFail();
        $this->assertNotNull($acceptedDi->peta_skema_path);
        Storage::disk('public')->assertExists($acceptedDi->peta_skema_path);

        $this->from(route('daerah-irigasi.create'))
            ->post(route('daerah-irigasi.store'), [
                'nama_di' => 'DI Peta Terlalu Besar',
                'peta_skema' => UploadedFile::fake()->image('peta-besar.png')->size(10241),
                'skema_ruas' => UploadedFile::fake()->create('skema-ruas-besar.pdf', 10241, 'application/pdf'),
            ])
            ->assertRedirect(route('daerah-irigasi.create'))
            ->assertSessionHasErrors(['peta_skema', 'skema_ruas']);

        $this->assertDatabaseMissing('daerah_irigasis', ['nama_di' => 'DI Peta Terlalu Besar']);
    }
}
