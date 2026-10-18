<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use App\Models\Member;
use Illuminate\Http\Request;

class AspirationController extends Controller
{
    public function create()
    {
        $selectedMemberId = old('member_select');
        $selectedMember = ($selectedMemberId && is_numeric($selectedMemberId))
            ? Member::with('banom')->find($selectedMemberId)
            : null;

        $kodeTiket = session('kode_tiket');
        $aspiration = null;
        if ($kodeTiket) {
            $aspiration = Aspiration::where('kode_tiket', $kodeTiket)->first();
        }

        return view('aspiration.create', compact('selectedMember', 'aspiration'));
    }

    public function searchMember(Request $request)
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

    public function store(Request $request)
    {
        $memberSelect = $request->input('member_select');
        $namaCustom = trim($request->input('nama_custom', $request->input('nama', '')));

        // 3. Aspirasi anonim: jangan menyimpan data identitas apapun (nama anonim, kontak null)
        $isAnonim = ($memberSelect === 'anonim');

        if ($isAnonim) {
            $finalName = 'Warga Banjaranyar (Anonim)';
            $kontak = null;
        } elseif ($memberSelect === 'bukan_anggota') {
            $finalName = !empty($namaCustom) ? $namaCustom : 'Warga Desa Banjaranyar';
            $kontak = $request->input('kontak');
        } elseif (!empty($memberSelect)) {
            $member = Member::find($memberSelect);
            if ($member) {
                $finalName = $member->nama_lengkap;
            } else {
                $finalName = !empty($namaCustom) ? $namaCustom : 'Warga Banjaranyar';
            }
            $kontak = $request->input('kontak');
        } else {
            $finalName = !empty($namaCustom) ? $namaCustom : 'Warga Desa Banjaranyar';
            $kontak = $request->input('kontak');
        }

        $validated = $request->validate([
            'kontak' => 'nullable|string|max:100',
            'kategori' => 'required|in:Saran,Kritik,Aspirasi,Pengaduan,Pertanyaan',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string|min:10',
        ], [
            'kategori.required' => 'Silakan pilih salah satu kategori aspirasi.',
            'subjek.required' => 'Subjek atau inti aspirasi wajib diisi.',
            'pesan.required' => 'Uraian aspirasi / masukan wajib diisi.',
            'pesan.min' => 'Aspirasi minimal terdiri dari 10 karakter.',
        ]);

        try {
            // 1. Kode tiket baru tidak bisa ditebak (unpredictable, minimal 6 karakter alfanumerik acak)
            $kodeTiket = Aspiration::generateTiket();

            $aspiration = Aspiration::create([
                'kode_tiket' => $kodeTiket,
                'nama' => $finalName,
                'kontak' => $kontak,
                'is_anonim' => $isAnonim,
                'kategori' => $validated['kategori'],
                'subjek' => $validated['subjek'],
                'pesan' => $validated['pesan'],
                'status' => 'Baru',
            ]);

            return redirect()->route('aspirasi.create')->with([
                'success' => 'Alhamdulillah, pesan ' . strtolower($validated['kategori']) . ' Anda telah berhasil kami terima. Pengurus PRNU Banjaranyar akan menindaklanjuti dengan penuh amanah.',
                'kode_tiket' => $kodeTiket,
            ]);
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Terjadi kendala saat mengirim pesan pengaduan. Silakan coba kembali.');
        }
    }

    public function track(Request $request)
    {
        $kodeTiket = trim($request->query('kode_tiket', ''));
        $aspiration = null;

        if ($kodeTiket !== '') {
            $aspiration = Aspiration::where('kode_tiket', $kodeTiket)->first();
        }

        return view('aspiration.track', [
            'aspiration' => $aspiration,
            'kodeTiket' => $kodeTiket,
            'foundTickets' => null,
            'searched' => false,
            'searchedWhatsapp' => '',
        ]);
    }

