<?php
/* =========================================================
       Header / navigation data
    ========================================================= */
$page = $page ?? 'home';

$navItems = [
    ['label' => 'INFORMASI', 'href' => '/informasi', 'active' => in_array($page, ['informasi', 'penelitian'], true)],
    ['label' => 'PUBLIKASI', 'href' => '/publikasi', 'active' => in_array($page, ['publikasi', 'tahun2024', 'tahun2025', 'tahun2026'], true)],
    ['label' => 'HKI', 'href' => '/hki', 'active' => $page === 'hki'],
    ['label' => 'SINTA', 'href' => 'https://sinta.kemdiktisaintek.go.id/affiliations/profile/564', 'active' => false, 'external' => true],
    ['label' => 'JURNAL', 'href' => 'https://jurnal.polibatam.ac.id/', 'active' => false, 'external' => true],
    ['label' => 'STATISTIK', 'href' => '/statistik', 'active' => $page === 'statistik'],
    ['label' => 'POLIBATAM UNIVERSITY BERDAMPAK', 'href' => '/berdampak', 'active' => $page === 'berdampak'],
];

// Submenu PROFIL — mirrors the live P2M menu.
$profileDropdownItems = [
    ['label' => 'LAPORAN TAHUNAN P3M TAHUN 2025', 'href' => '/profil#laporan-tahunan'],
    ['label' => 'KONTAK P3M', 'href' => '/profil#kontak'],
    ['label' => 'TUPOKSI', 'href' => '/profil#tupoksi'],
    ['label' => 'RENSTRA PENELITIAN', 'href' => '/profil#renstra'],
    ['label' => 'RIP PENGABDIAN', 'href' => '/profil#rip-pengabdian'],
];
?>
{{-- Top date bar --}}
<div class="w-full border-b border-white/10 bg-[#081d35] py-2">
    <div class="page-inner flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 text-[15px] font-bold tracking-[0.01em] text-[#dfeafc]">
            <span id="top-date-text">September 17, 2026</span>
            <span id="top-date-time" class="top-date-time">4:20 AM</span>
        </div>

        {{-- Workspace access. This is a utility bar, so the admin entry sits here
             as a quiet pill at the far right rather than competing with the
             branding or the public navigation. Mirrors the session state. --}}
        @if (session(config('admin.session_key')))
            <a href="{{ route('admin.dashboard') }}"
               title="Buka dashboard admin"
               class="group inline-flex shrink-0 items-center gap-2 rounded-full border border-[#f0c869]/40 bg-[#f0c869]/10 py-1.5 pr-3.5 pl-2.5 text-[12.5px] font-bold tracking-[0.02em] text-[#f0c869] transition-all duration-200 hover:border-[#f0c869] hover:bg-[#f0c869] hover:text-[#081d35]">
                <svg class="size-[14px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                </svg>
                Dashboard Admin
            </a>
        @else
            <a href="{{ route('admin.login') }}"
               title="Masuk ke workspace admin"
               class="group inline-flex shrink-0 items-center gap-2 rounded-full border border-white/15 bg-white/[0.07] py-1.5 pr-3.5 pl-2.5 text-[12.5px] font-bold tracking-[0.02em] text-[#dfeafc]/85 transition-all duration-200 hover:border-white/30 hover:bg-white/15 hover:text-white">
                <svg class="size-[14px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="4" y="10.5" width="16" height="9.5" rx="2"></rect>
                    <path d="M8 10.5V7a4 4 0 1 1 8 0v3.5"></path>
                </svg>
                Login Admin
            </a>
        @endif
    </div>
</div>

{{-- Hero / branding --}}
<div class="hero-wrap">
    <div class="page-inner relative z-[1] flex min-h-[110px] items-center justify-start gap-4 py-3">
        <div class="site-logo" role="img" aria-label="Logo Pusat P2M Polibatam"></div>
        <h1 class="relative z-[1] m-0 text-[clamp(2rem,2.4vw,2.4rem)] leading-[1.08] font-extrabold tracking-[-0.04em] text-white/95 [text-shadow:0_4px_18px_rgba(0,0,0,0.25)]">
            Pusat P2M Polibatam
        </h1>
    </div>
</div>

{{-- Primary navigation --}}
<div class="nav-bar">
    <div class="flex w-full flex-wrap items-center">
        <a class="nav-home {{ $page === 'home' ? 'active' : '' }}" href="/" aria-label="Beranda">
            <svg class="size-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 10.5 12 3l9 7.5"></path>
                <path d="M5.5 9.5V20h13V9.5"></path>
                <path d="M10 20v-5h4v5"></path>
            </svg>
        </a>

        <div class="nav-dropdown relative {{ $page === 'profil' ? 'open' : '' }}">
            <button type="button" class="nav-item profile-trigger {{ $page === 'profil' ? 'active' : '' }}" aria-expanded="false" aria-controls="profile-submenu">
                PROFIL
                <svg class="caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M6 9l6 6 6-6"></path>
                </svg>
            </button>

            <div id="profile-submenu" class="nav-submenu" hidden>
                @foreach ($profileDropdownItems as $subItem)
                <a href="{{ $subItem['href'] }}" class="nav-submenu-item">{{ $subItem['label'] }}</a>
                @endforeach
            </div>
        </div>

        @foreach ($navItems as $item)
        <a class="nav-item {{ $item['active'] ? 'active' : '' }}"
            href="{{ $item['href'] }}"
            @if (!empty($item['external'])) target="_blank" rel="noopener noreferrer" @endif>
            {{ $item['label'] }}
        </a>
        @endforeach
    </div>

    <div class="flex items-center gap-2">
        <button type="button" id="search-toggle" class="nav-home mr-0 cursor-pointer border-0 bg-transparent" aria-label="Cari" aria-expanded="false" aria-controls="search-panel">
            <svg class="size-[17px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                <circle cx="11" cy="11" r="7"></circle>
                <line x1="16.2" y1="16.2" x2="21" y2="21"></line>
            </svg>
        </button>
    </div>
</div>

{{-- Global search --}}
<div id="search-panel" class="w-full border-b border-navy/10 bg-gradient-to-b from-[#f5f9ff] to-[#edf4ff] py-2.5" hidden>
    <div class="site-search-inner border">
        <input id="global-search-input" type="search" placeholder="Cari berita, kegiatan, atau publikasi..." aria-label="Cari"
            class="min-w-0 flex-1 border-0 bg-transparent py-2.5 text-[0.98rem] text-[#132c54] outline-none placeholder:text-[#71819a]" />
        <button type="button" id="search-close" class="grid size-[34px] cursor-pointer place-items-center rounded-full border-0 bg-[#eaf1ff] text-lg font-bold text-[#133b70]" aria-label="Tutup pencarian">&times;</button>
    </div>
</div>