<?php

namespace App\Http\Controllers;

use App\Models\Kta;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

class KtaVerificationController extends Controller
{
    /**
     * Public page to search / scan KTA and print directly
     */
    public function index(Request $request)
    {
        $nomorKta = trim($request->input('nomor_kta', $request->input('q', '')));
        $tanggalLahir = trim($request->input('tanggal_lahir', ''));

        $foundKta = null;
        $searched = false;

        if ($request->filled('nomor_kta') || $request->filled('q') || $request->filled('tanggal_lahir')) {
            $searched = true;

            // Cari KTA hanya lewat Nomor KTA (bukan NIK) dan verifikasi kedua (tanggal lahir)
            if (!empty($nomorKta) && !empty($tanggalLahir)) {
                $nomorKtaUpper = strtoupper($nomorKta);

                $foundKta = Kta::whereHas('member', function ($q) use ($tanggalLahir) {
                        $q->whereDate('tanggal_lahir', $tanggalLahir);
                    })
                    ->with(['member.banom'])
                    ->where('nomor_kta', $nomorKtaUpper)
                    ->where('status', 'Aktif')
                    ->first();

                if ($foundKta && empty($foundKta->qr_code_svg)) {
                    $verifyUrl = route('kta.verify', $foundKta->nomor_kta);
                    $foundKta->update([
                        'qr_code_svg' => QrCodeService::generateDataUri($verifyUrl),
                    ]);
                }
            }
        }

        return view('kta.verify-search', compact('nomorKta', 'tanggalLahir', 'foundKta', 'searched'));
    }

    /**
     * Verification result page for a specific KTA number or Member identifier
     */
    public function verify(string $nomor_kta)
    {
        $identifier = trim(strtoupper($nomor_kta));
        $kta = Kta::whereHas('member')
            ->with(['member.banom'])
            ->where('nomor_kta', $identifier)
            ->first();

        if ($kta && empty($kta->qr_code_svg)) {
            $verifyUrl = route('kta.verify', $kta->nomor_kta);
            $kta->update([
                'qr_code_svg' => QrCodeService::generateDataUri($verifyUrl),
            ]);
        }

        return view('kta.verify-result', compact('kta', 'nomor_kta'));
    }

    /**
     * Dedicated printable KTA Card format (85.6 x 54 mm) without navbar/footer
     */
    public function print(string $nomor_kta)
    {
        $identifier = trim(strtoupper($nomor_kta));
        $kta = Kta::whereHas('member')
            ->with(['member.banom'])
            ->where('nomor_kta', $identifier)
            ->firstOrFail();

        if (empty($kta->qr_code_svg)) {
            $verifyUrl = route('kta.verify', $kta->nomor_kta);
            $kta->update([
                'qr_code_svg' => QrCodeService::generateDataUri($verifyUrl),
            ]);
        }

        return view('kta.public-print', compact('kta'));
    }

    /**
     * Dedicated PDF download / print page
     */
    public function downloadPdf(string $nomor_kta)
    {
        $identifier = trim(strtoupper($nomor_kta));
        $kta = Kta::whereHas('member')
            ->with(['member.banom'])
            ->where('nomor_kta', $identifier)
            ->firstOrFail();

        if (empty($kta->qr_code_svg)) {
            $verifyUrl = route('kta.verify', $kta->nomor_kta);
            $kta->update([
                'qr_code_svg' => QrCodeService::generateDataUri($verifyUrl),
            ]);
        }

        return view('kta.public-print', ['kta' => $kta, 'autoPrint' => true]);
    }
}
