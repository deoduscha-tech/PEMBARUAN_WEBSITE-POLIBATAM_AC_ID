<?php
    /* =========================================================
       Navigation and header data
    ========================================================= */
    $navItems = [
        ['label' => 'PROFIL', 'href' => '/profil', 'active' => ($page ?? 'home') === 'profil'],
        ['label' => 'INFORMASI', 'href' => '/informasi', 'active' => ($page ?? 'home') === 'informasi' || ($page ?? 'home') === 'penelitian'],
        ['label' => 'PUBLIKASI', 'href' => '/publikasi', 'active' => ($page ?? 'home') === 'publikasi' || ($page ?? 'home') === 'tahun2024' || ($page ?? 'home') === 'tahun2025' || ($page ?? 'home') === 'tahun2026'],
        ['label' => 'HKI', 'href' => '/hki', 'active' => ($page ?? 'home') === 'hki', 'hasDropdown' => false],
        ['label' => 'SINTA', 'href' => 'https://sinta.kemdiktisaintek.go.id/affiliations/profile/564', 'active' => false, 'external' => true],
        ['label' => 'JURNAL', 'href' => 'https://jurnal.polibatam.ac.id/', 'active' => false, 'external' => true],
        ['label' => 'STATISTIK', 'href' => '/statistik', 'active' => ($page ?? 'home') === 'statistik'],
        ['label' => 'POLIBATAM UNIVERSITY BERDAMPAK', 'href' => '/berdampak', 'active' => ($page ?? 'home') === 'berdampak'],
    ];

    $tickerItems = [
        'Pengumuman Hasil Seleksi Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam TA 2026',
        'Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026',
        'P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)',
        'Pengumuman Penerima Pendanaan Program Penelitian dan Pengabdian kepada Masyarakat (BIMA), Program Inovasi Seni Nusantara (BIMA), Program Hilirisasi Riset Prioritas (HILIRISET), dan Program SEMESTA Tahun Anggaran 2026',
        'Pembentukan dan Pengangkatan Ketua Pusat Kajian (PK) dan Center Of Excellence (CoE) Politeknik Negeri Batam Tahun 2026',
    ];

    $sidebarPosts = [
        ['title' => 'Pengumuman Hasil Seleksi Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam TA 2026', 'img' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2023/06/Pengumuman-Penerima-Bantuan-Dana-Penelitian-dan-Pengabdian-Masyarakat-Usulan-Baru-bagi-Perguruan-Tinggi-Pengelola-Program-Studi-Pendidikan-Tinggi-Vokasi-Tahun-Anggaran-2023-2-300x169.png'],
        ['title' => 'Panduan Penelitian dan Pengabdian kepada Masyarakat Tahun 2026', 'img' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/BUKU-PANDUAN-300x212.jpg'],
        ['title' => 'P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi Artikel pada Jurnal Q1 (PASTI Q1)', 'img' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/111-1-300x200.png'],
        ['title' => 'Pengumuman Penerima Pendanaan Program Penelitian dan Pengabdian kepada Masyarakat (BIMA), Program Inovasi Seni Nusantara (BIMA), Program Hilirisasi Riset Prioritas (HILIRISET), dan Program SEMESTA Tahun Anggaran 2026', 'img' => 'https://p2m.polibatam.ac.id/wp-content/uploads/2026/04/1-300x212.jpg'],
    ];

    $missedCards = [
        ['tag' => 'Informasi', 'title' => 'Pengumuman Hasil Seleksi Penelitian dan Pengabdian...', 'date' => 'June 15, 2026'],
        ['tag' => 'Informasi', 'title' => 'Buku Panduan Penelitian dan Pengabdian kepada Masyarakat...', 'date' => 'April 29, 2026'],
        ['tag' => 'Informasi', 'title' => 'P3M Polibatam Gelar Expert Talk Series #1: Strategi Publikasi...', 'date' => 'April 20, 2026'],
    ];
?>

<div class="page top-date">
    <div class="page-inner top-date-row">
        <span id="top-date-text" class="top-date-text">September 17, 2026</span>
        <span id="top-date-time" class="top-date-time">4:20 AM</span>
    </div>
</div>

<div class="page hero-wrap">
    <div class="page-inner branding-inner">
        <div class="site-logo" aria-label="Logo Pusat P2M Polibatam"></div>
        <div class="site-branding-text">
            <h1 class="hero-title">Pusat P2M Polibatam</h1>
        </div>
    </div>
</div>

<div class="page nav-bar">
    <div class="nav-main">
        <a class="nav-home <?php echo (($page ?? 'home') === 'home' ? 'active' : ''); ?>" href="/">⌂</a>
        <?php foreach ($navItems as $item) : ?>
            <a class="nav-item <?php echo !empty($item['hasDropdown']) ? 'has-dropdown' : ''; ?> <?php echo $item['active'] ? 'active' : ''; ?>"
               href="<?php echo $item['href']; ?>"
               <?php echo !empty($item['external']) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                <?php echo $item['label']; ?>
                <?php if (!empty($item['hasDropdown'])) : ?><span class="caret">▾</span><?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="nav-search" role="button" aria-label="Search" aria-expanded="false" tabindex="0">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
            <circle cx="11" cy="11" r="7"></circle>
            <line x1="16.2" y1="16.2" x2="21" y2="21"></line>
        </svg>
    </div>
</div>

<div id="search-panel" class="site-search-panel" hidden>
    <div class="site-search-inner">
        <input id="global-search-input" type="search" placeholder="Cari berita, kegiatan, atau publikasi..." aria-label="Search" />
        <button type="button" class="site-search-close" aria-label="Close search">✕</button>
    </div>
</div>
