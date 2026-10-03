<?php

namespace Database\Seeders;

use App\Models\Kta;
use App\Models\Member;
use App\Services\QrCodeService;
use Illuminate\Database\Seeder;

class KtaSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::with('banom')->get();

        foreach ($members as $member) {
            if ($member->kta()->exists()) {
                continue;
            }

            $nomorKta = Kta::generateKtaNumber($member);
            $verifyUrl = url("/kta/verify/{$nomorKta}");
            $qrDataUri = QrCodeService::generateDataUri($verifyUrl);

            Kta::create([
                'member_id' => $member->id,
                'nomor_kta' => $nomorKta,
                'tanggal_terbit' => now()->subMonths(rand(1, 10))->toDateString(),
                'tanggal_berlaku' => now()->addYears(3)->toDateString(),
                'status' => 'Aktif',
                'qr_code_svg' => $qrDataUri,
                'keterangan' => 'KTA Resmi Terdaftar di SIMNU PRNU Banjaranyar',
            ]);
        }
    }
}
