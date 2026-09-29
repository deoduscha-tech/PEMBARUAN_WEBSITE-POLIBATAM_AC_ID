@php
    /* =========================================================
       Page data

       The controller supplies $featured, $latestPosts, $popularPosts,
       $trendingPosts, $homePosts and $missedCards from the flat-file news
       store. The fallbacks below keep the view renderable on its own.
    ========================================================= */
    $page = $page ?? 'home';

    $featured = $featured ?? collect();
    $latestPosts = $latestPosts ?? collect();
    $popularPosts = $popularPosts ?? collect();
    $trendingPosts = $trendingPosts ?? collect();
    $homePosts = $homePosts ?? collect();
    $missedCards = $missedCards ?? collect();

    // Featured slider falls back to the newest posts when none is flagged.
    $featuredSlides = $featured->isNotEmpty()
        ? $featured->take(3)
        : $homePosts->take(3);

    // The running headline strip mirrors the newest posts (slug + title).
    $tickerItems = $homePosts->take(5);

    $yearMenu = [
        ['label' => 'TAHUN 2026', 'href' => '/tahun-2026', 'key' => 'tahun2026'],
        ['label' => 'TAHUN 2025', 'href' => '/tahun-2025', 'key' => 'tahun2025'],
        ['label' => 'TAHUN 2024', 'href' => '/tahun-2024', 'key' => 'tahun2024'],
        ['label' => 'TAHUN SEBELUMNYA', 'href' => '/publikasi', 'key' => 'publikasi'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat P2M Polibatam</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/images/cropped-Logo-Polibatam-3-32x32.png">
    <link rel="apple-touch-icon" href="/images/cropped-Logo-Polibatam-3-32x32.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.site-header', ['page' => $page])

    @if ($page === 'home')
        {{-- =====================================================
             Latest post ticker
        ===================================================== --}}
        <section class="border-y border-[#0f213d]/10 bg-[#f7f9fc]">
            <div class="page-inner">
                <div class="flex min-h-[52px] w-full items-stretch overflow-hidden">
                    <div class="bn-title relative z-10 shrink-0">
                        <span class="inline-flex items-center gap-2.5 text-base font-extrabold text-white">
                            <span class="ticker-icon" aria-hidden="true">
                                <svg class="size-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2 4.5 13.5H11l-1 8.5 9-12h-6.5z"/></svg>
                            </span>
                            Latest Post
                        </span>
                    </div>
                    {{-- The marquee must be clipped by its own track, otherwise the
                         scrolling text runs over the "Latest Post" label. --}}
                    <div class="relative min-w-0 flex-1 overflow-hidden">
                        <div class="ticker-track" aria-label="Postingan terbaru">
                            @foreach ([0, 1] as $copy)
                                <div class="flex h-full shrink-0 items-center" @if ($copy === 1) aria-hidden="true" @endif>
                                    @foreach ($tickerItems as $item)
                                        <a class="ticker-item" href="{{ route('berita.detail', $item['slug']) }}" @if ($copy === 1) tabindex="-1" @endif>
                                            <span class="inline-block size-[9px] shrink-0 rounded-full bg-blue shadow-[0_0_0_3px_rgba(28,115,217,0.16)]"></span>
                                            {{ $item['title'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- =====================================================
             Featured slider + sidebar tabs
        ===================================================== --}}
        <section class="bg-[#eceef2]">
            <div class="wide-inner grid gap-[18px] py-[18px] lg:grid-cols-[minmax(0,2.1fr)_minmax(300px,0.92fr)] lg:items-stretch">

                {{-- Featured carousel --}}
                <div data-slider class="relative min-h-[480px] overflow-hidden border-navy-dark/10 bg-[#eef2f7] shadow-card">
                    @foreach ($featuredSlides as $index => $slide)
                        <article data-slide class="feature-slide {{ $index === 0 ? 'active' : '' }}">
                            <div class="feature-image" style="background-image: url('{{ $slide['image'] }}');">
                                <button type="button" data-slide-prev
                                        class="feature-nav prev" aria-label="Slide sebelumnya">&#8249;</button>
                                <button type="button" data-slide-next
                                        class="feature-nav next" aria-label="Slide berikutnya">&#8250;</button>
                                <div class="feature-content">
                                    <span class="feature-category">{{ $slide['category'] }}</span>
                                    <h4 class="feature-title">{{ $slide['title'] }}</h4>
                                    <div class="feature-meta">
                                        <span>{{ strtoupper(\Illuminate\Support\Carbon::parse($slide['date'])->format('F d, Y')) }}</span>
                                        <span class="dot" aria-hidden="true"></span>
                                        <span>{{ $slide['author'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Sidebar: latest / popular / trending --}}
                <div class="flex flex-col border-line bg-white shadow-card">
                    <ul class="grid grid-cols-3 border-b border-line">
                        @foreach ([
                            ['key' => 'latest', 'label' => 'Latest', 'icon' => '<circle cx="12" cy="12" r="8"></circle><path d="M12 7v5l3 2"></path>'],
                            ['key' => 'popular', 'label' => 'Popular', 'icon' => '<circle cx="12" cy="8" r="3.2"></circle><path d="M5 18c1.6-2.6 4-3.9 7-3.9s5.4 1.3 7 3.9"></path>'],
                            ['key' => 'trending', 'label' => 'Trending', 'icon' => '<path d="M4 16l7-7 4 4 7-7"></path><path d="M18 6h2v2"></path>'],
                        ] as $index => $tab)
                            <li>
                                <a href="#" data-tab="{{ $tab['key'] }}" class="tab {{ $index === 0 ? 'active' : '' }}">
                                    <span class="tab-icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24">{!! $tab['icon'] !!}</svg>
                                    </span>
                                    <span>{{ $tab['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="flex flex-1 flex-col p-3">
                        @foreach (['latest' => $latestPosts, 'popular' => $popularPosts, 'trending' => $trendingPosts] as $key => $posts)
                            <div data-panel="{{ $key }}" class="flex flex-1 flex-col gap-3" @if ($key !== 'latest') hidden @endif>
                                @foreach ($posts as $post)
                                    <a href="{{ route('berita.detail', $post['slug']) }}" class="small-post grid border">
                                        <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="h-[60px] w-full border-line object-cover" loading="lazy">
                                        <div class="min-w-0">
                                            <span class="category-chip">INFORMASI</span>
                                            <p class="title">{{ $post['title'] }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- =====================================================
             Post list
        ===================================================== --}}
        <div class="wide-inner py-[18px]">
            @foreach ($homePosts as $post)
                <article class="article-post mb-[18px] flex gap-[18px] border">
                    <div class="flex w-[300px] shrink-0 flex-col">
                        <a href="{{ route('berita.detail', $post['slug']) }}" class="block min-h-[200px] flex-1 border bg-cover bg-center"
                           style="background-image: url('{{ $post['image'] }}');" aria-label="{{ $post['title'] }}"></a>
                    </div>
                    <div class="flex min-w-0 flex-1 flex-col justify-center">
                        <span class="category-chip w-fit">{{ strtoupper($post['category']) }}</span>
                        <h4 class="entry-title"><a href="{{ route('berita.detail', $post['slug']) }}">{{ $post['title'] }}</a></h4>
                        <div class="flex flex-wrap items-center gap-2.5 text-[0.78rem] font-bold text-[#6b7787]">
                            <span>{{ \Illuminate\Support\Carbon::parse($post['date'])->format('F d, Y') }}</span>
                            <span aria-hidden="true">&middot;</span>
                            <span>{{ $post['author'] }}</span>
                        </div>
                        <p class="mt-2 text-[0.95rem] leading-relaxed text-muted">{{ $post['excerpt'] }}</p>
                        <a href="{{ route('berita.detail', $post['slug']) }}"
                           class="mt-3 inline-flex w-fit items-center gap-1.5 text-[0.8rem] font-bold text-blue hover:underline">
                            Baca Selengkapnya
                            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach

            <nav class="flex items-center justify-center gap-1.5 py-2" aria-label="Navigasi halaman">
                <span class="page-numbers current" aria-current="page">1</span>
                <a class="page-numbers border" href="#">2</a>
                <span class="px-2 text-muted">&hellip;</span>
                <a class="page-numbers border" href="#">27</a>
                <a class="page-numbers border" href="#" aria-label="Halaman berikutnya">&#8250;</a>
            </nav>
        </div>

        {{-- =====================================================
             You missed
        ===================================================== --}}
        <section class="border-t border-line bg-[#f3f5f7] py-[18px]">
            <div class="wide-inner">
                <div class="mb-[18px] flex items-end border-b-2 border-line">
                    <span class="section-label">You missed</span>
                </div>
                <div class="grid gap-[18px] sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ($missedCards as $card)
                        <article class="flex min-h-[210px] items-end bg-cover bg-center" style="background-image: url('{{ $card['image'] }}');">
                            <a href="{{ route('berita.detail', $card['slug']) }}" class="card-overlay-sm block" aria-label="{{ $card['title'] }}">
                                <span class="category-chip">{{ strtoupper($card['category']) }}</span>
                                <h4 class="mt-1.5 mb-2 line-clamp-3 text-[0.92rem] leading-snug font-bold text-white">{{ $card['title'] }}</h4>
                                <div class="text-[0.72rem] text-white/90">{{ \Illuminate\Support\Carbon::parse($card['date'])->format('F d, Y') }}</div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

    @elseif ($page === 'profil')
        <div class="bg-[#efefef] pb-6">
            <h1 class="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">PROFIL</h1>
            <div class="wide-inner mb-4 min-h-[180px] border-line bg-[#f3f3f3] p-4 rich-copy">
                <p>Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam merupakan unit yang mengelola, memfasilitasi, serta mengembangkan kegiatan penelitian dan pengabdian kepada masyarakat di lingkungan Polibatam.</p>
                <p>Unit ini mendorong terciptanya riset yang berkualitas, publikasi ilmiah yang bereputasi, serta hilirisasi hasil penelitian yang berdampak bagi industri dan masyarakat.</p>
            </div>
            <div class="wide-inner pb-4 text-[1.12rem] font-bold">Jumlah Pengunjung: 17,874</div>
            <div class="wide-inner pb-6">
                <div class="mb-[18px] flex items-end border-b-2 border-line"><span class="section-label">You missed</span></div>
                <div class="grid gap-[18px] sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ($missedCards as $card)
                        <article class="flex min-h-[210px] items-end bg-cover bg-center" style="background-image: url('{{ $card['image'] }}');">
                            <a href="{{ route('berita.detail', $card['slug']) }}" class="card-overlay-sm block" aria-label="{{ $card['title'] }}">
                                <span class="category-chip">{{ strtoupper($card['category']) }}</span>
                                <h4 class="mt-1.5 mb-2 line-clamp-3 text-[0.92rem] leading-snug font-bold text-white">{{ $card['title'] }}</h4>
                                <div class="text-[0.72rem] text-white/90">{{ \Illuminate\Support\Carbon::parse($card['date'])->format('F d, Y') }}</div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    @elseif (in_array($page, ['informasi', 'penelitian'], true))
        <div class="bg-[#efefef] pb-6">
            <h1 class="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">INFORMASI</h1>
            <div class="wide-inner mb-4 border-line bg-[#f3f3f3]">
                @foreach ($homePosts->take(3) as $post)
                    <div class="story-row">
                        <a href="{{ route('berita.detail', $post['slug']) }}" class="story-thumb !border-line bg-cover bg-center"
                           style="background-image: url('{{ $post['image'] }}');" aria-label="{{ $post['title'] }}"></a>
                        <div class="story-copy">
                            <span class="category-chip">{{ strtoupper($post['category']) }}</span>
                            <h3 class="mt-2.5"><a href="{{ route('berita.detail', $post['slug']) }}">{{ $post['title'] }}</a></h3>
                            <p class="mb-3 text-[1.05rem] leading-relaxed text-muted">{{ $post['excerpt'] }}</p>
                            <a class="read-more" href="{{ route('berita.detail', $post['slug']) }}">Baca Selengkapnya</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="wide-inner pb-6 text-[1.12rem] font-bold">Jumlah Pengunjung: 6,589</div>
        </div>
    @elseif ($page === 'hki')
        <div class="bg-[#efefef] pb-6">
            <h1 class="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">HKI</h1>
            <div class="wide-inner mb-4 border-line bg-[#f3f3f3]">
                <div class="story-row">
                    <div class="story-thumb"><span class="text-[clamp(1.8rem,3vw,3rem)] font-black text-navy-dark">HKI</span></div>
                    <div class="story-copy rich-copy">
                        <h3>Hak Kekayaan Intelektual</h3>
                        <p>Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam aktif mendorong pengembangan inovasi, karya ilmiah, dan produk teknologi yang memiliki nilai komersial serta manfaat bagi masyarakat.</p>
                        <p>Berbagai karya inovatif dari dosen dan mahasiswa didaftarkan sebagai HKI untuk melindungi, meningkatkan nilai ekonomi, serta memperkuat ekosistem riset dan inovasi perguruan tinggi.</p>
                        <a class="read-more" href="https://p2m.polibatam.ac.id/?page_id=4735" target="_blank" rel="noopener noreferrer">Lihat Detail HKI</a>
                    </div>
                </div>
                <div class="story-row">
                    <div class="story-thumb"><span class="text-[clamp(1.2rem,2vw,2.2rem)] font-black text-navy-dark uppercase">Intellectual<br>Property</span></div>
                    <div class="story-copy rich-copy">
                        <h3>Prioritas Pengembangan HKI</h3>
                        <p>Beberapa fokus utama pengembangan HKI meliputi teknologi tepat guna, perangkat lunak, desain produk, inovasi pendidikan, serta solusi berbasis kebutuhan industri dan masyarakat.</p>
                        <ul>
                            <li>Perlindungan inovasi produk dan teknologi</li>
                            <li>Pengembangan karya riset yang aplikatif</li>
                            <li>Dukungan komersialisasi hasil penelitian</li>
                            <li>Kolaborasi dengan industri dan mitra strategis</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="wide-inner pb-6 text-[1.12rem] font-bold">Jumlah Pengunjung: 4,342</div>
        </div>
    @elseif ($page === 'statistik')
        <div class="bg-[#efefef] pb-6">
            <h1 class="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">STATISTIK</h1>
            <div class="wide-inner mb-4 border-line bg-[#f3f3f3]">
                <div class="story-row">
                    <div class="story-thumb"><span class="text-[clamp(1.8rem,3vw,3rem)] font-black text-navy-dark">P2M</span></div>
                    <div class="story-copy rich-copy">
                        <h3>Statistik Pusat Penelitian dan Pengabdian Masyarakat</h3>
                        <p>Pusat P2M Polibatam terus memperkuat aktivitas riset, publikasi, dan pengabdian dengan fokus pada inovasi, kolaborasi, serta dampak nyata bagi masyarakat dan industri.</p>
                        <ul>
                            <li>Riset dan inovasi terarah sesuai kebutuhan industri</li>
                            <li>Kolaborasi lintas disiplin dan mitra strategis</li>
                            <li>Publikasi ilmiah dan penguatan karya akademik</li>
                            <li>Pengabdian masyarakat berbasis solusi teknologi</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="wide-inner pb-6 text-[1.12rem] font-bold">Jumlah Pengunjung: 12,480</div>
        </div>
    @elseif ($page === 'berdampak')
        <div class="bg-[#efefef] pb-6">
            <h1 class="wide-inner py-6 text-[clamp(2rem,3.5vw,3.5rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">Polibatam University Berdampak</h1>
            <div class="wide-inner mb-4 border-line bg-[#f3f3f3]">
                <div class="story-row">
                    <div class="story-thumb"><span class="text-[clamp(1.2rem,2vw,2.2rem)] font-black text-navy-dark uppercase">Impact</span></div>
                    <div class="story-copy rich-copy">
                        <h3>Membangun dampak nyata untuk masyarakat dan industri</h3>
                        <p>Polibatam University Berdampak merupakan komitmen untuk membawa kontribusi nyata melalui riset, inovasi, pengabdian, dan penerapan teknologi yang berdampak pada kualitas hidup, daya saing industri, serta kesejahteraan masyarakat.</p>
                        <p>Melalui pendekatan kolaboratif, Polibatam mendorong terciptanya solusi yang bermanfaat secara luas, terukur, dan berkelanjutan.</p>
                        <a class="read-more" href="#">Pelajari lebih lanjut</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Publikasi / tahun 2024-2026 --}}
        @php
            $currentYear = [
                'tahun2026' => 'TAHUN 2026',
                'tahun2025' => 'TAHUN 2025',
                'tahun2024' => 'TAHUN 2024',
                'publikasi' => 'TAHUN 2026',
            ][$page] ?? 'TAHUN 2026';
        @endphp
        <div class="bg-[#efefef] pb-6">
            <h1 class="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">{{ $currentYear }}</h1>
            <div class="wide-inner mb-4 grid border-line bg-[#f3f3f3] md:grid-cols-[260px_minmax(0,1fr)]">
                <nav class="flex flex-col bg-[#1d2432] py-1">
                    @foreach ($yearMenu as $year)
                        <a class="year-item {{ $year['key'] === $page || ($page === 'publikasi' && $year['key'] === 'tahun2026') ? 'active' : '' }}"
                           href="{{ $year['href'] }}">{{ $year['label'] }}</a>
                    @endforeach
                </nav>
                <div class="min-h-[380px] bg-[#efefef] p-6 rich-copy">
                    <h3 class="mb-[18px] text-center text-[clamp(1.8rem,2.5vw,2.4rem)] font-black text-[#0b1d35]">LUARAN PUBLIKASI</h3>
                    <p>Daftar luaran publikasi penelitian dan pengabdian kepada masyarakat Pusat P2M Politeknik Negeri Batam. Silakan pilih tahun pada menu di samping untuk melihat data publikasi terkait.</p>
                    <p><a href="#">Lihat daftar publikasi lengkap &rarr;</a></p>
                </div>
            </div>
            <div class="wide-inner pb-4 text-[1.12rem] font-bold">Jumlah Pengunjung: 269</div>
            <div class="wide-inner pb-6">
                <div class="mb-[18px] flex items-end border-b-2 border-line"><span class="section-label">You missed</span></div>
                <div class="grid gap-[18px] sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ($missedCards as $card)
                        <article class="flex min-h-[210px] items-end bg-cover bg-center" style="background-image: url('{{ $card['image'] }}');">
                            <a href="{{ route('berita.detail', $card['slug']) }}" class="card-overlay-sm block" aria-label="{{ $card['title'] }}">
                                <span class="category-chip">{{ strtoupper($card['category']) }}</span>
                                <h4 class="mt-1.5 mb-2 line-clamp-3 text-[0.92rem] leading-snug font-bold text-white">{{ $card['title'] }}</h4>
                                <div class="text-[0.72rem] text-white/90">{{ \Illuminate\Support\Carbon::parse($card['date'])->format('F d, Y') }}</div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- =====================================================
         Footer
    ===================================================== --}}
    <footer class="relative overflow-hidden bg-gradient-to-b from-[#0a132a] to-[#080f22] text-white">
        <div class="wide-inner relative pt-10 pb-[18px]">
            <h2 class="mb-[34px] text-[clamp(2.4rem,3.1vw,3.5rem)] leading-[1.1] font-extrabold tracking-[-0.06em] text-white/95">Pusat P2M Polibatam</h2>
            <div class="border-t border-white/15 pt-[18px] text-center text-[0.82rem] leading-normal text-white/75">
                Proudly powered by WordPress | Theme: Newsup by Themeansar.
            </div>
            <a href="#" data-back-to-top class="absolute right-8 bottom-3.5 grid size-[42px] place-items-center rounded-md bg-gradient-to-b from-[#1b6ee8] to-[#0d4ca8] text-2xl font-bold text-white shadow-[0_8px_18px_rgba(29,108,220,0.45)]" aria-label="Kembali ke atas">&uarr;</a>
        </div>
    </footer>
</body>
</html>
