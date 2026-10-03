<?php

namespace App\Http\Controllers;

use App\Models\Kta;
use Illuminate\Http\Request;

class KtaVerificationController extends Controller
{
    /**
     * Public page to search / scan KTA
     */
    public function index()
    {
        return view('kta.verify-search');
    }

    /**
     * Verification result page for a specific KTA number
     */
    public function verify(string $nomor_kta)
    {
        $nomor_kta = trim(strtoupper($nomor_kta));
        $kta = Kta::with(['member.banom'])
            ->where('nomor_kta', $nomor_kta)
            ->first();

        return view('kta.verify-result', compact('kta', 'nomor_kta'));
    }
}
