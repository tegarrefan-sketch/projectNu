<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginSecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Halaman /admin/login tidak boleh memuat kata "Kredensial",
     * kotak kredensial bawaan, email admin, atau kata sandi admin.
     */
    public function test_admin_login_page_does_not_contain_credentials_or_default_admin_data(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);

        // Tidak boleh memuat kata "Kredensial" (case-sensitive & insensitive)
        $response->assertDontSee('Kredensial');
        $response->assertDontSee('kredensial');

        // Tidak boleh memuat email admin atau kata sandi bawaan
        $response->assertDontSee('admin@nu-banjaranyar.or.id');
        $response->assertDontSee('admin123');

        // Input email tidak boleh memiliki nilai awal (value) terisi bawaan
        $response->assertDontSee('value="admin@nu-banjaranyar.or.id"');
        $response->assertDontSee("value='admin@nu-banjaranyar.or.id'");
    }

    /**
     * Login dengan kredensial yang benar tetap berhasil dan diarahkan ke dashboard.
     */
    public function test_admin_login_succeeds_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'pengurus.resmi@nu-banjaranyar.or.id',
            'password' => Hash::make('KatasandiKuat2026!'),
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'pengurus.resmi@nu-banjaranyar.or.id',
            'password' => 'KatasandiKuat2026!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Login yang salah menampilkan pesan umum tanpa membocorkan apakah email terdaftar atau tidak.
     */
    public function test_admin_login_with_incorrect_data_shows_generic_error_without_leaking_user_existence(): void
    {
        $user = User::factory()->create([
            'email' => 'terdaftar@nu-banjaranyar.or.id',
            'password' => Hash::make('PasswordValid123!'),
        ]);

        // Percobaan 1: Email ada di database, tetapi kata sandi salah
        $responseWithRegisteredEmail = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
            'email' => 'terdaftar@nu-banjaranyar.or.id',
            'password' => 'KataSandiSalah!',
        ]);

        $responseWithRegisteredEmail->assertRedirect(route('admin.login'));
        $responseWithRegisteredEmail->assertSessionHasErrors('email');

        $registeredError = session('errors')->first('email');

        // Percobaan 2: Email tidak ada di database sama sekali
        $responseWithUnregisteredEmail = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
            'email' => 'tidak.ada.di.database@nu-banjaranyar.or.id',
            'password' => 'KataSandiSalah!',
        ]);

        $responseWithUnregisteredEmail->assertRedirect(route('admin.login'));
        $responseWithUnregisteredEmail->assertSessionHasErrors('email');

        $unregisteredError = session('errors')->first('email');

        // Pesan kesalahan harus persis sama (umum) agar tidak membocorkan keberadaan email
        $this->assertEquals($registeredError, $unregisteredError);
        $this->assertEquals('Kombinasi email dan kata sandi tidak cocok dengan data kami.', $registeredError);
        $this->assertGuest();
    }

    /**
     * Percobaan login dibatasi (throttle) terhadap tebakan kata sandi (5 percobaan per menit per IP dan email).
     */
    public function test_admin_login_is_throttled_to_five_attempts_per_minute_per_ip_and_email(): void
    {
        $targetEmail = 'target.bruteforce@nu-banjaranyar.or.id';

        // 5 percobaan login gagal diperbolehkan masuk ke controller
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->post(route('admin.login.submit'), [
                'email' => $targetEmail,
                'password' => "tebakan-ke-{$i}",
            ]);
            $response->assertStatus(302);
            $response->assertSessionHasErrors('email');
        }

        // Percobaan ke-6 dengan email dan IP yang sama harus diblokir oleh throttle (HTTP 429 Too Many Requests)
        $blockedResponse = $this->post(route('admin.login.submit'), [
            'email' => $targetEmail,
            'password' => 'tebakan-ke-6',
        ]);
        $blockedResponse->assertStatus(429);

        // Email berbeda dari IP yang sama tidak terblokir (membuktikan pembatasan spesifik per email dan IP)
        $differentEmailResponse = $this->post(route('admin.login.submit'), [
            'email' => 'email.lain@nu-banjaranyar.or.id',
            'password' => 'tebakan-pertama',
        ]);
        $differentEmailResponse->assertStatus(302);
    }

    /**
     * AdminSeeder tidak boleh menimpa kata sandi akun admin yang sudah ada di database.
     */
    public function test_admin_seeder_does_not_overwrite_existing_user_password(): void
    {
        $existing = User::factory()->create([
            'email' => 'admin@nu-banjaranyar.or.id',
            'password' => Hash::make('ExistingSecretPassword2026!'),
        ]);

        $seeder = new \Database\Seeders\AdminSeeder();
        $seeder->run();

        $existing->refresh();
        $this->assertTrue(Hash::check('ExistingSecretPassword2026!', $existing->password));
    }

    /**
     * AdminSeeder membaca kata sandi dari variabel lingkungan ADMIN_INITIAL_PASSWORD.
     */
    public function test_admin_seeder_uses_env_password_when_provided(): void
    {
        putenv('ADMIN_INITIAL_PASSWORD=CustomEnvPassword888!');

        $seeder = new \Database\Seeders\AdminSeeder();
        $seeder->run();

        $admin = User::where('email', 'admin@nu-banjaranyar.or.id')->first();
        $this->assertNotNull($admin);
        $this->assertTrue(Hash::check('CustomEnvPassword888!', $admin->password));

        putenv('ADMIN_INITIAL_PASSWORD');
    }

    /**
     * AdminSeeder membuat kata sandi acak yang valid saat ADMIN_INITIAL_PASSWORD kosong.
     */
    public function test_admin_seeder_generates_random_password_when_env_empty(): void
    {
        putenv('ADMIN_INITIAL_PASSWORD=');

        $seeder = new \Database\Seeders\AdminSeeder();
        $seeder->run();

        $admin = User::where('email', 'admin@nu-banjaranyar.or.id')->first();
        $this->assertNotNull($admin);
        $this->assertNotEmpty($admin->password);
    }
}
