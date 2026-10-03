<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BanomController extends Controller
{
    public function index()
    {
        $banoms = Banom::withCount(['members', 'organizationStructures', 'posts', 'events'])
            ->orderBy('urutan')
            ->get();

        return view('admin.banom.index', compact('banoms'));
    }

    public function create()
    {
        return view('admin.banom.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan' => 'required|string|max:30|unique:banoms,singkatan',
            'deskripsi' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'kontak' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'warna_primer' => 'nullable|string|max:20',
            'warna_sekunder' => 'nullable|string|max:20',
            'urutan' => 'nullable|integer',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ], [
            'nama.required' => 'Nama BANOM wajib diisi.',
            'singkatan.required' => 'Singkatan BANOM wajib diisi.',
            'singkatan.unique' => 'Singkatan BANOM sudah terdaftar.',
        ]);

        $validated['slug'] = Str::slug($validated['singkatan']);
        $validated['urutan'] = $validated['urutan'] ?? 0;

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('banom_logos', 'public');
        }

        Banom::create($validated);

        return redirect()->route('admin.banom.index')->with('success', 'Badan Otonom berhasil ditambahkan.');
    }

    public function edit(Banom $banom)
    {
        return view('admin.banom.edit', compact('banom'));
    }

    public function update(Request $request, Banom $banom)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan' => 'required|string|max:30|unique:banoms,singkatan,' . $banom->id,
            'deskripsi' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'kontak' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'warna_primer' => 'nullable|string|max:20',
            'warna_sekunder' => 'nullable|string|max:20',
            'urutan' => 'nullable|integer',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['singkatan']);

        if ($request->hasFile('logo')) {
            if ($banom->logo && Storage::disk('public')->exists($banom->logo)) {
                Storage::disk('public')->delete($banom->logo);
            }
            $validated['logo'] = $request->file('logo')->store('banom_logos', 'public');
        }

        $banom->update($validated);

        return redirect()->route('admin.banom.index')->with('success', 'Data Badan Otonom berhasil diperbarui.');
    }

    public function destroy(Banom $banom)
    {
        $banom->delete();
        return redirect()->route('admin.banom.index')->with('success', 'Badan Otonom berhasil dinonaktifkan/dihapus.');
    }
}
