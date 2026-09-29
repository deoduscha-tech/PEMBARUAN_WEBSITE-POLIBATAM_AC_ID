<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Pusat P2M Polibatam</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/images/cropped-Logo-Polibatam-3-32x32.png">
    <link rel="apple-touch-icon" href="/images/cropped-Logo-Polibatam-3-32x32.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col items-center justify-center bg-navy-dark px-4 py-10">

    {{-- Ambient background, echoing the hero treatment. --}}
    <div class="pointer-events-none fixed -top-40 left-1/2 size-[640px] -translate-x-1/2 rounded-full bg-blue/20 blur-[130px]"></div>
    <div class="pointer-events-none fixed -bottom-56 -left-24 size-[520px] rounded-full bg-blue-bright/10 blur-[130px]"></div>

    <main class="relative z-10 w-full max-w-[440px]">

        {{-- =====================================================
             Brand lockup
        ===================================================== --}}
        <a href="{{ route('home') }}" class="mb-7 flex flex-col items-center gap-3 text-center">
            <span class="site-logo" role="img" aria-label="Logo Pusat P2M Polibatam"></span>
            <span class="block">
                <span class="block text-[1.15rem] leading-tight font-extrabold tracking-[-0.02em] text-white">
                    Pusat P2M Polibatam
                </span>
                <span class="mt-0.5 block text-[0.72rem] font-semibold tracking-[0.16em] text-white/45 uppercase">
                    Politeknik Negeri Batam
                </span>
            </span>
        </a>

        {{-- =====================================================
             Sign-in card
        ===================================================== --}}
        <div class="overflow-hidden rounded-lg border border-white/10 bg-white shadow-[0_30px_70px_rgba(3,10,24,0.5)]">

            {{-- Card header --}}
            <div class="border-b border-line bg-[#f7f9fc] px-7 py-5">
                <div class="flex items-center gap-2.5">
                    <span class="grid size-8 place-items-center rounded-md bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf]">
                        <svg class="size-[15px] text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </span>
                    <div>
                        <h1 class="text-[1.05rem] leading-tight font-extrabold tracking-[-0.02em] text-navy-dark">
                            Masuk Workspace Admin
                        </h1>
                        <p class="mt-0.5 text-[0.78rem] text-muted">Kelola berita dan pengumuman P3M</p>
                    </div>
                </div>
            </div>

            <div class="px-7 py-6">

                {{-- Session feedback --}}
                @if (session('success'))
                    <div class="mb-5 flex items-start gap-2.5 rounded border-l-4 border-[#2bb673] bg-[#f0fbf5] px-3.5 py-3 text-[0.82rem] leading-relaxed text-[#1c7a4d]">
                        <svg class="mt-px size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6 9 17l-5-5"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 flex items-start gap-2.5 rounded border-l-4 border-[#e05252] bg-[#fdf2f2] px-3.5 py-3 text-[0.82rem] leading-relaxed text-[#a72a2a]">
                        <svg class="mt-px size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 8v4"></path>
                            <path d="M12 16h.01"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-4" novalidate>
                    @csrf

                    {{-- Username --}}
                    <div>
                        <label for="username" class="mb-1.5 block text-[0.72rem] font-bold tracking-[0.04em] text-navy-dark uppercase">
                            Nama Pengguna
                        </label>
                        <div class="flex items-stretch">
                            <span class="grid w-[42px] shrink-0 place-items-center border border-r-0 border-line bg-[#f7f9fc] text-[#8593a5]">
                                <svg class="size-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="8" r="3.6"></circle>
                                    <path d="M4.5 20c1.7-3 4.3-4.5 7.5-4.5s5.8 1.5 7.5 4.5"></path>
                                </svg>
                            </span>
                            <input
                                id="username"
                                name="username"
                                type="text"
                                value="{{ old('username') }}"
                                autocomplete="username"
                                autofocus
                                required
                                placeholder="admin"
                                class="min-w-0 flex-1 border bg-white px-3.5 py-2.5 text-[0.92rem] text-ink outline-none transition-colors placeholder:text-[#a9b4c2] focus:border-blue focus:ring-2 focus:ring-blue/15 @error('username') border-[#e05252] @else border-line @enderror" />
                        </div>
                        @error('username')
                            <p class="mt-1.5 flex items-center gap-1.5 text-[0.76rem] font-semibold text-[#d14343]">
                                <svg class="size-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M12 8v4"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="mb-1.5 block text-[0.72rem] font-bold tracking-[0.04em] text-navy-dark uppercase">
                            Kata Sandi
                        </label>
                        <div class="flex items-stretch">
                            <span class="grid w-[42px] shrink-0 place-items-center border border-r-0 border-line bg-[#f7f9fc] text-[#8593a5]">
                                <svg class="size-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="4" y="10.5" width="16" height="9.5" rx="2"></rect>
                                    <path d="M8 10.5V7a4 4 0 0 1 8 0v3.5"></path>
                                </svg>
                            </span>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                placeholder="Masukkan kata sandi"
                                class="min-w-0 flex-1 border border-r-0 bg-white px-3.5 py-2.5 text-[0.92rem] text-ink outline-none transition-colors placeholder:text-[#a9b4c2] focus:border-blue focus:ring-2 focus:ring-blue/15 @error('password') border-[#e05252] @else border-line @enderror" />
                            <button
                                type="button"
                                id="toggle-password"
                                class="grid w-[42px] shrink-0 cursor-pointer place-items-center border border-line bg-[#f7f9fc] text-[#8593a5] transition-colors hover:bg-[#eef4ff] hover:text-blue"
                                aria-label="Tampilkan kata sandi">
                                <svg class="size-[16px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 flex items-center gap-1.5 text-[0.76rem] font-semibold text-[#d14343]">
                                <svg class="size-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M12 8v4"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <label class="flex cursor-pointer items-center gap-2.5 pt-1 text-[0.82rem] text-muted select-none">
                        <input type="checkbox" name="remember" value="1" class="size-4 cursor-pointer accent-[#1c73d9]" />
                        Ingat saya di perangkat ini
                    </label>

                    <button type="submit"
                            class="mt-1 flex w-full cursor-pointer items-center justify-center gap-2 rounded bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] px-5 py-3 text-[0.86rem] font-extrabold tracking-[0.04em] text-white uppercase shadow-[0_10px_24px_rgba(29,122,230,0.3)] transition-all hover:-translate-y-px hover:shadow-[0_14px_30px_rgba(29,122,230,0.4)] active:translate-y-0">
                        <svg class="size-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <path d="M10 17l5-5-5-5"></path>
                            <path d="M15 12H3"></path>
                        </svg>
                        Masuk
                    </button>
                </form>
            </div>

            {{-- Demo credentials, clearly separated from the form. --}}
            <div class="flex items-center justify-between gap-4 border-t border-line bg-[#f7f9fc] px-7 py-3.5">
                <span class="text-[0.68rem] font-bold tracking-[0.08em] text-muted uppercase">Akun demo</span>
                <span class="flex items-center gap-2 font-mono text-[0.78rem] text-navy-dark">
                    <code class="rounded bg-white px-2 py-1 ring-1 ring-line">{{ config('admin.username') }}</code>
                    <span class="text-muted">/</span>
                    <code class="rounded bg-white px-2 py-1 ring-1 ring-line">{{ config('admin.password') }}</code>
                </span>
            </div>
        </div>

        <a href="{{ route('home') }}"
           class="mt-6 flex items-center justify-center gap-1.5 text-[0.82rem] font-semibold text-white/50 transition-colors hover:text-white">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5"></path>
                <path d="M12 19l-7-7 7-7"></path>
            </svg>
            Kembali ke situs
        </a>
    </main>

    <script>
        // Show / hide the password without pulling in a framework.
        document.getElementById('toggle-password')?.addEventListener('click', function () {
            const input = document.getElementById('password');
            const showing = input.type === 'text';

            input.type = showing ? 'password' : 'text';
            this.setAttribute('aria-label', showing ? 'Tampilkan kata sandi' : 'Sembunyikan kata sandi');
            this.classList.toggle('text-blue', !showing);
        });
    </script>
</body>

</html>