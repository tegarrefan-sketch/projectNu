@extends('layouts.admin')

@section('title', 'Kotak Aspirasi & Aduan Warga — SIMNU Admin')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-rose-100 text-rose-800">
                    Amanat Warga
                </span>
            </div>
            <h1 class="text-2xl font-black text-[#004125] mt-1">Kotak Aspirasi & Saran Masyarakat</h1>
            <p class="text-xs text-[#526350]">Dengarkan suara jama'ah dan warga Desa Banjaranyar secara langsung, transparan, dan terarah.</p>
        </div>
    </div>

    <!-- 4 Metrics Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Aspirasi</span>
            <div class="text-2xl font-black text-gray-900 mt-1">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-rose-600">Belum Ditinjau (Baru)</span>
            <div class="text-2xl font-black text-rose-600 mt-1">{{ number_format($stats['baru']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-500">Sedang Diproses</span>
            <div class="text-2xl font-black text-amber-600 mt-1">{{ number_format($stats['diproses']) }}</div>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-[#e6eeff] shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Telah Selesai</span>
            <div class="text-2xl font-black text-emerald-700 mt-1">{{ number_format($stats['selesai']) }}</div>
        </div>
    </div>

    <!-- Filter Console -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm">
        <form action="{{ route('admin.aspirasi.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            
            <div class="lg:col-span-3 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">call</span>
                <input type="text" name="whatsapp" value="{{ request('whatsapp') }}" placeholder="Cari No. WhatsApp..." 
                    class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
            </div>

            <div class="lg:col-span-3 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">person</span>
                <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari Nama Pengirim..." 
                    class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
            </div>

            <div class="lg:col-span-2">
                <select name="kategori" class="w-full py-2.5 px-3 text-xs sm:text-sm rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua Kategori</option>
                    <option value="Saran" {{ request('kategori') === 'Saran' ? 'selected' : '' }}>Saran</option>
                    <option value="Kritik" {{ request('kategori') === 'Kritik' ? 'selected' : '' }}>Kritik</option>
                    <option value="Aspirasi" {{ request('kategori') === 'Aspirasi' ? 'selected' : '' }}>Aspirasi</option>
                    <option value="Pengaduan" {{ request('kategori') === 'Pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                    <option value="Pertanyaan" {{ request('kategori') === 'Pertanyaan' ? 'selected' : '' }}>Pertanyaan</option>
                </select>
            </div>

            <div class="lg:col-span-2">
                <select name="status" class="w-full py-2.5 px-3 text-xs sm:text-sm rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                    <option value="">Semua Status</option>
                    <option value="Baru" {{ request('status') === 'Baru' ? 'selected' : '' }}>Baru</option>
                    <option value="Dibaca" {{ request('status') === 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
                    <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 min-h-[44px] py-2 px-3 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-bold transition flex items-center justify-center gap-1 shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">search</span>
                    <span>Cari</span>
                </button>
                @if(request()->anyFilled(['q', 'whatsapp', 'nama', 'kategori', 'status']))
                    <a href="{{ route('admin.aspirasi.index') }}" class="min-h-[44px] px-3.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-semibold flex items-center justify-center" title="Reset">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Table & Mobile Stacked Cards -->
    <div class="bg-white rounded-3xl border border-[#e6eeff] shadow-sm overflow-hidden">
        {{-- Mobile Stacked Cards (sm:hidden) --}}
        <div class="block sm:hidden divide-y divide-gray-100">
            @forelse($aspirations as $asp)
                @php
                    $cleanContact = preg_replace('/[^0-9]/', '', $asp->kontak ?? '');
                    if (str_starts_with($cleanContact, '0')) {
                        $cleanContact = '62' . substr($cleanContact, 1);
                    }
                    $waText = rawurlencode("Assalamu'alaikum wr. wb. " . ($asp->is_anonim ? 'Bapak/Ibu' : $asp->nama) . ",\n\nMenindaklanjuti informasi pelacakan aspirasi Anda di SIMNU PRNU Banjaranyar, berikut kode tiket lengkap Anda:\n\n*Kode Tiket:* " . $asp->kode_tiket . "\n*Kategori:* " . $asp->kategori . "\n*Status:* " . $asp->status . "\n\nAnda dapat melacak progresnya secara langsung melalui tautan berikut:\n" . route('aspirasi.track', ['kode_tiket' => $asp->kode_tiket]) . "\n\nTerima kasih atas partisipasinya.\n_Pengurus Ranting NU Banjaranyar_");
                @endphp
                <div class="p-4 space-y-3 {{ $asp->status === 'Baru' ? 'bg-rose-50/20' : '' }}">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="flex items-center gap-1.5 font-mono font-bold text-xs text-[#004125]">
                                <span>{{ $asp->kode_tiket }}</span>
                                <button type="button" onclick="navigator.clipboard.writeText('{{ $asp->kode_tiket }}'); alert('Kode tiket disalin: {{ $asp->kode_tiket }}')" class="text-gray-400 hover:text-emerald-700 transition" title="Salin Kode Tiket">
                                    <span class="material-symbols-outlined text-[15px]">content_copy</span>
                                </button>
                            </div>
                            <span class="text-[10px] text-gray-400">{{ $asp->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-1 justify-end">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                {{ $asp->kategori === 'Pengaduan' ? 'bg-rose-100 text-rose-800' : '' }}
                                {{ $asp->kategori === 'Saran' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $asp->kategori === 'Aspirasi' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $asp->kategori === 'Kritik' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $asp->kategori === 'Pertanyaan' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ $asp->kategori }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                {{ $asp->status === 'Baru' ? 'bg-rose-100 text-rose-800' : '' }}
                                {{ $asp->status === 'Dibaca' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $asp->status === 'Diproses' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $asp->status === 'Selesai' ? 'bg-emerald-100 text-emerald-800' : '' }}">
                                {{ $asp->status }}
                            </span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-3 space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Pengirim:</span>
                            <span class="font-bold text-gray-900 text-right">{{ $asp->nama }} ({{ $asp->kontak ?? '-' }})</span>
                        </div>
                        <div>
                            <span class="text-gray-500 font-medium block">Subjek:</span>
                            <strong class="text-gray-900 block mt-0.5">{{ $asp->subjek }}</strong>
                        </div>
                        <div>
                            <span class="text-gray-500 font-medium block">Pesan:</span>
                            <p class="text-gray-700 mt-0.5 line-clamp-3 text-[11px] leading-relaxed">{{ $asp->pesan }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 pt-1">
                        <a href="{{ route('admin.aspirasi.show', $asp->id) }}" class="flex-1 min-h-[40px] py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-1.5 shadow-sm">
                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                            <span>Buka & Tindak</span>
                        </a>
                        @if(!empty($cleanContact) && !$asp->is_anonim)
                            <a href="https://wa.me/{{ $cleanContact }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="min-h-[40px] px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs flex items-center justify-center gap-1 shadow-xs" title="Bantu Pengirim via WhatsApp">
                                <span class="material-symbols-outlined text-[16px] text-emerald-600">chat</span>
                                <span>Bantu WA</span>
                            </a>
                        @endif
                        <form action="{{ route('admin.aspirasi.destroy', $asp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aspirasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="min-h-[40px] min-w-[40px] px-3 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center border border-rose-200" title="Hapus">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-gray-400 font-semibold text-xs">Belum ada aspirasi masyarakat yang masuk.</div>
            @endforelse
        </div>

        {{-- Desktop Table (hidden sm:block) --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 text-[#526350] font-bold uppercase tracking-wider text-[10px] bg-gray-50/50">
                        <th class="py-3.5 px-4">Tiket</th>
                        <th class="py-3.5 px-3">Nama Pengirim</th>
                        <th class="py-3.5 px-3">Kategori</th>
                        <th class="py-3.5 px-3">Subjek & Pesan</th>
                        <th class="py-3.5 px-3">Status</th>
                        <th class="py-3.5 px-3">Waktu Kirim</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($aspirations as $asp)
                        @php
                            $cleanContact = preg_replace('/[^0-9]/', '', $asp->kontak ?? '');
                            if (str_starts_with($cleanContact, '0')) {
                                $cleanContact = '62' . substr($cleanContact, 1);
                            }
                            $waText = rawurlencode("Assalamu'alaikum wr. wb. " . ($asp->is_anonim ? 'Bapak/Ibu' : $asp->nama) . ",\n\nMenindaklanjuti informasi pelacakan aspirasi Anda di SIMNU PRNU Banjaranyar, berikut kode tiket lengkap Anda:\n\n*Kode Tiket:* " . $asp->kode_tiket . "\n*Kategori:* " . $asp->kategori . "\n*Status:* " . $asp->status . "\n\nAnda dapat melacak progresnya secara langsung melalui tautan berikut:\n" . route('aspirasi.track', ['kode_tiket' => $asp->kode_tiket]) . "\n\nTerima kasih atas partisipasinya.\n_Pengurus Ranting NU Banjaranyar_");
                        @endphp
                        <tr class="hover:bg-emerald-50/20 transition {{ $asp->status === 'Baru' ? 'bg-rose-50/20 font-medium' : '' }}">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1.5 font-mono font-bold text-xs text-[#004125]">
                                    <span class="select-all">{{ $asp->kode_tiket }}</span>
                                    <button type="button" onclick="navigator.clipboard.writeText('{{ $asp->kode_tiket }}'); alert('Kode tiket disalin: {{ $asp->kode_tiket }}')" class="text-gray-400 hover:text-emerald-700 transition" title="Salin Kode Tiket">
                                        <span class="material-symbols-outlined text-[15px]">content_copy</span>
                                    </button>
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <div class="font-bold text-gray-900">{{ $asp->nama }}</div>
                                <div class="text-[10px] text-gray-400">{{ $asp->kontak ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    {{ $asp->kategori === 'Pengaduan' ? 'bg-rose-100 text-rose-800' : '' }}
                                    {{ $asp->kategori === 'Saran' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $asp->kategori === 'Aspirasi' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $asp->kategori === 'Kritik' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $asp->kategori === 'Pertanyaan' ? 'bg-purple-100 text-purple-800' : '' }}">
                                    {{ $asp->kategori }}
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                <div class="font-bold text-gray-900 line-clamp-1">{{ $asp->subjek }}</div>
                                <div class="text-[10px] text-gray-400 line-clamp-1">{{ $asp->pesan }}</div>
                            </td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase
                                    {{ $asp->status === 'Baru' ? 'bg-rose-100 text-rose-800' : '' }}
                                    {{ $asp->status === 'Dibaca' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $asp->status === 'Diproses' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $asp->status === 'Selesai' ? 'bg-emerald-100 text-emerald-800' : '' }}">
                                    <span>{{ $asp->status }}</span>
                                </span>
                            </td>
                            <td class="py-3 px-3 text-gray-500 text-[11px]">
                                {{ $asp->created_at->diffForHumans() }}
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if(!empty($cleanContact) && !$asp->is_anonim)
                                        <a href="https://wa.me/{{ $cleanContact }}?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-[11px] transition inline-flex items-center gap-1 shadow-xs" title="Bantu Pengirim via WhatsApp">
                                            <span class="material-symbols-outlined text-[14px] text-emerald-600">chat</span>
                                            <span>Bantu WA</span>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.aspirasi.show', $asp->id) }}" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-600 hover:text-white text-[#004125] font-bold text-[11px] transition flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">visibility</span>
                                        <span>Buka & Tindak</span>
                                    </a>
                                    <form action="{{ route('admin.aspirasi.destroy', $asp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aspirasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 rounded-lg bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-700 transition" title="Hapus">
                                            <span class="material-symbols-outlined text-[14px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-400 font-semibold">Belum ada aspirasi masyarakat yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $aspirations->links() }}
        </div>
    </div>

</div>
@endsection
