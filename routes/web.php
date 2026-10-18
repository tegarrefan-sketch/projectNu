<?php

use App\Http\Controllers\Admin\AspirationController as AdminAspirationController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BanomController as AdminBanomController;
use App\Http\Controllers\Admin\BanomOfficerController as AdminBanomOfficerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DivisionController as AdminDivisionController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\InfaqController as AdminInfaqController;
use App\Http\Controllers\Admin\KtaController as AdminKtaController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\OrganizationStructureController as AdminStructureController;
use App\Http\Controllers\Admin\PositionController as AdminPositionController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\AspirationController;
use App\Http\Controllers\BanomController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfaqController;
use App\Http\Controllers\KtaVerificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StructureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Portal Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfileController::class, 'index'])->name('profile');

// Redirect /banom to unified /struktur with tab=banom
Route::redirect('/banom', '/struktur?tab=banom', 301)->name('banom.index');
Route::get('/banom/{slug}', [BanomController::class, 'show'])->name('banom.show');

// Unified Structure (Pengurus Ranting + Badan Otonom)
Route::get('/struktur', [StructureController::class, 'index'])->name('structure.index');

// Warta / Berita
Route::get('/berita', [PostController::class, 'index'])->name('post.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('post.show');

// Agenda Kegiatan & Arsip Otomatis
Route::get('/agenda', [EventController::class, 'index'])->name('event.index');
Route::get('/agenda/arsip', [EventController::class, 'archive'])->name('event.archive');
Route::get('/agenda/{slug}', [EventController::class, 'show'])->name('event.show');

// Galeri Kegiatan & Dokumentasi
Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri.index');
Route::get('/galeri/{slug}', [GalleryController::class, 'show'])->name('galeri.show');

// Infaq Online
Route::get('/infaq', [InfaqController::class, 'index'])->name('infaq.index');
Route::post('/infaq', [InfaqController::class, 'store'])->middleware('throttle:6,1')->name('infaq.store');

// Kirim Aspirasi & Pengaduan (Unified Single Form)
Route::get('/aspirasi', [AspirationController::class, 'create'])->name('aspirasi.create');
Route::post('/aspirasi', [AspirationController::class, 'store'])->middleware('throttle:6,1')->name('aspirasi.store');
Route::get('/pengaduan', function () { return redirect()->route('aspirasi.create', ['kategori' => 'Pengaduan']); })->name('pengaduan');
Route::post('/pengaduan', [AspirationController::class, 'store'])->middleware('throttle:6,1')->name('pengaduan.store');
Route::get('/aspirasi/lacak', [AspirationController::class, 'track'])->middleware('throttle:10,1')->name('aspirasi.track');
Route::post('/aspirasi/lupa-tiket', [AspirationController::class, 'forgotTicket'])->middleware('throttle:10,1')->name('aspirasi.forgot-ticket');
Route::get('/aspirasi/unduh-kartu/{kode_tiket}', [AspirationController::class, 'downloadCard'])->name('aspirasi.download-card');
Route::get('/aspirasi/unduh-pdf/{kode_tiket}', [AspirationController::class, 'downloadPdf'])->name('aspirasi.download-pdf');
Route::get('/anggota-search', [AspirationController::class, 'searchMember'])->name('anggota.search');

// KTA Public Verification, Scanning & Printing
Route::get('/kta/verifikasi', [KtaVerificationController::class, 'index'])->middleware('throttle:6,1')->name('kta.verify.search');
Route::get('/kta/verify/{nomor_kta}', [KtaVerificationController::class, 'verify'])->name('kta.verify');
Route::get('/kta/cetak/{nomor_kta}', [KtaVerificationController::class, 'print'])->name('kta.public.print');
Route::get('/kta/unduh/{nomor_kta}', [KtaVerificationController::class, 'downloadPdf'])->name('kta.public.download');

/*
|--------------------------------------------------------------------------
| Admin Hidden Authentication Routes
|--------------------------------------------------------------------------
*/
Route::redirect('/admin', '/admin/login');
Route::redirect('/login', '/admin/login');
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Console Routes (Protected by auth middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Profile & SK Management
    Route::get('/profil', [AdminProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [AdminProfileController::class, 'update'])->name('profil.update');

    // Master Jabatan (Positions) CRUD
    Route::resource('positions', AdminPositionController::class);

    // BANOM & Organisasi CRUD (support both admin.banoms.* and admin.banom.*)
    Route::resource('banoms', AdminBanomController::class);
    Route::resource('banom', AdminBanomController::class);

    // Bagian / Divisi (Bidang, Departemen, Seksi, Unit) CRUD
    Route::resource('divisions', AdminDivisionController::class);

    // Pengurus (Entry Point Navigasi Admin)
    Route::get('/pengurus', [AdminBanomOfficerController::class, 'allOfficers'])->name('pengurus.index');

    // Pengurus BANOM CRUD
    Route::prefix('banoms/{banom}')->name('banoms.')->group(function () {
        Route::get('officers/bulk-create', [AdminBanomOfficerController::class, 'bulkCreate'])->name('officers.bulk-create');
        Route::post('officers/bulk-store', [AdminBanomOfficerController::class, 'bulkStore'])->name('officers.bulk-store');
        Route::post('officers/reorder', [AdminBanomOfficerController::class, 'reorder'])->name('officers.reorder');
        Route::post('officers/bulk-action', [AdminBanomOfficerController::class, 'bulkAction'])->name('officers.bulk-action');
        Route::resource('officers', AdminBanomOfficerController::class);
    });
    Route::prefix('banom/{banom}')->name('banom.')->group(function () {
        Route::resource('officers', AdminBanomOfficerController::class);
    });

    // Organization Structure CRUD
    Route::resource('struktur', AdminStructureController::class);

    // Members / Kader CRUD
    Route::get('/anggota-search', [AdminMemberController::class, 'search'])->name('anggota.search');
    Route::resource('anggota', AdminMemberController::class);

    // KTA Management & Printing
    Route::get('/kta', [AdminKtaController::class, 'index'])->name('kta.index');
    Route::post('/kta/generate/{member}', [AdminKtaController::class, 'generate'])->name('kta.generate');
    Route::get('/kta/{ktum}', [AdminKtaController::class, 'show'])->name('kta.show');
    Route::get('/kta/{ktum}/print', [AdminKtaController::class, 'print'])->name('kta.print');
    Route::get('/kta/{ktum}/download', [AdminKtaController::class, 'downloadPdf'])->name('kta.download');
    Route::match(['get', 'post'], '/kta-bulk-print', [AdminKtaController::class, 'bulkPrint'])->name('kta.bulk-print');
    Route::patch('/kta/{ktum}/status', [AdminKtaController::class, 'updateStatus'])->name('kta.status');
    Route::delete('/kta/{ktum}', [AdminKtaController::class, 'destroy'])->name('kta.destroy');

    // News / Warta CRUD
    Route::resource('berita', AdminPostController::class);
    Route::patch('/berita/{beritum}/toggle', [AdminPostController::class, 'togglePublish'])->name('berita.toggle');
    Route::patch('/berita/{beritum}/toggle-publish', [AdminPostController::class, 'togglePublish'])->name('berita.toggle-publish');

    // Event / Agenda CRUD
    Route::resource('agenda', AdminEventController::class);

    // Galeri Kegiatan CRUD
    Route::resource('galeri', AdminGalleryController::class);
    Route::delete('/galeri-photo/{photo}', [AdminGalleryController::class, 'destroyPhoto'])->name('galeri.photo.destroy');

    // Infaq Online Management & Verification
    Route::get('/infaq', [AdminInfaqController::class, 'index'])->name('infaq.index');
    Route::patch('/infaq/{donation}/status', [AdminInfaqController::class, 'updateStatus'])->name('infaq.status');
    Route::get('/infaq/pengaturan', [AdminInfaqController::class, 'settings'])->name('infaq.settings');
    Route::put('/infaq/pengaturan', [AdminInfaqController::class, 'updateSettings'])->name('infaq.settings.update');

    // Aspiration Management
    Route::get('/aspirasi', [AdminAspirationController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/{aspirasi}', [AdminAspirationController::class, 'show'])->name('aspirasi.show');
    Route::patch('/aspirasi/{aspirasi}/status', [AdminAspirationController::class, 'updateStatus'])->name('aspirasi.status');
    Route::delete('/aspirasi/{aspirasi}', [AdminAspirationController::class, 'destroy'])->name('aspirasi.destroy');

    // Settings
    Route::get('/pengaturan', [AdminSettingController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [AdminSettingController::class, 'update'])->name('pengaturan.update');
});
