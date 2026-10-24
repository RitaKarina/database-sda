<?php

namespace App\Http\Controllers;

use App\Models\DaerahIrigasi;
use App\Models\Kecamatan;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class DaerahIrigasiController extends Controller
{
    public function index(Request $request)
    {
        $query = DaerahIrigasi::with('kelembagaans');

        if ($request->filled('search')) {
            $query->where('nama_di', 'like', '%'.$request->search.'%');
        }

        $daerahIrigasi = $query->latest()->paginate(10);

        return view('daerah-irigasi.index', compact('daerahIrigasi'));
    }

    public function create()
    {
        $wilayahNtb = $this->wilayahNtb();

        return view('daerah-irigasi.create', compact('wilayahNtb'));
    }

    public function store(Request $request)
    {
        $this->normalizeAreaDecimalInputs($request);
        $selectedKabupaten = $request->input('kabupaten', []);
        $selectedKabupaten = is_array($selectedKabupaten) ? $selectedKabupaten : [];

        $validated = $request->validate([
            'nama_di' => 'required|string|max:255',
            'kode_di' => 'nullable|string|max:255',
            'luas_baku' => 'nullable|numeric',
            'luas_baku_igt' => 'nullable|numeric',
            'luas_potensial' => 'nullable|numeric',
            'luas_potensial_igt' => 'nullable|numeric',
            'luas_fungsional' => 'nullable|numeric',
            'luas_fungsional_igt' => 'nullable|numeric',
            'luas_baku_permen_14' => 'nullable|numeric|min:0|max:9999999999.99',
            'luas_fungsional_irigasi_teknis' => 'nullable|numeric|min:0|max:9999999999.99',
            'luas_fungsional_irigasi_non_teknis' => 'nullable|numeric|min:0|max:9999999999.99',
            'sumber_dana_penanganan' => 'nullable|string|max:255',
            'ip' => 'nullable|numeric',
            'iksi' => 'nullable|numeric',
            'tahun_dokumen_perencanaan' => 'nullable|string|max:255',
            'tahun_epaksi' => 'nullable|string|max:255',
            'status_fungsi' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|array',
            'kabupaten.*' => ['string', 'distinct', Rule::in(Kecamatan::query()->distinct()->pluck('kabupaten')->all())],
            'kecamatan' => 'nullable|array',
            'kecamatan.*' => [
                'string',
                'distinct',
                Rule::exists('kecamatans', 'nama_kecamatan')
                    ->where(fn (Builder $query) => $query->whereIn('kabupaten', $selectedKabupaten)),
            ],
            'kewenangan' => 'nullable|string|max:255',
            'sumber_air' => 'nullable|string|max:255',
            'nama_pengamat' => 'nullable|string|max:255',
            'pengamat' => 'nullable|string|max:255',
            'juru_pengairan' => 'nullable|string|max:255',
            'petugas_operasi_bendungan' => 'nullable|string|max:255',
            'petugas_pintu_bendung_air' => 'nullable|string|max:255',
            'kebutuhan_pengamat' => 'nullable|numeric|min:0',
            'ketersediaan_pengamat' => 'nullable|numeric|min:0',
            'status_ketersediaan_pengamat' => 'nullable|string|max:255',
            'p3a' => 'nullable|string|max:255',
            'gp3a' => 'nullable|string|max:255',
            'ip3a' => 'nullable|string|max:255',
            'kelembagaan' => 'nullable|array:IP3A,GP3A,P3A',
            'kelembagaan.IP3A' => 'nullable|array',
            'kelembagaan.IP3A.*' => 'array',
            'kelembagaan.IP3A.*.nama_kelembagaan' => 'nullable|string|max:255',
            'kelembagaan.IP3A.*.ruas' => 'nullable|string|max:255',
            'kelembagaan.GP3A' => 'nullable|array',
            'kelembagaan.GP3A.*' => 'array',
            'kelembagaan.GP3A.*.nama_kelembagaan' => 'nullable|string|max:255',
            'kelembagaan.GP3A.*.ruas' => 'nullable|string|max:255',
            'kelembagaan.P3A' => 'nullable|array',
            'kelembagaan.P3A.*' => 'array',
            'kelembagaan.P3A.*.nama_kelembagaan' => 'nullable|string|max:255',
            'kelembagaan.P3A.*.ruas' => 'nullable|string|max:255',
            'bendung_buah' => 'nullable|integer|min:0',
            'bendung' => 'nullable|string|max:255',
            'saluran_primer_m' => 'nullable|numeric',
            'saluran_primer_baik_m' => 'nullable|numeric',
            'saluran_primer_sedang_m' => 'nullable|numeric',
            'saluran_primer_buruk_m' => 'nullable|numeric',
            'saluran_sekunder_m' => 'nullable|numeric',
            'saluran_sekunder_baik_m' => 'nullable|numeric',
            'saluran_sekunder_sedang_m' => 'nullable|numeric',
            'saluran_sekunder_buruk_m' => 'nullable|numeric',
            'saluran_tersier_m' => 'nullable|numeric',
            'saluran_tersier_baik_m' => 'nullable|numeric',
            'saluran_tersier_sedang_m' => 'nullable|numeric',
            'saluran_tersier_buruk_m' => 'nullable|numeric',
            'saluran_pembuang_m' => 'nullable|numeric',
            'saluran_pembuang_baik_m' => 'nullable|numeric',
            'saluran_pembuang_sedang_m' => 'nullable|numeric',
            'saluran_pembuang_buruk_m' => 'nullable|numeric',
            'bangunan_pengatur_buah' => 'nullable|integer|min:0',
            'bangunan_pelengkap_buah' => 'nullable|integer|min:0',
            'peta_skema' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'skema_ruas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $validated['kabupaten'] = $request->input('kabupaten', []);
        $validated['kecamatan'] = $request->input('kecamatan', []);
        $kelembagaan = $this->normalizeKelembagaan($validated['kelembagaan'] ?? []);
        unset($validated['kelembagaan']);

        $uploadedPaths = [];

        try {
            foreach ([
                'peta_skema' => 'peta_skema_path',
                'skema_ruas' => 'skema_ruas_path',
            ] as $fileField => $pathField) {
                if ($request->hasFile($fileField)) {
                    $path = $this->storePublicUpload($request->file($fileField), 'daerah-irigasi');
                    $uploadedPaths[] = $path;
                    $validated[$pathField] = $path;
                }
            }

            if (($validated['kebutuhan_pengamat'] ?? 0) > 0 || ($validated['ketersediaan_pengamat'] ?? 0) > 0) {
                $validated['status_ketersediaan_pengamat'] = $this->generatePengamatStatus(
                    $validated['kebutuhan_pengamat'] ?? 0,
                    $validated['ketersediaan_pengamat'] ?? 0
                );
            }

            $daerahIrigasi = DB::transaction(function () use ($validated, $kelembagaan): DaerahIrigasi {
                $daerahIrigasi = DaerahIrigasi::create($validated);
                $daerahIrigasi->kelembagaans()->createMany($kelembagaan);

                return $daerahIrigasi;
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($uploadedPaths);
            throw $exception;
        }

        return redirect()->route('daerah-irigasi.show', $daerahIrigasi->id)
            ->with('success', 'Data Daerah Irigasi berhasil disimpan!');
    }

    public function show($id)
    {
        $di = DaerahIrigasi::with('kelembagaans')->findOrFail($id);

        return view('daerah-irigasi.show', compact('di'));
    }

    public function edit($id)
    {
        $di = DaerahIrigasi::with('kelembagaans')->findOrFail($id);
        $wilayahNtb = $this->wilayahNtb();

        return view('daerah-irigasi.edit', compact('di', 'wilayahNtb'));
    }

    public function update(Request $request, $id)
    {
        $this->normalizeAreaDecimalInputs($request);
        $di = DaerahIrigasi::findOrFail($id);
        $selectedKabupaten = $request->input('kabupaten', []);
        $selectedKabupaten = is_array($selectedKabupaten) ? $selectedKabupaten : [];

        $validated = $request->validate([
            'nama_di' => 'required|string|max:255',
            'kode_di' => 'nullable|string|max:255',
            'luas_baku' => 'nullable|numeric',
            'luas_baku_igt' => 'nullable|numeric',
            'luas_potensial' => 'nullable|numeric',
            'luas_potensial_igt' => 'nullable|numeric',
            'luas_fungsional' => 'nullable|numeric',
            'luas_fungsional_igt' => 'nullable|numeric',
            'luas_baku_permen_14' => 'nullable|numeric|min:0|max:9999999999.99',
            'luas_fungsional_irigasi_teknis' => 'nullable|numeric|min:0|max:9999999999.99',
            'luas_fungsional_irigasi_non_teknis' => 'nullable|numeric|min:0|max:9999999999.99',
            'sumber_dana_penanganan' => 'nullable|string|max:255',
            'ip' => 'nullable|numeric',
            'iksi' => 'nullable|numeric',
            'tahun_dokumen_perencanaan' => 'nullable|string|max:255',
            'tahun_epaksi' => 'nullable|string|max:255',
            'status_fungsi' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|array',
            'kabupaten.*' => ['string', 'distinct', Rule::in(Kecamatan::query()->distinct()->pluck('kabupaten')->all())],
            'kecamatan' => 'nullable|array',
            'kecamatan.*' => [
                'string',
                'distinct',
                Rule::exists('kecamatans', 'nama_kecamatan')
                    ->where(fn (Builder $query) => $query->whereIn('kabupaten', $selectedKabupaten)),
            ],
            'kewenangan' => 'nullable|string|max:255',
            'sumber_air' => 'nullable|string|max:255',
            'nama_pengamat' => 'nullable|string|max:255',
            'pengamat' => 'nullable|string|max:255',
            'juru_pengairan' => 'nullable|string|max:255',
            'petugas_operasi_bendungan' => 'nullable|string|max:255',
            'petugas_pintu_bendung_air' => 'nullable|string|max:255',
            'kebutuhan_pengamat' => 'nullable|numeric|min:0',
            'ketersediaan_pengamat' => 'nullable|numeric|min:0',
            'status_ketersediaan_pengamat' => 'nullable|string|max:255',
            'p3a' => 'nullable|string|max:255',
            'gp3a' => 'nullable|string|max:255',
            'ip3a' => 'nullable|string|max:255',
            'kelembagaan' => 'nullable|array:IP3A,GP3A,P3A',
            'kelembagaan.IP3A' => 'nullable|array',
            'kelembagaan.IP3A.*' => 'array',
            'kelembagaan.IP3A.*.nama_kelembagaan' => 'nullable|string|max:255',
            'kelembagaan.IP3A.*.ruas' => 'nullable|string|max:255',
            'kelembagaan.GP3A' => 'nullable|array',
            'kelembagaan.GP3A.*' => 'array',
            'kelembagaan.GP3A.*.nama_kelembagaan' => 'nullable|string|max:255',
            'kelembagaan.GP3A.*.ruas' => 'nullable|string|max:255',
            'kelembagaan.P3A' => 'nullable|array',
            'kelembagaan.P3A.*' => 'array',
            'kelembagaan.P3A.*.nama_kelembagaan' => 'nullable|string|max:255',
            'kelembagaan.P3A.*.ruas' => 'nullable|string|max:255',
            'bendung_buah' => 'nullable|integer|min:0',
            'bendung' => 'nullable|string|max:255',
            'saluran_primer_m' => 'nullable|numeric',
            'saluran_primer_baik_m' => 'nullable|numeric',
            'saluran_primer_sedang_m' => 'nullable|numeric',
            'saluran_primer_buruk_m' => 'nullable|numeric',
            'saluran_sekunder_m' => 'nullable|numeric',
            'saluran_sekunder_baik_m' => 'nullable|numeric',
            'saluran_sekunder_sedang_m' => 'nullable|numeric',
            'saluran_sekunder_buruk_m' => 'nullable|numeric',
            'saluran_tersier_m' => 'nullable|numeric',
            'saluran_tersier_baik_m' => 'nullable|numeric',
            'saluran_tersier_sedang_m' => 'nullable|numeric',
            'saluran_tersier_buruk_m' => 'nullable|numeric',
            'saluran_pembuang_m' => 'nullable|numeric',
            'saluran_pembuang_baik_m' => 'nullable|numeric',
            'saluran_pembuang_sedang_m' => 'nullable|numeric',
            'saluran_pembuang_buruk_m' => 'nullable|numeric',
            'bangunan_pengatur_buah' => 'nullable|integer|min:0',
            'bangunan_pelengkap_buah' => 'nullable|integer|min:0',
            'peta_skema' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'skema_ruas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $validated['kabupaten'] = $request->input('kabupaten', []);
        $validated['kecamatan'] = $request->input('kecamatan', []);
        $kelembagaan = $this->normalizeKelembagaan($validated['kelembagaan'] ?? []);
        unset($validated['kelembagaan']);

        $uploadedPaths = [];
        $pathsToReplace = [];

        try {
            foreach ([
                'peta_skema' => ['peta_skema_path', $di->peta_skema_path],
                'skema_ruas' => ['skema_ruas_path', $di->skema_ruas_path],
            ] as $fileField => [$pathField, $oldPath]) {
                if ($request->hasFile($fileField)) {
                    $path = $this->storePublicUpload($request->file($fileField), 'daerah-irigasi');
                    $uploadedPaths[] = $path;
                    $validated[$pathField] = $path;

                    if ($oldPath) {
                        $pathsToReplace[] = $oldPath;
                    }
                }
            }

            if (($validated['kebutuhan_pengamat'] ?? 0) > 0 || ($validated['ketersediaan_pengamat'] ?? 0) > 0) {
                $validated['status_ketersediaan_pengamat'] = $this->generatePengamatStatus(
                    $validated['kebutuhan_pengamat'] ?? 0,
                    $validated['ketersediaan_pengamat'] ?? 0
                );
            }

            DB::transaction(function () use ($di, $validated, $kelembagaan): void {
                $di->update($validated);
                $di->kelembagaans()
                    ->whereIn('jenis_kelembagaan', ['IP3A', 'GP3A', 'P3A'])
                    ->delete();
                $di->kelembagaans()->createMany($kelembagaan);
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($uploadedPaths);
            throw $exception;
        }

        Storage::disk('public')->delete($pathsToReplace);

        return redirect()->route('daerah-irigasi.show', $di->id)
            ->with('success', 'Data Daerah Irigasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $di = DaerahIrigasi::findOrFail($id);
        $filePaths = array_filter([$di->peta_skema_path, $di->skema_ruas_path]);

        $di->delete();
        Storage::disk('public')->delete($filePaths);

        return redirect()->route('daerah-irigasi.index')->with('success', 'Data Daerah Irigasi berhasil dihapus!');
    }

    public function print($id)
    {
        $daerahIrigasi = collect([DaerahIrigasi::with('kelembagaans')->findOrFail($id)]);

        return view('daerah-irigasi.print', compact('daerahIrigasi'));
    }

    public function printAll()
    {
        $daerahIrigasi = DaerahIrigasi::with('kelembagaans')->orderBy('nama_di')->get();

        return view('daerah-irigasi.print', compact('daerahIrigasi'));
    }

    public function export($id)
    {
        $daerahIrigasi = collect([DaerahIrigasi::with('kelembagaans')->findOrFail($id)]);

        return view('daerah-irigasi.export_pdf', compact('daerahIrigasi'));
    }

    public function exportAll()
    {
        $daerahIrigasi = DaerahIrigasi::with('kelembagaans')->orderBy('nama_di')->get();

        return view('daerah-irigasi.export_pdf', compact('daerahIrigasi'));
    }

    private function generatePengamatStatus(float $kebutuhan, float $tersedia): string
    {
        if ($kebutuhan <= 0) {
            return 'Tidak dipersyaratkan';
        }

        return $tersedia >= $kebutuhan ? 'Sudah Terpenuhi' : 'Belum Terpenuhi';
    }

    private function normalizeAreaDecimalInputs(Request $request): void
    {
        foreach ([
            'luas_baku_permen_14',
            'luas_fungsional_irigasi_teknis',
            'luas_fungsional_irigasi_non_teknis',
        ] as $field) {
            $value = $request->input($field);

            if (is_string($value) && str_contains($value, ',') && ! str_contains($value, '.')) {
                $request->merge([$field => str_replace(',', '.', $value)]);
            }
        }
    }

    private function wilayahNtb(): array
    {
        return Kecamatan::query()
            ->orderBy('kabupaten')
            ->orderBy('nama_kecamatan')
            ->get(['kabupaten', 'nama_kecamatan'])
            ->groupBy('kabupaten')
            ->map(fn ($kecamatanList) => $kecamatanList->pluck('nama_kecamatan')->all())
            ->all();
    }

    private function normalizeKelembagaan(array $rows): array
    {
        $normalized = [];

        foreach (['IP3A', 'GP3A', 'P3A'] as $jenis) {
            foreach ($rows[$jenis] ?? [] as $index => $row) {
                $nama = trim((string) ($row['nama_kelembagaan'] ?? ''));
                $ruas = trim((string) ($row['ruas'] ?? ''));

                if ($nama === '' && $ruas === '') {
                    continue;
                }

                if ($nama === '') {
                    throw ValidationException::withMessages([
                        "kelembagaan.$jenis.$index.nama_kelembagaan" => 'Nama kelembagaan wajib diisi jika ruas diisi.',
                    ]);
                }

                $normalized[] = [
                    'jenis_kelembagaan' => $jenis,
                    'nama_kelembagaan' => $nama,
                    'ruas' => $ruas !== '' ? $ruas : null,
                ];
            }
        }

        return $normalized;
    }

    private function storePublicUpload(UploadedFile $file, string $directory): string
    {
        $path = $file->store($directory, 'public');

        if (! is_string($path) || $path === '') {
            throw new RuntimeException("Gagal menyimpan file ke direktori {$directory}.");
        }

        return $path;
    }
}
