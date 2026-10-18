@extends('layouts.admin')

@section('title', 'Audit & Verifikasi Infaq Online — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-[#004125]">
                    LAZISNU & ZISWAF
                </span>
            </div>
            <h1 class="text-2xl font-black text-[#004125] mt-1">Audit & Rekap Infaq Online</h1>
            <p class="text-xs text-[#526350]">Verifikasi bukti transfer infaq jamaah dan pantau transparansi dana ummat.</p>
        </div>

        <a href="{{ route('admin.infaq.settings') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#dee9fc] hover:bg-[#eff4ff] text-[#004125] text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">settings</span>
            <span>Pengaturan Rekening & QRIS</span>
        </a>
    </div>

    <!-- 4 Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Total Infaq Terverifikasi</span>
            <div class="text-2xl font-black text-[#004125] mt-1">Rp {{ number_format($totalTerkumpul, 0, ',', '.') }}</div>
            <span class="text-[11px] text-gray-500 font-medium">{{ $countVerified }} donasi sah</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#fe932c]">Menunggu Verifikasi</span>
            <div class="text-2xl font-black text-[#904d00] mt-1">Rp {{ number_format($totalPending, 0, ',', '.') }}</div>
            <span class="text-[11px] text-amber-700 font-bold">{{ $countPending }} transaksi baru</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Riwayat Donasi</span>
            <div class="text-2xl font-black text-gray-800 mt-1">{{ number_format($donations->total()) }}</div>
            <span class="text-[11px] text-gray-500 font-medium">Semua status</span>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm flex flex-col justify-between">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Rekening Pengurus</span>
            <div class="text-sm font-bold text-[#004125]">BSI & Bank Jatim</div>
            <a href="{{ route('admin.infaq.settings') }}" class="text-[11px] text-[#fe932c] hover:underline font-bold">Ubah Rekening →</a>
        </div>
    </div>

    <!-- Filter & Search Console -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.infaq.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            <div class="sm:col-span-7 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari kode transaksi, donatur, no WA..." 
                    class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
            </div>

            <div class="sm:col-span-3">
                <select name="status" class="w-full py-2.5 px-3 text-xs sm:text-sm rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua Status</option>
                    <option value="Menunggu Verifikasi" {{ $status === 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="Terverifikasi" {{ $status === 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="Ditolak" {{ $status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 min-h-[44px] py-2 px-3 rounded-xl bg-[#004125] text-white text-xs font-bold hover:bg-[#0c5a37] transition flex items-center justify-center">
                    Filter
                </button>
                @if($search || $status)
                    <a href="{{ route('admin.infaq.index') }}" class="min-h-[44px] px-3.5 rounded-xl border border-gray-300 text-gray-700 text-xs font-bold hover:bg-gray-100 transition flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table & Mobile Cards of Donations -->
    <div class="bg-white rounded-2xl border border-[#e6eeff] shadow-sm overflow-hidden">
        {{-- Mobile Stacked Cards (sm:hidden) --}}
        <div class="block sm:hidden divide-y divide-[#e6eeff]">
            @forelse ($donations as $d)
                <div class="p-4 space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <span class="font-mono font-bold text-xs text-[#004125] block">{{ $d->kode_transaksi }}</span>
                            <span class="text-[10px] text-gray-400">{{ $d->created_at->translatedFormat('d M Y, H:i') }}</span>
                        </div>
                        <div>
                            @if($d->status === 'Terverifikasi')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    ✓ Terverifikasi
                                </span>
                            @elseif($d->status === 'Ditolak')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800">
                                    ✕ Ditolak
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 animate-pulse">
                                    ⏳ Menunggu
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-3 space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Donatur:</span>
                            <span class="font-bold text-gray-900 text-right">
                                {{ $d->nama_donatur }}
                                @if($d->is_anonim)
                                    <span class="ml-1 px-1.5 py-0.2 rounded text-[9px] bg-gray-200 text-gray-700">Anonim</span>
                                @endif
                            </span>
                        </div>
                        @if($d->nomor_whatsapp)
                            <div class="flex justify-between">
                                <span class="text-gray-500 font-medium">WhatsApp:</span>
                                <span class="font-mono text-gray-800">{{ $d->nomor_whatsapp }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Nominal:</span>
                            <span class="font-mono font-black text-[#004125]">Rp {{ number_format($d->nominal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Metode:</span>
                            <span class="text-gray-700 font-medium">{{ $d->metode_pembayaran }}</span>
                        </div>
                        @if($d->pesan_doa)
                            <div class="pt-1 border-t border-gray-200 text-[11px] text-gray-600 italic">
                                "{{ $d->pesan_doa }}"
                            </div>
                        @endif
                    </div>

                    @if($d->bukti_transfer)
                        <div>
                            <a href="{{ asset('storage/' . $d->bukti_transfer) }}" target="_blank" class="w-full min-h-[44px] py-2 px-3 rounded-xl bg-blue-50 text-blue-700 font-bold text-xs flex items-center justify-center gap-1.5 border border-blue-100">
                                <span class="material-symbols-outlined text-[18px]">image</span>
                                <span>Lihat Bukti Transfer</span>
                            </a>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-2 pt-1">
                        @if($d->status !== 'Terverifikasi')
                            <form action="{{ route('admin.infaq.status', $d->id) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Terverifikasi">
                                <button type="submit" class="w-full min-h-[44px] py-2 px-3 rounded-xl bg-emerald-600 text-white font-bold text-xs flex items-center justify-center gap-1 shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                    <span>Verifikasi</span>
                                </button>
                            </form>
                        @endif

                        @if($d->status !== 'Ditolak')
                            <form action="{{ route('admin.infaq.status', $d->id) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Ditolak">
                                <button type="submit" class="w-full min-h-[44px] py-2 px-3 rounded-xl bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-700 font-bold text-xs flex items-center justify-center gap-1 border border-gray-200">
                                    <span class="material-symbols-outlined text-[16px]">cancel</span>
                                    <span>Tolak</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-gray-400 text-xs">
                    Belum ada catatan transaksi infaq online.
                </div>
            @endforelse
        </div>

        {{-- Desktop Table (hidden sm:block) --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#f8f9ff] text-gray-600 font-bold border-b border-[#e6eeff] uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">Transaksi</th>
                        <th class="py-3.5 px-4">Donatur & Kontak</th>
                        <th class="py-3.5 px-4 text-right">Nominal</th>
                        <th class="py-3.5 px-4">Metode</th>
                        <th class="py-3.5 px-4 text-center">Bukti</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e6eeff] text-gray-800">
                    @forelse ($donations as $d)
                        <tr class="hover:bg-[#f8f9ff] transition-colors">
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-bold text-xs text-[#004125] block">{{ $d->kode_transaksi }}</span>
                                <span class="text-[10px] text-gray-400">{{ $d->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-gray-900 flex items-center gap-1.5">
                                    <span>{{ $d->nama_donatur }}</span>
                                    @if($d->is_anonim)
                                        <span class="px-1.5 py-0.2 rounded text-[9px] bg-gray-100 text-gray-600 font-medium">Anonim</span>
                                    @endif
                                </div>
                                @if($d->nomor_whatsapp)
                                    <span class="text-[11px] text-gray-500 block">{{ $d->nomor_whatsapp }}</span>
                                @endif
                                @if($d->pesan_doa)
                                    <p class="text-[10px] text-gray-500 italic mt-0.5 line-clamp-1">"{{ $d->pesan_doa }}"</p>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap font-mono font-black text-sm text-[#004125]">
                                Rp {{ number_format($d->nominal, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-gray-600">
                                {{ $d->metode_pembayaran }}
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                @if($d->bukti_transfer)
                                    <a href="{{ asset('storage/' . $d->bukti_transfer) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-[11px]">
                                        <span class="material-symbols-outlined text-[14px]">image</span>
                                        <span>Lihat Bukti</span>
                                    </a>
                                @else
                                    <span class="text-gray-400 text-[11px]">Tanpa Bukti</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                @if($d->status === 'Terverifikasi')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        ✓ Terverifikasi
                                    </span>
                                @elseif($d->status === 'Ditolak')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800">
                                        ✕ Ditolak
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 animate-pulse">
                                        ⏳ Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($d->status !== 'Terverifikasi')
                                        <form action="{{ route('admin.infaq.status', $d->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Terverifikasi">
                                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] transition shadow-sm" title="Verifikasi Transaksi Ini">
                                                Verifikasi
                                            </button>
                                        </form>
                                    @endif

                                    @if($d->status !== 'Ditolak')
                                        <form action="{{ route('admin.infaq.status', $d->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Ditolak">
                                            <button type="submit" class="px-2 py-1 rounded-lg bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-700 font-bold text-[11px] transition" title="Tolak">
                                                Tolak
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400">
                                Belum ada catatan transaksi infaq online.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#e6eeff]">
            {{ $donations->links() }}
        </div>
    </div>

</div>
@endsection
