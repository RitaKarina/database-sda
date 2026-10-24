<?php

namespace Tests\Feature;

use App\Models\DaerahIrigasi;
use App\Models\Embung;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EmployeeAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_homepage_displays_public_summaries_and_selected_fields(): void
    {
        DaerahIrigasi::query()->create([
            'nama_di' => 'DI Uji Publik',
            'kabupaten' => ['Kabupaten Uji'],
            'kecamatan' => ['Kecamatan Uji'],
            'luas_fungsional' => 125.5,
            'kewenangan' => 'Provinsi',
            'status_fungsi' => 'Aktif',
            'nama_pengamat' => 'Informasi Internal',
        ]);
        Embung::query()->create([
            'nama_embung' => 'Embung Uji Publik',
            'kabupaten' => 'Kabupaten Uji',
            'kecamatan' => 'Kecamatan Uji',
            'luas_genangan' => 4.5,
        ]);

        $response = $this->get(route('public.home'));

        $response->assertOk()
            ->assertSee('SUMBER DAYA AIR')
            ->assertSee('DI Uji Publik')
            ->assertSee('Kabupaten Uji')
            ->assertSee('125,50 ha')
            ->assertSee('Embung Uji Publik')
            ->assertSee('Daerah Irigasi')
            ->assertSee('data-panel="irigasi"', false)
            ->assertSee('data-panel="embung"', false)
            ->assertSee('btn-login-header')
            ->assertDontSee('public-panel-stack')
            ->assertDontSee('id="irigasi"', false)
            ->assertDontSee('id="embung"', false)
            ->assertDontSee('Informasi Internal');

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Login Pengelola Data')
            ->assertDontSee('Login Pegawai');
    }

    public function test_guest_is_redirected_to_login_from_internal_routes(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('daerah-irigasi.index'))->assertRedirect(route('login'));
        $this->post(route('daerah-irigasi.store'))->assertRedirect(route('login'));
    }

    public function test_employee_can_log_in_and_open_the_dashboard(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Secure-Employee-Password-123!'),
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Secure-Employee-Password-123!',
        ])->assertRedirect(route('dashboard'));

        $this->get(route('dashboard'))->assertOk();
    }

    public function test_invalid_employee_credentials_are_rejected(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Secure-Employee-Password-123!'),
        ]);

        $this->from(route('login'))->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');
    }

    public function test_logout_ends_the_session_and_internal_pages_require_login_again(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('public.home'));

        $this->assertGuest();
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_login_page_has_a_password_visibility_toggle_and_no_public_registration_link(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('toggle-password');

        $this->get('/register')->assertNotFound();
    }
}
