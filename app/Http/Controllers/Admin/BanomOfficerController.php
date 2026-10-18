<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BanomOfficer\StoreBanomOfficerRequest;
use App\Http\Requests\Admin\BanomOfficer\UpdateBanomOfficerRequest;
use App\Models\Banom;
use App\Models\BanomOfficer;
use App\Models\Member;
use App\Models\Position;
use App\Services\OfficerPhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BanomOfficerController extends Controller
{
    protected OfficerPhotoService $photoService;

    public function __construct(OfficerPhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    /**
     * Entry point for /admin/pengurus route.
     * Redirects to the active Banom / PRNU officers page.
     */
    public function allOfficers(Request $request)
    {
        $banoms = Banom::orderBy('urutan')->get();
        $banomId = $request->query('banom_id');
        $banom = $banomId ? Banom::find($banomId) : $banoms->first();

        if (!$banom) {
            return redirect()->route('admin.banoms.index')
                ->with('warning', 'Silakan buat data Badan Otonom / Organisasi terlebih dahulu.');
        }

        return redirect()->route('admin.banoms.officers.index', $banom->id);
    }

    public function index(Request $request, Banom $banom)
    {
        $allBanoms = Banom::orderBy('urutan')->get();

        $query = $banom->banomOfficers()
            ->with(['position', 'member', 'division'])
            ->join('positions', 'banom_officers.position_id', '=', 'positions.id')
            ->select('banom_officers.*');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('banom_officers.nama', 'like', "%{$q}%")
                    ->orWhereHas('member', function ($m) use ($q) {
                        $m->where('nama_lengkap', 'like', "%{$q}%")
                            ->orWhere('nomor_anggota', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('position_id')) {
            $query->where('banom_officers.position_id', $request->position_id);
        }

        if ($request->filled('division_id')) {
            $query->where('banom_officers.division_id', $request->division_id);
        }

        $officers = $query->orderBy('positions.urutan_hierarki')
            ->orderBy('positions.urutan')
            ->orderBy('banom_officers.urutan')
            ->get();

        $groupedOfficers = $officers->groupBy(function ($officer) {
            return $officer->position->nama ?? 'Tanpa Jabatan';
        });

        // Deteksi jabatan inti yang belum terisi
        $relevantPositions = Position::forBanom($banom);
        $corePositions = $relevantPositions->where('tipe', 'inti');
        $activeFilledPositionIds = $officers->where('is_active', true)->pluck('position_id')->unique()->toArray();

        $emptyCorePositions = $corePositions->filter(function ($pos) use ($activeFilledPositionIds) {
            return !in_array($pos->id, $activeFilledPositionIds);
        });

        $divisions = $banom->divisions()->orderBy('urutan')->get();
        $positions = $relevantPositions;

        return view('admin.banom_officer.index', compact(
            'banom',
            'allBanoms',
            'officers',
            'groupedOfficers',
            'emptyCorePositions',
            'divisions',
            'positions'
        ));
    }

    public function create(Banom $banom)
    {
        $positions = Position::forBanom($banom);
        $divisions = $banom->divisions()->orderBy('urutan')->get();
        $selectedMemberId = old('member_id', request('member_id'));
        $selectedMember = $selectedMemberId ? Member::with(['banom', 'activeOfficer.position'])->find($selectedMemberId) : null;
        $members = collect();

        $nextUrutan = ($banom->banomOfficers()->max('urutan') ?? 0) + 1;

        $activeOfficersByPosition = $banom->banomOfficers()
            ->reorder()
            ->where('is_active', true)
            ->groupBy('position_id')
            ->selectRaw('position_id, count(*) as count')
            ->pluck('count', 'position_id')
            ->toArray();

        $activeOfficerNamesByPosition = $banom->banomOfficers()
            ->where('is_active', true)
            ->get()
            ->groupBy('position_id')
            ->map(function ($officers) {
                return $officers->map(function ($o) {
                    return $o->display_nama;
                })->implode(', ');
            })
            ->toArray();

        return view('admin.banom_officer.create', compact(
            'banom',
            'positions',
            'divisions',
            'members',
            'selectedMember',
            'nextUrutan',
            'activeOfficersByPosition',
            'activeOfficerNamesByPosition'
        ));
    }

    public function store(StoreBanomOfficerRequest $request, Banom $banom)
    {
        $validated = $request->validated();
        $validated['banom_id'] = $banom->id;
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        // Synchronize nama if member_id is provided
        if (!empty($validated['member_id'])) {
            $member = Member::find($validated['member_id']);
            if ($member) {
                $validated['nama'] = $member->nama_lengkap;
            }
        }

        // Process and compress photo (max 10MB -> WebP, 800px)
        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->photoService->processAndStore($request->file('foto'));
        }

        $position = Position::find($validated['position_id']);
        $replacedOfficerName = null;

        // Jika penggantian pengurus untuk jabatan kuota 1 aktif
        if ($validated['is_active'] && $request->boolean('replace_current') && $position && ($position->batas_keras || $position->maks_orang === 1)) {
            $prevOfficers = BanomOfficer::where('banom_id', $banom->id)
                ->where('position_id', $position->id)
                ->where('is_active', true)
                ->get();

            foreach ($prevOfficers as $prev) {
                $prev->update(['is_active' => false]);
                $replacedOfficerName = $prev->display_nama;
            }
        }

        unset($validated['replace_current']);
        $officer = BanomOfficer::create($validated);

        $msg = $replacedOfficerName
            ? "Pengurus {$officer->display_nama} berhasil ditetapkan sebagai {$position->nama} baru di {$banom->singkatan}. Pengurus lama ({$replacedOfficerName}) telah dinonaktifkan."
            : "Pengurus {$officer->display_nama} berhasil ditambahkan ke {$banom->singkatan}.";

        if ($request->filled('_soft_warning')) {
            session()->flash('warning', $request->input('_soft_warning'));
        }

        return redirect()->route('admin.banoms.officers.index', $banom->id)
            ->with('success', $msg);
    }

    public function edit(Banom $banom, BanomOfficer $officer)
    {
        $positions = Position::forBanom($banom);
        $divisions = $banom->divisions()->orderBy('urutan')->get();
        $selectedMemberId = old('member_id', $officer->member_id);
        $selectedMember = $selectedMemberId ? Member::with(['banom', 'activeOfficer.position'])->find($selectedMemberId) : null;
        $members = collect();

        $activeOfficersByPosition = $banom->banomOfficers()
            ->reorder()
            ->where('is_active', true)
            ->where('id', '!=', $officer->id)
            ->groupBy('position_id')
            ->selectRaw('position_id, count(*) as count')
            ->pluck('count', 'position_id')
            ->toArray();

        return view('admin.banom_officer.edit', compact(
            'banom',
            'officer',
            'positions',
            'divisions',
            'members',
            'selectedMember',
            'activeOfficersByPosition'
        ));
    }

    public function update(UpdateBanomOfficerRequest $request, Banom $banom, BanomOfficer $officer)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', true);

        // Synchronize nama if member_id is provided
        if (!empty($validated['member_id'])) {
            $member = Member::find($validated['member_id']);
            if ($member) {
                $validated['nama'] = $member->nama_lengkap;
            }
        }

        // Process and compress photo, deleting old photo
        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->photoService->processAndStore($request->file('foto'), $officer->foto);
        }

        $officer->update($validated);

        if ($request->filled('_soft_warning')) {
            session()->flash('warning', $request->input('_soft_warning'));
        }

        return redirect()->route('admin.banoms.officers.index', $banom->id)
            ->with('success', "Data pengurus {$officer->display_nama} berhasil diperbarui.");
    }

    public function destroy(Banom $banom, BanomOfficer $officer)
    {
        $nama = $officer->display_nama;

        $this->photoService->deleteOld($officer->foto);
        $officer->delete();

        return redirect()->route('admin.banoms.officers.index', $banom->id)
            ->with('success', "Pengurus {$nama} berhasil dihapus dari {$banom->singkatan}.");
    }

    /**
     * Form "Tambah Banyak Sekaligus".
     */
    public function bulkCreate(Banom $banom)
    {
        $positions = Position::forBanom($banom);
        $divisions = $banom->divisions()->orderBy('urutan')->get();
        $members = Member::where('status', 'Aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'nomor_anggota', 'foto', 'banom_id']);

        return view('admin.banom_officer.bulk_create', compact('banom', 'positions', 'divisions', 'members'));
    }

    /**
     * Simpan banyak pengurus sekaligus dengan chunk insert.
     */
    public function bulkStore(Request $request, Banom $banom)
    {
        $request->validate([
            'position_id' => 'required|exists:positions,id',
            'division_id' => 'nullable|exists:divisions,id',
            'member_ids' => 'required|array|min:1',
            'member_ids.*' => 'exists:members,id',
            'is_active' => 'nullable|boolean',
        ], [
            'position_id.required' => 'Jabatan wajib dipilih.',
            'member_ids.required' => 'Pilih minimal satu anggota untuk ditambahkan.',
            'member_ids.min' => 'Pilih minimal satu anggota.',
        ]);

        $position = Position::findOrFail($request->position_id);
        $isActive = $request->boolean('is_active', true);
        $memberIds = $request->member_ids;
        $countToAdd = count($memberIds);

        // Batas Keras validation
        if ($isActive && ($position->batas_keras || (!is_null($position->maks_orang) && $position->maks_orang === 1))) {
            $query = BanomOfficer::where('banom_id', $banom->id)
                ->where('position_id', $position->id)
                ->where('is_active', true);

            if ($request->filled('division_id')) {
                $query->where('division_id', $request->division_id);
            }

            $currentCount = $query->count();
            $limit = $position->maks_orang ?? 1;

            if ($currentCount + $countToAdd > $limit) {
                return back()->withInput()->withErrors([
                    'position_id' => "Jabatan ini sudah terisi, ubah atau nonaktifkan pengurus lama terlebih dahulu."
                ]);
            }
        }

        // Soft warning check
        $softWarning = null;
        if ($isActive && !$position->batas_keras && $position->hasAnjuran()) {
            $currentCount = BanomOfficer::where('banom_id', $banom->id)
                ->where('position_id', $position->id)
                ->where('is_active', true)
                ->count();
            $newTotal = $currentCount + $countToAdd;
            if ($newTotal > $position->anjuran_maks) {
                $softWarning = "Perhatian: Jumlah {$position->nama} ({$newTotal} orang) melebihi anjuran ({$position->anjuran_maks} orang). Data tetap berhasil disimpan.";
            }
        }

        $members = Member::whereIn('id', $memberIds)->get()->keyBy('id');
        $startUrutan = ($banom->banomOfficers()->max('urutan') ?? 0) + 1;
        $now = now();

        $records = [];
        foreach ($memberIds as $idx => $mId) {
            $m = $members->get($mId);
            $records[] = [
                'banom_id' => $banom->id,
                'position_id' => $position->id,
                'division_id' => $request->division_id,
                'member_id' => $mId,
                'nama' => $m ? $m->nama_lengkap : 'Anggota',
                'foto' => $m ? $m->foto : null,
                'urutan' => $startUrutan + $idx,
                'is_active' => $isActive,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Mulus untuk ratusan anggota: chunk insert 100 record per batch dalam transaksi
        DB::transaction(function () use ($records) {
            foreach (array_chunk($records, 100) as $chunk) {
                BanomOfficer::insert($chunk);
            }
        });

        if ($softWarning) {
            session()->flash('warning', $softWarning);
        }

        return redirect()->route('admin.banoms.officers.index', $banom->id)
            ->with('success', "Berhasil menambahkan {$countToAdd} pengurus ({$position->nama}) ke {$banom->singkatan} sekaligus.");
    }

    public function reorder(Request $request, Banom $banom)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:banom_officers,id',
            'orders.*.urutan' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            BanomOfficer::where('id', $item['id'])
                ->where('banom_id', $banom->id)
                ->update(['urutan' => $item['urutan']]);
        }

        return back()->with('success', 'Urutan pengurus berhasil diperbarui.');
    }

    public function bulkAction(Request $request, Banom $banom)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'officer_ids' => 'required|array',
            'officer_ids.*' => 'exists:banom_officers,id',
        ]);

        $ids = $request->officer_ids;

        if ($request->action === 'activate') {
            BanomOfficer::whereIn('id', $ids)->where('banom_id', $banom->id)->update(['is_active' => true]);
            $msg = count($ids) . " pengurus berhasil diaktifkan.";
        } elseif ($request->action === 'deactivate') {
            BanomOfficer::whereIn('id', $ids)->where('banom_id', $banom->id)->update(['is_active' => false]);
            $msg = count($ids) . " pengurus berhasil dinonaktifkan.";
        } elseif ($request->action === 'delete') {
            $officers = BanomOfficer::whereIn('id', $ids)->where('banom_id', $banom->id)->get();
            foreach ($officers as $officer) {
                $this->photoService->deleteOld($officer->foto);
                $officer->delete();
            }
            $msg = count($ids) . " pengurus berhasil dihapus.";
        }

        return back()->with('success', $msg);
    }
}
