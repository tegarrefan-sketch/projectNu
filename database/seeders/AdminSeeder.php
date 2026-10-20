<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@nu-banjaranyar.or.id');
        $existingUser = User::where('email', $email)->first();

        // Seeder tidak boleh menimpa kata sandi akun yang sudah ada
        if ($existingUser) {
            if ($this->command) {
                $this->command->info("Akun admin [{$email}] sudah terdaftar. Kata sandi tidak diubah.");
            }
            return;
        }

        $envPassword = env('ADMIN_INITIAL_PASSWORD');
        $isRandom = false;

        if (empty($envPassword)) {
            $initialPassword = Str::password(16);
            $isRandom = true;
        } else {
            $initialPassword = (string) $envPassword;
        }

        User::create([
            'name' => 'Admin Sekretariat PRNU',
            'email' => $email,
            'password' => Hash::make($initialPassword),
            'email_verified_at' => now(),
        ]);

        if ($this->command) {
            if ($isRandom) {
                $this->command->warn('================================================================');
                $this->command->info("Akun administrator baru berhasil dibuat dengan kata sandi acak:");
                $this->command->line("Email      : {$email}");
                $this->command->line("Kata Sandi : {$initialPassword}");
                $this->command->warn("PENTING: Simpan kata sandi ini sekarang. Pesan ini hanya tampil sekali!");
                $this->command->warn('================================================================');
            } else {
                $this->command->info("Akun administrator [{$email}] berhasil dibuat menggunakan ADMIN_INITIAL_PASSWORD dari .env.");
            }
        }
    }
}
