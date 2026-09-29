<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\NewsAdminApiController;
use App\Http\Controllers\Api\NewsApiController;
use Illuminate\Support\Facades\Route;

/* =========================================================
   JSON API untuk front end Next.js / React
   ========================================================= */

// --- Baca (publik) ---
Route::get('/beranda', [NewsApiController::class, 'home'])->name('api.beranda');
Route::get('/berita', [NewsApiController::class, 'index'])->name('api.berita.index');
Route::get('/laporan-tahunan', [NewsApiController::class, 'laporanTahunan'])->name('api.laporan-tahunan');

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
