<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use App\Models\Kta;
use App\Models\Member;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $banoms = Banom::orderBy('urutan')->get();
        $banomId = $request->query('banom_id');
        $status = $request->query('status');
        $search = $request->query('q');

        $query = Member::with(['banom', 'kta'])->latest();

        if ($banomId) {
            $query->where('banom_id', $banomId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_anggota', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_telepon', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%");
            });
        }

        $members = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Member::count(),
            'aktif' => Member::where('status', 'Aktif')->count(),
            'tidak_aktif' => Member::where('status', 'Tidak Aktif')->count(),
            'alumni' => Member::where('status', 'Alumni')->count(),
            'has_kta' => Kta::count(),
        ];

        return view('admin.member.index', compact('members', 'banoms', 'banomId', 'status', 'search', 'stats'));
    }

    public function create()
    {
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        return view('admin.member.create', compact('banoms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'banom_id' => 'required|exists:banoms,id',
            'nomor_anggota' => 'nullable|string|max:50|unique:members,nomor_anggota',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'status' => 'required|in:Aktif,Tidak Aktif,Alumni',
            'jabatan' => 'required|string|max:100',
            'tahun_masuk' => 'nullable|integer|min:1950|max:2050',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'generate_kta' => 'nullable|boolean',
        ], [
            'banom_id.required' => 'Pilih Badan Otonom.',
            'nama_lengkap.required' => 'Nama lengkap kader wajib diisi.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'jabatan.required' => 'Jabatan/Amanah wajib diisi (misal: Anggota, Pengurus).',
        ]);

        $banom = Banom::findOrFail($validated['banom_id']);

        if (empty($validated['nomor_anggota'])) {
            $year = $validated['tahun_masuk'] ?? date('Y');
            $count = Member::where('banom_id', $banom->id)->count() + 1;
            $validated['nomor_anggota'] = sprintf('NIA-%s-%s-%04d', strtoupper($banom->singkatan), $year, $count);
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('members', 'public');
        }

        $member = Member::create($validated);

        // Auto generate KTA if requested
        if ($request->boolean('generate_kta')) {
            $nomorKta = Kta::generateKtaNumber($member);
            $verifyUrl = url("/kta/verify/{$nomorKta}");
            $qrDataUri = QrCodeService::generateDataUri($verifyUrl);

            Kta::create([
                'member_id' => $member->id,
                'nomor_kta' => $nomorKta,
                'tanggal_terbit' => now()->toDateString(),
                'tanggal_berlaku' => now()->addYears(3)->toDateString(),
                'status' => 'Aktif',
                'qr_code_svg' => $qrDataUri,
                'keterangan' => 'KTA Otomatis dibuat saat input kader',
            ]);
        }

        return redirect()->route('admin.anggota.index')->with('success', 'Data kader berhasil ditambahkan.');
    }

    public function edit(Member $anggotum)
    {
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        return view('admin.member.edit', ['member' => $anggotum, 'banoms' => $banoms]);
    }

    public function update(Request $request, Member $anggotum)
    {
        $validated = $request->validate([
            'banom_id' => 'required|exists:banoms,id',
            'nomor_anggota' => 'required|string|max:50|unique:members,nomor_anggota,' . $anggotum->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'status' => 'required|in:Aktif,Tidak Aktif,Alumni',
            'jabatan' => 'required|string|max:100',
            'tahun_masuk' => 'nullable|integer|min:1950|max:2050',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($anggotum->foto && Storage::disk('public')->exists($anggotum->foto)) {
                Storage::disk('public')->delete($anggotum->foto);
            }
            $validated['foto'] = $request->file('foto')->store('members', 'public');
        }

        $anggotum->update($validated);

        return redirect()->route('admin.anggota.index')->with('success', 'Data kader berhasil diperbarui.');
    }

    public function destroy(Member $anggotum)
    {
        $anggotum->delete();
        return redirect()->route('admin.anggota.index')->with('success', 'Data kader berhasil dihapus.');
    }
}
