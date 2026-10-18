<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSettingSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Admin Pengurus',
            'email' => 'admin.pengurus@nu.or.id',
            'password' => Hash::make('password123'),
        ]);
    }

    public function test_setting_page_does_not_contain_sensitive_diagnostic_info(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.pengaturan.index'));

        $response->assertStatus(200);
        $response->assertSee('Kredensial Akun Administrator');

        // Verify diagnostic specs are removed
        $response->assertDontSee('Status Diagnostik Sistem');
        $response->assertDontSee('Database Driver');
        $response->assertDontSee('Laravel v' . app()->version());
        $response->assertDontSee('PHP ' . PHP_VERSION);
    }

    public function test_admin_can_update_account_info_and_password(): void
    {
        $response = $this->actingAs($this->user)->put(route('admin.pengaturan.update'), [
            'name' => 'Admin Utama Baru',
            'email' => 'admin.baru@nu.or.id',
            'current_password' => 'password123',
            'new_password' => 'newsecretpass',
            'new_password_confirmation' => 'newsecretpass',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->user->refresh();
        $this->assertEquals('Admin Utama Baru', $this->user->name);
        $this->assertEquals('admin.baru@nu.or.id', $this->user->email);
        $this->assertTrue(Hash::check('newsecretpass', $this->user->password));
    }
}
