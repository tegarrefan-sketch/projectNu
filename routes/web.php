<?php

use App\Http\Controllers\Admin\AspirationController as AdminAspirationController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BanomController as AdminBanomController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\KtaController as AdminKtaController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\OrganizationStructureController as AdminStructureController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\AspirationController;
use App\Http\Controllers\BanomController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
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

Route::get('/banom', [BanomController::class, 'index'])->name('banom.index');
Route::get('/banom/{slug}', [BanomController::class, 'show'])->name('banom.show');

Route::get('/struktur', [StructureController::class, 'index'])->name('structure.index');

Route::get('/berita', [PostController::class, 'index'])->name('post.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('post.show');

Route::get('/agenda', [EventController::class, 'index'])->name('event.index');
Route::get('/agenda/{slug}', [EventController::class, 'show'])->name('event.show');

Route::get('/aspirasi', [AspirationController::class, 'create'])->name('aspirasi.create');
Route::post('/aspirasi', [AspirationController::class, 'store'])->name('aspirasi.store');
Route::get('/aspirasi/lacak', [AspirationController::class, 'track'])->name('aspirasi.track');

// KTA Public Verification & Scanner
Route::get('/kta/verifikasi', [KtaVerificationController::class, 'index'])->name('kta.verify.search');
Route::get('/kta/verify/{nomor_kta}', [KtaVerificationController::class, 'verify'])->name('kta.verify');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
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

    // BANOM CRUD
    Route::resource('banom', AdminBanomController::class);

    // Organization Structure CRUD
    Route::resource('struktur', AdminStructureController::class);

    // Members / Kader CRUD
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

    // Event / Agenda CRUD
    Route::resource('agenda', AdminEventController::class);

    // Aspiration Management
    Route::get('/aspirasi', [AdminAspirationController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/{aspirasi}', [AdminAspirationController::class, 'show'])->name('aspirasi.show');
    Route::patch('/aspirasi/{aspirasi}/status', [AdminAspirationController::class, 'updateStatus'])->name('aspirasi.status');
    Route::delete('/aspirasi/{aspirasi}', [AdminAspirationController::class, 'destroy'])->name('aspirasi.destroy');

    // Settings
    Route::get('/pengaturan', [AdminSettingController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [AdminSettingController::class, 'update'])->name('pengaturan.update');
});
