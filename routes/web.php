<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');
Route::get('/informasi', [DashboardController::class, 'informasi'])->name('informasi');
Route::get('/penelitian', [DashboardController::class, 'penelitian'])->name('penelitian');
Route::get('/publikasi', [DashboardController::class, 'publikasi'])->name('publikasi');
Route::get('/tahun-2024', [DashboardController::class, 'tahun2024'])->name('tahun2024');
Route::get('/tahun-2025', [DashboardController::class, 'tahun2025'])->name('tahun2025');
Route::get('/tahun-2026', [DashboardController::class, 'tahun2026'])->name('tahun2026');
