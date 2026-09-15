<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', ['page' => 'home']);
    }

    public function profil()
    {
        return view('dashboard', ['page' => 'profil']);
    }

    public function informasi()
    {
        return view('dashboard', ['page' => 'penelitian']);
    }

    public function penelitian()
    {
        return view('dashboard', ['page' => 'penelitian']);
    }

    public function publikasi()
    {
        return view('dashboard', ['page' => 'publikasi']);
    }

    public function tahun2024()
    {
        return view('dashboard', ['page' => 'tahun2024']);
    }

    public function tahun2025()
    {
        return view('dashboard', ['page' => 'publikasi']);
    }

    public function tahun2026()
    {
        return view('dashboard', ['page' => 'publikasi']);
    }
}
