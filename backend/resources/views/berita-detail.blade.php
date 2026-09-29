@php
$relatedTitles = [
['label' => 'Berita Terkait', 'items' => $related],
];
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post['title'] }} — Pusat P2M Polibatam</title>
    <meta name="description" content="{{ Str::limit(strip_tags($post['excerpt'] ?? $post['body']), 155) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/cropped-Logo-Polibatam-3-32x32.png">
    <link rel="apple-touch-icon" href="/images/cropped-Logo-Polibatam-3-32x32.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#eef1f5]">

    @include('partials.site-header', ['page' => $page])

    {{-- =====================================================
         Breadcrumb
    ===================================================== --}}
    <nav class="border-b border-line bg-white" aria-label="Breadcrumb">
        <div class="wide-inner flex items-center gap-2 overflow-x-auto py-3 text-[0.78rem] whitespace-nowrap">
            <a href="{{ route('home') }}" class="font-semibold text-muted transition-colors hover:text-blue">Beranda</a>
            <span class="text-[#c3cdd9]" aria-hidden="true">/</span>
            <a href="{{ route('informasi') }}" class="font-semibold text-muted transition-colors hover:text-blue">Informasi</a>
            <span class="text-[#c3cdd9]" aria-hidden="true">/</span>
            <span class="text-muted">Detail Berita</span>
        </div>
    </nav>

    <main class="wide-inner grid gap-6 py-7 lg:grid-cols-[minmax(0,1fr)_340px]">

        {{-- =====================================================
             Article
        ===================================================== --}}
        <article class="min-w-0">

            <div class="overflow-hidden rounded-lg border border-line bg-white">

                {{-- Cover --}}
                @if (!empty($post['image']))
                <div class="relative flex min-h-[300px] items-end bg-cover bg-center sm:min-h-[420px]"
                    style="background-image: url('{{ $post['image'] }}');">
                    <div class="card-overlay-lg w-full">
                        <span class="category-chip">{{ strtoupper($post['category']) }}</span>
                        <h1 class="mt-3 mb-3 text-[clamp(1.5rem,3.1vw,2.5rem)] leading-[1.14] font-black tracking-[-0.035em] text-white">
                            {{ $post['title'] }}
                        </h1>
                        <div class="feature-meta">
                            <span>{{ strtoupper(\Illuminate\Support\Carbon::parse($post['date'])->format('F d, Y')) }}</span>
                            <span class="dot" aria-hidden="true"></span>
                            <span>{{ $post['author'] }}</span>
                            <span class="dot" aria-hidden="true"></span>
                            <span>{{ number_format($post['views']) }} DIBACA</span>
                        </div>
                    </div>
                </div>
                @else
                <div class="border-b border-line bg-[#f7f9fc] px-6 py-7 lg:px-9">
                    <span class="category-chip">{{ strtoupper($post['category']) }}</span>
                    <h1 class="mt-3 mb-3 text-[clamp(1.6rem,3.2vw,2.6rem)] leading-[1.14] font-black tracking-[-0.035em] text-navy-dark">
                        {{ $post['title'] }}
                    </h1>
                    <div class="flex flex-wrap items-center gap-2.5 text-[0.78rem] font-bold text-muted uppercase">
                        <span>{{ strtoupper(\Illuminate\Support\Carbon::parse($post['date'])->format('F d, Y')) }}</span>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ $post['author'] }}</span>
                    </div>
                </div>
                @endif

                {{-- Meta strip --}}
                <div class="flex flex-wrap items-center gap-x-5 gap-y-2 border-b border-line bg-[#f7f9fc] px-6 py-3.5 text-[0.78rem] lg:px-9">
                    <span class="flex items-center gap-2 font-semibold text-muted">
                        <svg class="size-4 text-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 7.5V12l3 2"></path>
                        </svg>
                        {{ \Illuminate\Support\Carbon::parse($post['date'])->translatedFormat('d F Y') }}
                    </span>
                    <span class="flex items-center gap-2 font-semibold text-muted">
                        <svg class="size-4 text-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="8" r="3.6"></circle>
                            <path d="M4.5 20c1.7-3 4.3-4.5 7.5-4.5s5.8 1.5 7.5 4.5"></path>
                        </svg>
                        {{ $post['author'] }}
                    </span>
                    <span class="flex items-center gap-2 font-semibold text-muted">
                        <svg class="size-4 text-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        {{ number_format($post['views']) }} kali dibaca
                    </span>
                    <span class="ml-auto rounded bg-blue/10 px-2.5 py-1 text-[0.72rem] font-bold text-blue">
                        {{ $post['category'] }}
                    </span>
                </div>

                {{-- Body --}}
                <div class="rich-copy px-6 py-7 lg:px-9 lg:py-9">
                    {!! $post['body'] !!}
                </div>

                {{-- Share row --}}
                <div class="flex flex-wrap items-center gap-3 border-t border-line bg-[#f7f9fc] px-6 py-4 lg:px-9">
                    <span class="text-[0.76rem] font-bold tracking-[0.05em] text-muted uppercase">Bagikan</span>
                    @foreach ([
                    ['label' => 'Facebook', 'url' => 'https://www.facebook.com/sharer/sharer.php?u='.urlencode(url()->current())],
                    ['label' => 'X', 'url' => 'https://twitter.com/intent/tweet?url='.urlencode(url()->current())],
                    ['label' => 'WhatsApp', 'url' => 'https://wa.me/?text='.urlencode($post['title'].' '.url()->current())],
                    ] as $share)
                    <a href="{{ $share['url'] }}" target="_blank" rel="noopener noreferrer"
                        class="rounded border border-line bg-white px-3 py-1.5 text-[0.76rem] font-bold text-navy-dark transition-colors hover:border-blue hover:bg-[#eef4ff] hover:text-blue">
                        {{ $share['label'] }}
                    </a>
                    @endforeach

                    <a href="{{ route('informasi') }}"
                        class="ml-auto flex items-center gap-1.5 text-[0.78rem] font-bold text-blue hover:underline">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 12H5"></path>
                            <path d="M12 19l-7-7 7-7"></path>
                        </svg>
                        Semua Berita
                    </a>
                </div>
            </div>

            {{-- =====================================================
                 Related posts
            ===================================================== --}}
            @if ($related->isNotEmpty())
            <section class="mt-6">
                <div class="mb-[18px] flex items-end border-b-2 border-line">
                    <span class="section-label">Baca Juga</span>
                </div>

                <div class="grid gap-[18px] sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($related as $item)
                    <a href="{{ route('berita.detail', $item['slug']) }}"
                        class="group flex min-h-[230px] items-end overflow-hidden rounded border border-line bg-cover bg-center"
                        style="background-image: url('{{ $item['image'] }}');">
                        <span class="card-overlay-sm w-full">
                            <span class="category-chip">{{ strtoupper($item['category']) }}</span>
                            <span class="mt-2 mb-1.5 line-clamp-3 block text-[0.9rem] leading-snug font-bold text-white group-hover:underline">
                                {{ $item['title'] }}
                            </span>
                            <span class="block text-[0.72rem] text-white/85">
                                {{ \Illuminate\Support\Carbon::parse($item['date'])->format('d M Y') }}
                            </span>
                        </span>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif
        </article>

        {{-- =====================================================
             Sidebar
        ===================================================== --}}
        <aside class="min-w-0 space-y-6">

            {{-- Search --}}
            <div class="rounded-lg border border-line bg-white p-5">
                <h2 class="mb-3 text-[0.9rem] font-extrabold tracking-[-0.01em] text-navy-dark">Cari Berita</h2>
                <form method="GET" action="{{ route('informasi') }}" class="flex items-stretch">
                    <input type="search" name="q" placeholder="Kata kunci..."
                        class="min-w-0 flex-1 rounded-l border border-r-0 border-line bg-[#f7f9fc] px-3.5 py-2.5 text-[0.88rem] text-ink outline-none transition-colors placeholder:text-[#a9b4c2] focus:border-blue focus:bg-white" />
                    <button type="submit" aria-label="Cari"
                        class="grid w-[46px] shrink-0 cursor-pointer place-items-center rounded-r border border-blue bg-blue text-white transition-colors hover:bg-[#125fbb]">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round">
                            <circle cx="11" cy="11" r="7"></circle>
                            <line x1="16.2" y1="16.2" x2="21" y2="21"></line>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Latest --}}
            <div class="overflow-hidden rounded-lg border border-line bg-white">
                <div class="border-b border-line px-5 py-3.5">
                    <h2 class="text-[0.9rem] font-extrabold tracking-[-0.01em] text-navy-dark">Berita Terbaru</h2>
                </div>

                @foreach ($latestPosts as $item)
                <a href="{{ route('berita.detail', $item['slug']) }}"
                    class="flex gap-3.5 border-b border-line px-4 py-3.5 transition-colors last:border-b-0 hover:bg-[#f7f9fc]">
                    <span class="size-[68px] shrink-0 rounded border border-line bg-cover bg-center"
                        style="background-image: url('{{ $item['image'] }}');" aria-hidden="true"></span>
                    <span class="min-w-0">
                        <span class="line-clamp-3 block text-[0.84rem] leading-snug font-bold text-navy-dark">
                            {{ $item['title'] }}
                        </span>
                        <span class="mt-1.5 block text-[0.72rem] text-muted">
                            {{ \Illuminate\Support\Carbon::parse($item['date'])->format('d M Y') }}
                        </span>
                    </span>
                </a>
                @endforeach
            </div>

            {{-- Shortcut back to the workspace --}}
            <div class="rounded-lg border border-line bg-navy-dark p-5 text-white">
                <h2 class="mb-2 text-[0.9rem] font-extrabold tracking-[-0.01em]">Kelola Konten</h2>
                <p class="mb-4 text-[0.8rem] leading-relaxed text-white/65">
                    Masuk ke workspace administrator untuk menambah atau mengubah berita.
                </p>
                <a href="{{ route('admin.login') }}"
                    class="inline-flex items-center gap-2 rounded bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] px-4 py-2.5 text-[0.76rem] font-extrabold tracking-[0.03em] uppercase shadow-[0_8px_18px_rgba(29,122,230,0.3)]">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <path d="M10 17l5-5-5-5"></path>
                        <path d="M15 12H3"></path>
                    </svg>
                    Login Admin
                </a>
            </div>
        </aside>
    </main>

    {{-- =====================================================
         Footer
    ===================================================== --}}
    <footer class="relative mt-2 overflow-hidden bg-gradient-to-b from-[#0a132a] to-[#080f22] text-white">
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