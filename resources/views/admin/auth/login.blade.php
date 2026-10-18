<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Portal Admin — SIMNU Ranting Banjaranyar</title>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #002110;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }
        @media (max-width: 768px) {
            input {
                font-size: 16px !important;
            }
            button, a {
                min-height: 44px;
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 antialiased relative overflow-hidden">
    <!-- Decorative Islamic / Modern Geometric Glow -->
    <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-emerald-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-[#fe932c]/10 blur-3xl pointer-events-none"></div>
    <div class="absolute inset-0 bg-[radial-gradient(#aaf2c4_1px,transparent_1px)] [background-size:24px_24px] opacity-10 pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 space-y-6">
        
        <!-- Brand Card Header -->
        <div class="text-center space-y-2">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#0c5a37] to-[#004125] text-white flex items-center justify-center shadow-lg shadow-emerald-950/40 border border-emerald-400/30 group-hover:scale-105 transition">
                    <span class="material-symbols-outlined text-2xl text-[#aaf2c4]">shield_person</span>
                </div>
                <div class="text-left">
                    <span class="block text-xl font-extrabold text-white tracking-tight leading-tight">SIMNU Portal</span>
                    <span class="block text-xs font-semibold text-emerald-300">PRNU Banjaranyar</span>
                </div>
            </a>
            <p class="text-xs text-emerald-200/80">Sistem Manajemen & Basis Data Terpadu Organisasi</p>
        </div>

        <!-- Login Form Card -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-2xl border border-white/20 space-y-6">
            
            <div class="space-y-1 text-center">
                <h1 class="text-2xl font-extrabold text-[#004125] tracking-tight">Otentikasi Pengurus</h1>
                <p class="text-xs text-[#526350]">Masukkan kredensial akun administrator untuk mengelola sistem</p>
            </div>

            @if(session('info'))
                <div class="p-3.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-900 text-xs font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600 text-base">info</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-900 text-xs font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-600 text-base">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#004125]">
                        Alamat Email Resmi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg">mail</span>
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@nu-banjaranyar.or.id') }}" required autofocus
                            class="w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-500 bg-red-50/50' : 'border-gray-200 focus:border-[#0c5a37] focus:ring-2 focus:ring-[#0c5a37]/20' }} text-sm transition font-medium text-gray-900"
                            placeholder="nama@nu-banjaranyar.or.id">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-600 font-semibold flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">warning</span>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#004125]">
                            Kata Sandi <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg">lock</span>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-10 pr-10 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-500 bg-red-50/50' : 'border-gray-200 focus:border-[#0c5a37] focus:ring-2 focus:ring-[#0c5a37]/20' }} text-sm transition font-medium text-gray-900"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <span class="material-symbols-outlined text-lg" id="passwordToggleIcon">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 font-semibold flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">warning</span>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-gray-600 font-medium">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#0c5a37] focus:ring-[#0c5a37] border-gray-300">
                        <span>Ingat sesi masuk</span>
                    </label>
                    <span class="text-xs text-emerald-800 font-semibold cursor-help" title="Silakan hubungi administrator IT cabang/ranting jika kehilangan akses">Bantuan Akses?</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-[#004125] to-[#0c5a37] hover:from-[#0c5a37] hover:to-[#004125] text-white text-sm font-extrabold tracking-wide shadow-lg shadow-emerald-950/20 transition-all flex items-center justify-center gap-2 group">
                    <span>Masuk ke Konsol</span>
                    <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>

            <!-- Dev Credentials Quick Info Badge -->
            <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-200 text-xs text-emerald-900 space-y-1">
                <div class="font-bold flex items-center gap-1.5 text-emerald-950">
                    <span class="material-symbols-outlined text-sm text-[#004125]">key</span>
                    <span>Kredensial Development / Pengurus:</span>
                </div>
                <div class="font-mono text-[11px] text-emerald-800 space-y-0.5">
                    <div>Email: <strong class="text-[#004125]">admin@nu-banjaranyar.or.id</strong></div>
                    <div>Kata Sandi: <strong class="text-[#004125]">admin123</strong></div>
                </div>
            </div>

            <!-- Footer Return Link -->
            <div class="text-center pt-2">
                <a href="{{ route('home') }}" class="text-xs font-bold text-gray-500 hover:text-[#004125] transition inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    <span>Kembali ke Website Publik</span>
                </a>
            </div>
        </div>

        <p class="text-center text-[11px] text-emerald-300/60 font-medium">
            &copy; {{ date('Y') }} Pengurus Ranting Nahdlatul Ulama Desa Banjaranyar. Terenkripsi SSL 256-bit.
        </p>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                pwd.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>
