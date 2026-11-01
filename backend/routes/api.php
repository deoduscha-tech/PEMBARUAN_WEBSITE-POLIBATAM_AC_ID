<?php

use App\Http\Controllers\Api\AdminContentApiController;
use App\Http\Controllers\Api\AdminWorkspaceApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\HalamanApiController;
use App\Http\Controllers\Api\HkiApiController;
use App\Http\Controllers\Api\KontakApiController;
use App\Http\Controllers\Api\NewsAdminApiController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\PublikasiApiController;
use App\Http\Controllers\Api\StatistikApiController;
use App\Http\Controllers\Api\TupoksiApiController;
use Illuminate\Support\Facades\Route;

/* =========================================================
   JSON API untuk front end Next.js / React
   ========================================================= */

// --- Hal-hal statis (profil, visi misi, statistik, panduan) ---
Route::get('/beranda', [NewsApiController::class, 'home'])->name('api.beranda');
Route::get('/berita', [NewsApiController::class, 'index'])->name('api.berita.index');
Route::get('/laporan-tahunan', [NewsApiController::class, 'laporanTahunan'])->name('api.laporan-tahunan');
Route::get('/statistik', [StatistikApiController::class, 'index'])->name('api.statistik');

// --- Halaman profil & unit ---
Route::get('/halaman', [HalamanApiController::class, 'index'])->name('api.halaman.index');
Route::get('/halaman/{slug}', [HalamanApiController::class, 'show'])->name('api.halaman.show');

// --- Publikasi ---
Route::get('/publikasi', [PublikasiApiController::class, 'index'])->name('api.publikasi.index');
Route::get('/publikasi/{tahun}', [PublikasiApiController::class, 'show'])->name('api.publikasi.show');

// --- HKI ---
Route::get('/hki', [HkiApiController::class, 'index'])->name('api.hki.index');
Route::get('/hki/{tahun}', [HkiApiController::class, 'show'])->name('api.hki.show');

// --- Kontak ---
Route::get('/kontak', [KontakApiController::class, 'index'])->name('api.kontak');

// --- Tupoksi ---
Route::get('/tupoksi', [TupoksiApiController::class, 'index'])->name('api.tupoksi');

// --- Autentikasi admin ---
Route::post('/auth/login', [AuthApiController::class, 'login'])->name('api.auth.login');
Route::get('/auth/me', [AuthApiController::class, 'me'])->name('api.auth.me');
Route::delete('/auth/login', [AuthApiController::class, 'logout'])->name('api.auth.logout');

// --- Dashboard admin (butuh token login) ---
Route::get('/admin/berita', [AdminWorkspaceApiController::class, 'berita'])->name('api.admin.berita');
Route::get('/admin/ringkasan', [AdminWorkspaceApiController::class, 'ringkasan'])->name('api.admin.ringkasan');
Route::get('/admin/pengaturan', [AdminWorkspaceApiController::class, 'pengaturan'])->name('api.admin.pengaturan');
Route::put('/admin/pengaturan', [AdminWorkspaceApiController::class, 'simpanPengaturan'])->name('api.admin.pengaturan.simpan');

// --- Kelola HKI, Publikasi, Profil ---
Route::get('/admin/hki', [AdminContentApiController::class, 'hkiIndex'])->name('api.admin.hki.index');
Route::get('/admin/hki/{year}', [AdminContentApiController::class, 'hkiShow'])->name('api.admin.hki.show');
Route::post('/admin/hki/{year}', [AdminContentApiController::class, 'hkiSave'])->name('api.admin.hki.save');
Route::delete('/admin/hki/{year}', [AdminContentApiController::class, 'hkiDestroy'])->name('api.admin.hki.destroy');

Route::get('/admin/publikasi', [AdminContentApiController::class, 'publikasiIndex'])->name('api.admin.publikasi.index');
Route::get('/admin/publikasi/{year}', [AdminContentApiController::class, 'publikasiShow'])->name('api.admin.publikasi.show');
Route::post('/admin/publikasi/{year}', [AdminContentApiController::class, 'publikasiSave'])->name('api.admin.publikasi.save');

Route::get('/admin/profil', [AdminContentApiController::class, 'profilIndex'])->name('api.admin.profil.index');
Route::get('/admin/profil/{slug}', [AdminContentApiController::class, 'profilShow'])->name('api.admin.profil.show');
Route::post('/admin/profil/{slug}', [AdminContentApiController::class, 'profilSave'])->name('api.admin.profil.save');

// --- Tulis (butuh token login) ---
Route::post('/berita', [NewsAdminApiController::class, 'store'])->name('api.berita.store');
Route::put('/berita/{id}', [NewsAdminApiController::class, 'update'])->name('api.berita.update');
Route::delete('/berita/{id}', [NewsAdminApiController::class, 'destroy'])->name('api.berita.destroy');

// Detail berita diletakkan paling bawah supaya tidak menangkap /berita/... yang lain.
Route::get('/berita/{slug}', [NewsApiController::class, 'show'])->name('api.berita.show');
