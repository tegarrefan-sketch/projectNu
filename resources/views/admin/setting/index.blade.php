@extends('layouts.admin')

@section('title', 'Pengaturan Akun Administrator — SIMNU Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-800">Admin</a>
                <span>/</span>
                <span class="text-gray-900 font-bold">Pengaturan Akun</span>
            </nav>
            <h1 class="text-2xl font-black text-[#004125]">Pengaturan Akun Administrator</h1>
            <p class="text-xs text-[#526350]">Kelola profil nama, email akses login, dan perbarui kata sandi akun administrator.</p>
        </div>
    </div>

    <!-- Account Settings Form -->
    <div class="max-w-2xl bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-6">
        <div class="border-b border-gray-100 pb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-emerald-600 text-lg">manage_accounts</span>
            <h2 class="text-base font-bold text-[#004125]">Kredensial Akun Administrator</h2>
        </div>

        <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <label for="name" class="block text-xs font-bold uppercase text-[#004125]">
                    Nama Lengkap Pengurus <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                    class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] font-semibold text-gray-900">
                @error('name') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label for="email" class="block text-xs font-bold uppercase text-[#004125]">
                    Alamat Email Akses Masuk <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                    class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37] text-gray-800">
                @error('email') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="pt-3 border-t border-gray-100 space-y-3">
                <div class="flex items-center gap-1.5 text-xs font-bold text-gray-700">
                    <span class="material-symbols-outlined text-[16px] text-gray-500">lock_reset</span>
                    <span>Ganti Kata Sandi (Kosongkan bila tidak ingin mengubah):</span>
                </div>

                <div class="space-y-1">
                    <label for="current_password" class="block text-xs font-medium text-gray-500">
                        Kata Sandi Saat Ini
                    </label>
                    <input type="password" name="current_password" id="current_password" placeholder="Masukkan kata sandi lama Anda"
                        class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    @error('current_password') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label for="new_password" class="block text-xs font-medium text-gray-500">
                            Kata Sandi Baru
                        </label>
                        <input type="password" name="new_password" id="new_password" placeholder="Min. 6 karakter"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                        @error('new_password') <p class="text-[11px] text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="new_password_confirmation" class="block text-xs font-medium text-gray-500">
                            Konfirmasi Kata Sandi Baru
                        </label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Ulangi sandi baru"
                            class="w-full py-2.5 px-3 text-xs rounded-xl border border-gray-200 focus:border-[#0c5a37]">
                    </div>
                </div>
            </div>

            <div class="pt-3">
                <button type="submit" class="w-full py-3 rounded-xl bg-[#004125] hover:bg-[#0c5a37] text-white text-xs font-extrabold transition flex items-center justify-center gap-1.5 shadow-md">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>Perbarui Akun Administrator</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
