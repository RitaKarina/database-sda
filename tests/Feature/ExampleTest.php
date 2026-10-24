<?php

namespace Tests\Feature;

use App\Models\DaerahIrigasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_daerah_irigasi_detail_page_loads_for_existing_record(): void
    {
        DaerahIrigasi::create([
            'nama_di' => 'Contoh DI',
            'kode_di' => 'DI-001',
            'luas_baku' => 120.50,
            'luas_potensial' => 150.00,
            'luas_fungsional' => 130.00,
            'status_fungsi' => 'Baik',
        ]);

        $response = $this->actingAs(User::factory()->create())
            ->get('/daerah-irigasi/'.DaerahIrigasi::first()->id);

        $response->assertStatus(200);
        $response->assertSee('Contoh DI');
    }
}
