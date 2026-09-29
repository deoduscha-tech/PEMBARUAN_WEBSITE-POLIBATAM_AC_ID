@php
$admin = session(config('admin.session_key'), []);
$adminName = $admin['name'] ?? 'Administrator';

$menu = [
['label' => 'Dashboard', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'icon' => 'grid'],
['label' => 'Kelola Berita', 'route' => 'admin.berita.index', 'pattern' => 'admin.berita.*', 'icon' => 'news'],
['label' => 'Tulis Berita', 'route' => 'admin.berita.create', 'pattern' => 'admin.berita.create', 'icon' => 'plus'],
];

$icons = [
'grid' => '<rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
<rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
<rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
<rect x="14" y="14" width="7" height="7" rx="1.5"></rect>',
'news' => '<path d="M4 5h11a2 2 0 0 1 2 2v12H6a2 2 0 0 1-2-2z"></path>
<path d="M17 8h3v9a2 2 0 0 1-2 2"></path>
<path d="M7 9h6"></path>
<path d="M7 13h6"></path>',
'plus' => '<circle cx="12" cy="12" r="9"></circle>
<path d="M12 8v8"></path>
<path d="M8 12h8"></path>',
];
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Workspace Admin') — Pusat P2M Polibatam</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/images/cropped-Logo-Polibatam-3-32x32.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#eef1f5]">

    <div class="flex min-h-screen">

        {{-- =====================================================
             Sidebar
        ===================================================== --}}
        <aside class="hidden w-[250px] shrink-0 flex-col bg-navy-dark lg:flex">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 border-b border-white/10 px-5 py-5">
                <span class="site-logo !size-10 !rounded-md !border-0" role="img" aria-label="Logo P3M"></span>
                <span class="min-w-0">
                    <span class="block truncate text-[0.92rem] leading-tight font-extrabold text-white">Pusat P2M</span>
                    <span class="block text-[0.66rem] font-semibold tracking-[0.14em] text-white/40 uppercase">Admin Panel</span>
                </span>
            </a>

            <nav class="flex-1 space-y-1 px-3 py-5">
                @foreach ($menu as $item)
                @php $isActive = request()->routeIs($item['pattern']); @endphp
                <a href="{{ route($item['route']) }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2.5 text-[0.85rem] font-bold transition-colors
                              {{ $isActive ? 'bg-blue text-white shadow-[0_8px_18px_rgba(28,115,217,0.35)]' : 'text-white/65 hover:bg-white/8 hover:text-white' }}">
                    <svg class="size-[17px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        {!! $icons[$item['icon']] !!}
                    </svg>
                    {{ $item['label'] }}
                </a>
                @endforeach
            </nav>

            <div class="border-t border-white/10 p-3">
                <a href="{{ route('home') }}" target="_blank"
                    class="flex items-center gap-3 rounded-md px-3 py-2.5 text-[0.82rem] font-semibold text-white/55 transition-colors hover:bg-white/8 hover:text-white">
                    <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 4h6v6"></path>
                        <path d="M20 4 10 14"></path>
                        <path d="M18 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h5"></path>
                    </svg>
                    Lihat Situs
                </a>
            </div>
        </aside>

        {{-- =====================================================
             Main column
        ===================================================== --}}
        <div class="flex min-w-0 flex-1 flex-col">

            {{-- Top bar --}}
            <header class="flex items-center justify-between gap-4 border-b border-line bg-white px-5 py-3.5 lg:px-7">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="site-logo !size-9 !rounded-md !border-0 lg:hidden" role="img" aria-label="Logo P3M"></a>
                    <div>
                        <h1 class="text-[1.05rem] leading-tight font-extrabold tracking-[-0.02em] text-navy-dark">
                            @yield('heading', 'Dashboard')
                        </h1>
                        <p class="mt-0.5 text-[0.76rem] text-muted">@yield('subheading', 'Workspace administrator P3M')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.berita.create') }}"
                        class="hidden items-center gap-1.5 rounded bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] px-3.5 py-2 text-[0.76rem] font-extrabold tracking-[0.03em] text-white uppercase shadow-[0_8px_18px_rgba(29,122,230,0.3)] transition-transform hover:-translate-y-px sm:inline-flex">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                            <path d="M12 5v14"></path>
                            <path d="M5 12h14"></path>
                        </svg>
                        Berita Baru
                    </a>

                    <div class="flex items-center gap-2.5 border-l border-line pl-3.5">
                        <span class="grid size-8 shrink-0 place-items-center rounded-full bg-navy-dark text-[0.72rem] font-extrabold text-white">
                            {{ mb_strtoupper(mb_substr($adminName, 0, 1)) }}
                        </span>
                        <span class="hidden leading-tight sm:block">
                            <span class="block text-[0.8rem] font-bold text-navy-dark">{{ $adminName }}</span>
                            <span class="block text-[0.7rem] text-muted">Administrator</span>
                        </span>

                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex cursor-pointer items-center gap-1.5 rounded border border-line bg-white px-2.5 py-1.5 text-[0.74rem] font-bold text-[#c0392b] transition-colors hover:border-[#e05252] hover:bg-[#fdf2f2]">
                                <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M9 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h4"></path>
                                    <path d="M16 17l5-5-5-5"></path>
                                    <path d="M21 12H9"></path>
                                </svg>
                                <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- Mobile nav --}}
            <nav class="flex items-center gap-2 overflow-x-auto border-b border-line bg-white px-5 py-2.5 lg:hidden">
                @foreach ($menu as $item)
                @php $isActive = request()->routeIs($item['pattern']); @endphp
                <a href="{{ route($item['route']) }}"
                    class="shrink-0 rounded px-3 py-1.5 text-[0.78rem] font-bold whitespace-nowrap transition-colors
                              {{ $isActive ? 'bg-blue text-white' : 'bg-[#f3f5f7] text-navy-dark hover:bg-[#e8eef7]' }}">
                    {{ $item['label'] }}
                </a>
                @endforeach
            </nav>

            {{-- Flash message --}}
            @if (session('success'))
            <div class="mx-5 mt-5 flex items-start gap-2.5 rounded border-l-4 border-[#2bb673] bg-[#f0fbf5] px-4 py-3 text-[0.84rem] leading-relaxed text-[#1c7a4d] lg:mx-7">
                <svg class="mt-px size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6 9 17l-5-5"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <main class="flex-1 px-5 py-5 lg:px-7 lg:py-7">
                @yield('content')
            </main>

            <footer class="border-t border-line px-5 py-4 text-center text-[0.74rem] text-muted lg:px-7">
                Pusat P2M Polibatam &middot; Politeknik Negeri Batam
            </footer>
        </div>
    </div>

    {{-- Shared confirm dialog for destructive actions --}}
    <script>
        document.querySelectorAll('form[data-confirm]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!window.confirm(form.dataset.confirm)) {
                    event.preventDefault();
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>