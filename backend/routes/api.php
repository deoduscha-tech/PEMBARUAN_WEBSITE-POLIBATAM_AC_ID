<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\KontakApiController;
use App\Http\Controllers\Api\NewsAdminApiController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\PublikasiApiController;
use App\Http\Controllers\Api\TupoksiApiController;
use Illuminate\Support\Facades\Route;

/* =========================================================
   JSON API untuk front end Next.js / React
   ========================================================= */

// --- Baca (publik) ---
Route::get('/beranda', [NewsApiController::class, 'home'])->name('api.beranda');
Route::get('/berita', [NewsApiController::class, 'index'])->name('api.berita.index');
Route::get('/laporan-tahunan', [NewsApiController::class, 'laporanTahunan'])->name('api.laporan-tahunan');

// --- Publikasi ---
Route::get('/publikasi', [PublikasiApiController::class, 'index'])->name('api.publikasi.index');
Route::get('/publikasi/{tahun}', [PublikasiApiController::class, 'show'])->name('api.publikasi.show');

// --- Kontak ---
Route::get('/kontak', [KontakApiController::class, 'index'])->name('api.kontak');

// --- Tupoksi ---
Route::get('/tupoksi', [TupoksiApiController::class, 'index'])->name('api.tupoksi');

// --- Autentikasi admin ---
Route::post('/auth/login', [AuthApiController::class, 'login'])->name('api.auth.login');
Route::get('/auth/me', [AuthApiController::class, 'me'])->name('api.auth.me');
Route::delete('/auth/login', [AuthApiController::class, 'logout'])->name('api.auth.logout');

// --- Tulis (butuh token login) ---
Route::post('/berita', [NewsAdminApiController::class, 'store'])->name('api.berita.store');
Route::put('/berita/{id}', [NewsAdminApiController::class, 'update'])->name('api.berita.update');
Route::delete('/berita/{id}', [NewsAdminApiController::class, 'destroy'])->name('api.berita.destroy');

// Detail berita diletakkan paling bawah supaya tidak menangkap /berita/... yang lain.
Route::get('/berita/{slug}', [NewsApiController::class, 'show'])->name('api.berita.show');
