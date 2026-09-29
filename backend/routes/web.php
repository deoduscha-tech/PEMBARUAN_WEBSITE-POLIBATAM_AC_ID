<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

/* =========================================================
   Public site
   ========================================================= */
Route::get('/', [PublicPageController::class, 'index'])->name('home');
Route::get('/dashboard', [PublicPageController::class, 'index'])->name('dashboard');

// News article detail — must come before nothing else claims /berita.
Route::get('/berita/{slug}', [PublicPageController::class, 'show'])->name('berita.detail');

Route::get('/profil', [PublicPageController::class, 'profil'])->name('profil');
Route::get('/informasi', [PublicPageController::class, 'informasi'])->name('informasi');
Route::get('/penelitian', [PublicPageController::class, 'penelitian'])->name('penelitian');
Route::get('/publikasi', [PublicPageController::class, 'publikasi'])->name('publikasi');
Route::get('/hki', [PublicPageController::class, 'hki'])->name('hki');
Route::get('/statistik', [PublicPageController::class, 'statistik'])->name('statistik');
Route::get('/berdampak', [PublicPageController::class, 'berdampak'])->name('berdampak');
Route::get('/tahun-2024', [PublicPageController::class, 'tahun2024'])->name('tahun2024');
Route::get('/tahun-2025', [PublicPageController::class, 'tahun2025'])->name('tahun2025');
Route::get('/tahun-2026', [PublicPageController::class, 'tahun2026'])->name('tahun2026');
Route::get('/laporan-tahunan', [PublicPageController::class, 'laporanTahunan'])->name('laporan.tahunan');

/* =========================================================
   Admin workspace
   ========================================================= */
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest-only: login form + submit.
    Route::middleware('admin.guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    });

    // Requires an authenticated admin session.
    Route::middleware('admin.auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [NewsController::class, 'dashboard'])->name('dashboard');
        Route::get('berita', [NewsController::class, 'index'])->name('berita.index');
        Route::get('berita/tambah', [NewsController::class, 'create'])->name('berita.create');
        Route::post('berita', [NewsController::class, 'store'])->name('berita.store');
        Route::get('berita/{id}/edit', [NewsController::class, 'edit'])->name('berita.edit');
        Route::put('berita/{id}', [NewsController::class, 'update'])->name('berita.update');
        Route::delete('berita/{id}', [NewsController::class, 'destroy'])->name('berita.destroy');
    });
});
