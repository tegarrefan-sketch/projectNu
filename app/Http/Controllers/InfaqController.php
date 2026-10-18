<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\InfaqSetting;
use Illuminate\Http\Request;

class InfaqController extends Controller
{
    public function index()
    {
        $setting = InfaqSetting::current();

        $recentDonations = Donation::verified()
            ->latest('verified_at')
            ->take(6)
            ->get();

        $totalTerkumpul = Donation::verified()->sum('nominal');
        $totalDonatur = Donation::verified()->count();

        return view('infaq.index', compact('setting', 'recentDonations', 'totalTerkumpul', 'totalDonatur'));
    }

    public function store(Request $request)
    {
        $nominalCepat = $request->input('nominal_cepat');
        $nominalManual = $request->input('nominal_manual');

        $nominal = !empty($nominalManual) ? (float) str_replace(['.', ','], '', $nominalManual) : (float) $nominalCepat;

        $request->merge(['nominal' => $nominal]);

        $validated = $request->validate([
            'nominal' => 'required|numeric|min:5000',
            'nama_donatur' => 'nullable|string|max:255',
            'is_anonim' => 'nullable|boolean',
            'nomor_whatsapp' => 'nullable|string|max:30',
            'metode_pembayaran' => 'required|string|max:100',
            'pesan_doa' => 'nullable|string|max:1000',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg,webp,pdf|max:5120',
        ], [
            'nominal.required' => 'Pilih nominal atau masukkan nominal infaq yang dikehendaki.',
            'nominal.min' => 'Infaq minimal adalah Rp 5.000.',
            'metode_pembayaran.required' => 'Pilih metode pembayaran infaq.',
            'bukti_transfer.image' => 'Bukti transfer harus berupa file gambar valid.',
            'bukti_transfer.max' => 'Ukuran file bukti transfer maksimal 5MB.',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('infaq', 'public');
        }

        $isAnonim = $request->boolean('is_anonim') || empty($validated['nama_donatur']);
        $namaDonatur = $isAnonim ? 'Hamba Allah' : trim($validated['nama_donatur']);

        $kodeTransaksi = Donation::generateKode();

        $donation = Donation::create([
            'kode_transaksi' => $kodeTransaksi,
            'nama_donatur' => $namaDonatur,
            'is_anonim' => $isAnonim,
            'nomor_whatsapp' => $validated['nomor_whatsapp'] ?? null,
            'nominal' => $nominal,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'pesan_doa' => $validated['pesan_doa'] ?? null,
            'bukti_transfer' => $buktiPath,
            'status' => 'Menunggu Verifikasi',
        ]);

        return redirect()->route('infaq.index')->with([
            'success' => 'Jazakumullah Khairan Katsiran! Konfirmasi infaq Anda berhasil dikirim. Pengurus LAZISNU Banjaranyar akan segera memverifikasi.',
            'kode_transaksi' => $kodeTransaksi,
            'nominal' => $nominal,
            'nama_donatur' => $namaDonatur,
        ]);
    }
}
