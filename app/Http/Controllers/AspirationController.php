<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;

class AspirationController extends Controller
{
    public function create()
    {
        return view('aspiration.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:100',
            'kategori' => 'required|in:Saran,Kritik,Aspirasi,Pengaduan,Pertanyaan',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string|min:10',
        ], [
            'nama.required' => 'Nama lengkap atau inisial wajib diisi.',
            'kategori.required' => 'Pilih salah satu kategori aspirasi.',
            'subjek.required' => 'Subjek atau judul pesan wajib diisi.',
            'pesan.required' => 'Uraian pesan atau aspirasi wajib diisi.',
            'pesan.min' => 'Pesan minimal terdiri dari 10 karakter.',
        ]);

        $kodeTiket = Aspiration::generateTiket();

        $aspiration = Aspiration::create([
            'kode_tiket' => $kodeTiket,
            'nama' => $validated['nama'],
            'kontak' => $validated['kontak'] ?? null,
            'kategori' => $validated['kategori'],
            'subjek' => $validated['subjek'],
            'pesan' => $validated['pesan'],
            'status' => 'Baru',
        ]);

        return redirect()->route('aspirasi.create')->with([
            'success' => 'Alhamdulillah, aspirasi Anda telah berhasil dikirim kepada pengurus PRNU Banjaranyar.',
            'kode_tiket' => $kodeTiket,
        ]);
    }

    public function track(Request $request)
    {
        $kodeTiket = $request->query('kode_tiket');
        $aspiration = null;

        if ($kodeTiket) {
            $aspiration = Aspiration::where('kode_tiket', trim($kodeTiket))->first();
        }

        return view('aspiration.track', compact('aspiration', 'kodeTiket'));
    }
}
