<?php

use App\Http\Controllers\PublicPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPageController::class, 'index'])->name('home');
Route::get('/dashboard', [PublicPageController::class, 'index'])->name('dashboard');
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
