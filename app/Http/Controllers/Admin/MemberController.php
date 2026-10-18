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
        $statusKeanggotaan = $request->query('status_keanggotaan');
        $search = $request->query('q');

        $query = Member::with(['banom', 'kta', 'activeOfficer.position', 'activeOfficer.banom'])->latest();

        if ($banomId) {
            $query->where('banom_id', $banomId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($statusKeanggotaan) {
            $query->where('status_keanggotaan', $statusKeanggotaan);
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

        return view('admin.member.index', compact('members', 'banoms', 'banomId', 'status', 'statusKeanggotaan', 'search', 'stats'));
    }

    public function create()
    {
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        return view('admin.member.create', compact('banoms'));
    }

    public function store(Request $request)
    {
        if (!$request->filled('status_keanggotaan')) {
            $legacyJabatan = $request->input('jabatan', 'Anggota');
            $mappedStatus = match (strtolower((string) $legacyJabatan)) {
                'simpatisan', 'warga' => 'Simpatisan',
                'kader', 'kader aktif', 'kader pratama' => 'Kader',
                default => 'Anggota',
            };
            $request->merge(['status_keanggotaan' => $mappedStatus]);
        }

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
            'status_keanggotaan' => 'required|in:Anggota,Kader,Simpatisan',
            'tahun_masuk' => 'nullable|integer|min:1950|max:2050',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'generate_kta' => 'nullable|boolean',
        ], [
            'banom_id.required' => 'Pilih Badan Otonom.',
            'nama_lengkap.required' => 'Nama lengkap kader wajib diisi.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'status_keanggotaan.required' => 'Pilih status keanggotaan (Anggota, Kader, Simpatisan).',
        ]);

        $banom = Banom::findOrFail($validated['banom_id']);

        if (empty($validated['nomor_anggota'])) {
            $year = isset($validated['tahun_masuk']) ? (int) $validated['tahun_masuk'] : (int) date('Y');
            $validated['nomor_anggota'] = Member::generateMemberNumber($banom, $year);
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('members', 'public');
        }

        // Sinkronkan kolom lama jabatan untuk kompatibilitas data
        $validated['jabatan'] = $validated['status_keanggotaan'];

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

    public function show(Member $anggotum)
    {
        $anggotum->load([
            'banom',
            'kta',
            'activeOfficer.position',
            'activeOfficer.banom',
            'activeOfficer.division',
            'officers.position',
            'officers.banom',
        ]);

        return view('admin.member.show', ['member' => $anggotum]);
    }

    public function edit(Member $anggotum)
    {
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        return view('admin.member.edit', ['member' => $anggotum, 'banoms' => $banoms]);
    }

    public function update(Request $request, Member $anggotum)
    {
        if (!$request->filled('status_keanggotaan')) {
            $legacyJabatan = $request->input('jabatan', $anggotum->status_keanggotaan ?? 'Anggota');
            $mappedStatus = match (strtolower((string) $legacyJabatan)) {
                'simpatisan', 'warga' => 'Simpatisan',
                'kader', 'kader aktif', 'kader pratama' => 'Kader',
                default => 'Anggota',
            };
            $request->merge(['status_keanggotaan' => $mappedStatus]);
        }

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
            'status_keanggotaan' => 'required|in:Anggota,Kader,Simpatisan',
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

        // Sinkronkan kolom lama jabatan untuk kompatibilitas data
        $validated['jabatan'] = $validated['status_keanggotaan'];

        $anggotum->update($validated);

        return redirect()->route('admin.anggota.index')->with('success', 'Data kader berhasil diperbarui.');
    }

    public function destroy(Member $anggotum)
    {
        $anggotum->delete();
        return redirect()->route('admin.anggota.index')->with('success', 'Data kader berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $q = trim($request->query('q', ''));
        if ($q === '') {
            return response()->json([]);
        }

        $members = Member::with(['banom', 'activeOfficer.position'])
            ->where('status', 'Aktif')
            ->where(function ($query) use ($q) {
                $query->where('nomor_anggota', 'LIKE', "%{$q}%")
                      ->orWhere('nama_lengkap', 'LIKE', "%{$q}%");
            })
            ->orderBy('nama_lengkap')
            ->take(10)
            ->get();

        $results = $members->map(function ($m) {
            $jabatan = $m->activeOfficer?->position?->nama ?? $m->jabatan ?? $m->status_keanggotaan;
            return [
                'id' => $m->id,
                'nomor_anggota' => $m->nomor_anggota,
                'nama_lengkap' => $m->nama_lengkap,
                'banom' => $m->banom?->singkatan ?? $m->banom?->nama ?? 'PRNU',
                'jabatan' => $jabatan,
                'foto' => $m->foto ? asset('storage/' . $m->foto) : null,
            ];
        });

        return response()->json($results);
    }
}