    public function forgotTicket(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required|string|min:4',
        ], [
            'whatsapp.required' => 'Silakan masukkan nomor WhatsApp yang Anda gunakan saat mengirim aspirasi.',
            'whatsapp.min' => 'Nomor WhatsApp minimal 4 digit.',
        ]);

        $rawPhone = trim($request->input('whatsapp'));
        $cleanPhone = Aspiration::cleanPhoneNumber($rawPhone);

        $foundTickets = collect();
        if (!empty($cleanPhone) && strlen($cleanPhone) >= 4) {
            $altPhone = str_starts_with($cleanPhone, '0') ? ('62' . substr($cleanPhone, 1)) : ('0' . substr($cleanPhone, 2));

            // 4. Hanya untuk aspirasi yang TIDAK anonim dan menyimpan nomor tersebut
            // JANGAN tampilkan isi pesan, balasan admin, nama, atau kode lengkap.
            $foundTickets = Aspiration::where('is_anonim', false)
                ->whereNotNull('kontak')
                ->where('kontak', '!=', '')
                ->where(function ($q) use ($rawPhone, $cleanPhone, $altPhone) {
                    $q->where('kontak', 'LIKE', "%{$cleanPhone}%")
                      ->orWhere('kontak', 'LIKE', "%{$rawPhone}%")
                      ->orWhere('kontak', 'LIKE', "%{$altPhone}%");
                })
                ->latest()
                ->take(10)
                ->get(['id', 'kode_tiket', 'status', 'created_at']);
        }

        $searched = true;

        return view('aspiration.track', [
            'aspiration' => null,
            'kodeTiket' => '',
            'foundTickets' => $foundTickets,
            'searched' => $searched,
            'searchedWhatsapp' => $rawPhone,
        ]);
    }

    public function downloadCard(string $kodeTiket)
    {
        $aspiration = Aspiration::where('kode_tiket', trim($kodeTiket))->firstOrFail();

        $width = 720;
        $height = 420;
        $im = imagecreatetruecolor($width, $height);

        $bg = imagecolorallocate($im, 248, 250, 255);
        $primary = imagecolorallocate($im, 0, 65, 37);
        $container = imagecolorallocate($im, 12, 90, 55);
        $white = imagecolorallocate($im, 255, 255, 255);
        $gold = imagecolorallocate($im, 254, 147, 44);
        $textDark = imagecolorallocate($im, 18, 28, 42);
        $textMuted = imagecolorallocate($im, 82, 99, 80);
        $borderCol = imagecolorallocate($im, 222, 233, 252);

        imagefill($im, 0, 0, $bg);
        imagefilledrectangle($im, 0, 0, $width, 85, $primary);
        imagefilledrectangle($im, 0, 80, $width, 85, $gold);

        imagestring($im, 5, 30, 20, "SIMNU PRNU BANJARANYAR", $white);
        imagestring($im, 3, 30, 48, "BUKTI RESI PELACAKAN ASPIRASI JAMAAH", $gold);

        imagefilledrectangle($im, 25, 105, $width - 25, $height - 20, $white);
        imagerectangle($im, 25, 105, $width - 25, $height - 20, $borderCol);

        imagefilledrectangle($im, 45, 125, $width - 45, 195, $bg);
        imagerectangle($im, 45, 125, $width - 45, 195, $borderCol);

        imagestring($im, 3, 65, 138, "NOMOR TIKET RESMI:", $textMuted);
        imagestring($im, 5, 65, 160, $aspiration->kode_tiket, $primary);

        imagestring($im, 4, 65, 220, "Kategori: " . $aspiration->kategori, $textDark);
        imagestring($im, 4, 65, 245, "Status Terkini: " . $aspiration->status, $container);
        imagestring($im, 4, 65, 270, "Waktu Kirim: " . $aspiration->created_at->format('d/m/Y H:i') . " WIB", $textMuted);
        imagestring($im, 4, 65, 295, "Pengirim: " . ($aspiration->is_anonim ? 'Anonim' : $aspiration->nama), $textMuted);

        imagefilledrectangle($im, 45, 335, $width - 45, 380, $bg);
        imagestring($im, 2, 65, 345, "PENTING: Simpan kode ini untuk melacak status aspirasi Anda di situs SIMNU.", $primary);
        imagestring($im, 2, 65, 360, "Tautan Pelacakan: " . url('/aspirasi/lacak'), $textMuted);

        ob_start();
        imagepng($im);
        $imageData = ob_get_clean();
        imagedestroy($im);

        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="Tiket-' . $aspiration->kode_tiket . '.png"');
    }

    public function downloadPdf(string $kodeTiket)
    {
        $aspiration = Aspiration::where('kode_tiket', trim($kodeTiket))->firstOrFail();
        return view('aspiration.print', compact('aspiration'));
    }
}
