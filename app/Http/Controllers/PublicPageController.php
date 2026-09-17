<?php

namespace App\Http\Controllers;

class PublicPageController extends Controller
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
        return view('dashboard', ['page' => 'informasi']);
    }

    public function penelitian()
    {
        return view('dashboard', ['page' => 'penelitian']);
    }

    public function publikasi()
    {
        return view('dashboard', ['page' => 'publikasi']);
    }

    public function hki()
    {
        return view('dashboard', ['page' => 'hki']);
    }

    public function statistik()
    {
        return view('dashboard', ['page' => 'statistik']);
    }

    public function berdampak()
    {
        return view('dashboard', ['page' => 'berdampak']);
    }

    public function tahun2024()
    {
        return view('dashboard', ['page' => 'tahun2024']);
    }

    public function tahun2025()
    {
        return view('dashboard', ['page' => 'tahun2025']);
    }

    public function tahun2026()
    {
        return view('dashboard', ['page' => 'tahun2026']);
    }
}
