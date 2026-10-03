<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::current();
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Profile::current();

        $validated = $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'tingkat' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'deskripsi_singkat' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'nilai_organisasi' => 'nullable|string',
            'alamat' => 'required|string|max:255',
            'kontak_email' => 'required|email|max:100',
            'kontak_telepon' => 'required|string|max:50',
            'sk_nomor' => 'nullable|string|max:100',
            'masa_khidmat' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'nama_organisasi.required' => 'Nama organisasi wajib diisi.',
            'alamat.required' => 'Alamat sekretariat wajib diisi.',
            'kontak_email.required' => 'Email kontak wajib diisi.',
            'kontak_telepon.required' => 'Nomor telepon wajib diisi.',
        ]);

        if ($request->hasFile('logo')) {
            if ($profile->logo && Storage::disk('public')->exists($profile->logo)) {
                Storage::disk('public')->delete($profile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('profiles', 'public');
        }

        if ($request->hasFile('hero_image')) {
            if ($profile->hero_image && Storage::disk('public')->exists($profile->hero_image)) {
                Storage::disk('public')->delete($profile->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('profiles', 'public');
        }

        $profile->update($validated);

        return redirect()->route('admin.profil.edit')->with('success', 'Profil organisasi PRNU Banjaranyar berhasil diperbarui.');
    }
}
