<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\InfaqSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfaqController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('q');

        $query = Donation::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'LIKE', "%{$search}%")
                  ->orWhere('nama_donatur', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_whatsapp', 'LIKE', "%{$search}%");
            });
        }

        $donations = $query->latest('created_at')->paginate(12)->withQueryString();

        $totalTerkumpul = Donation::where('status', 'Terverifikasi')->sum('nominal');
        $totalPending = Donation::where('status', 'Menunggu Verifikasi')->sum('nominal');
        $countPending = Donation::where('status', 'Menunggu Verifikasi')->count();
        $countVerified = Donation::where('status', 'Terverifikasi')->count();

        return view('admin.infaq.index', compact(
            'donations',
            'status',
            'search',
            'totalTerkumpul',
            'totalPending',
            'countPending',
            'countVerified'
        ));
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'status' => 'required|in:Terverifikasi,Ditolak,Menunggu Verifikasi',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $donation->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? null,
            'verified_at' => $validated['status'] === 'Terverifikasi' ? now() : null,
        ]);

        return back()->with('success', "Status infaq {$donation->kode_transaksi} berhasil diubah menjadi {$validated['status']}.");
    }

    public function settings()
    {
        $setting = InfaqSetting::current();
        return view('admin.infaq.settings', compact('setting'));
    }

    public function updateSettings(Request $request)
    {
        $setting = InfaqSetting::current();

        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi_program' => 'nullable|string',
            'bank_utama_nama' => 'required|string|max:100',
            'bank_utama_rekening' => 'required|string|max:50',
            'bank_utama_atas_nama' => 'required|string|max:150',
            'bank_kedua_nama' => 'nullable|string|max:100',
            'bank_kedua_rekening' => 'nullable|string|max:50',
            'bank_kedua_atas_nama' => 'nullable|string|max:150',
            'nomor_whatsapp_konfirmasi' => 'nullable|string|max:30',
            'pesan_amanah' => 'nullable|string',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('qris_image')) {
            if ($setting->qris_image) {
                Storage::disk('public')->delete($setting->qris_image);
            }
            $validated['qris_image'] = $request->file('qris_image')->store('infaq', 'public');
        }

        $setting->update($validated);

        return back()->with('success', 'Pengaturan rekening dan QRIS Infaq Online berhasil disimpan.');
    }
}
