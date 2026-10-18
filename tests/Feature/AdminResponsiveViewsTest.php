<?php

namespace Tests\Feature;

use App\Models\Banom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminResponsiveViewsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Admin Ranting',
            'email' => 'admin.ranting@nu.or.id',
            'password' => Hash::make('password123'),
        ]);

        Banom::create([
            'nama' => 'Gerakan Pemuda Ansor',
            'singkatan' => 'GP Ansor',
            'slug' => 'gp-ansor',
            'warna' => '#0c5a37',
            'urutan' => 1,
            'is_active' => true,
        ]);
    }

    public function test_admin_layout_contains_mobile_viewport_and_offcanvas_sidebar_elements(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('name="viewport"', false);
        $response->assertSee('content="width=device-width, initial-scale=1"', false);
        $response->assertSee('id="adminHamburgerBtn"', false);
        $response->assertSee('id="adminSidebarOverlay"', false);
        $response->assertSee('id="adminSidebar"', false);
    }

    public function test_all_admin_modules_render_successfully_without_errors(): void
    {
        $routes = [
            'admin.dashboard',
            'admin.profil.edit',
            'admin.pengaturan.index',
            'admin.banoms.index',
            'admin.positions.index',
            'admin.divisions.index',
            'admin.anggota.index',
            'admin.kta.index',
            'admin.berita.index',
            'admin.agenda.index',
            'admin.galeri.index',
            'admin.infaq.index',
            'admin.aspirasi.index',
            'admin.struktur.index',
        ];

        foreach ($routes as $routeName) {
            $response = $this->actingAs($this->user)->get(route($routeName));
            $response->assertStatus(200);
        }
    }

    public function test_login_page_renders_with_responsive_viewport(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $response->assertSee('name="viewport"', false);
        $response->assertSee('content="width=device-width, initial-scale=1"', false);
    }
}
