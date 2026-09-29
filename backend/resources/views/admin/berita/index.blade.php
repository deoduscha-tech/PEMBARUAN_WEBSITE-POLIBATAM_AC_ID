@extends('admin.layout')

@section('title', 'Kelola Berita')
@section('heading', 'Kelola Berita')
@section('subheading', 'Tambah, ubah, terbitkan, atau hapus berita')

@section('content')

{{-- =====================================================
         Filters
    ===================================================== --}}
@php
$tabs = [
'all' => 'Semua',
'published' => 'Terbit',
'draft' => 'Draf',
'featured' => 'Sorotan',
];
@endphp

<div class="mb-5 rounded-lg border border-line bg-white p-4">
    <form method="GET" action="{{ route('admin.berita.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative min-w-0 flex-1">
            <span class="pointer-events-none absolute top-1/2 left-3 -translate-y-1/2 text-[#9aa7b6]">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                    <circle cx="11" cy="11" r="7"></circle>
                    <line x1="16.2" y1="16.2" x2="21" y2="21"></line>
                </svg>
            </span>
            <input type="search" name="q" value="{{ $search }}"
                placeholder="Cari judul, kategori, atau ringkasan..."
                class="w-full rounded border border-line bg-[#f7f9fc] py-2.5 pr-3 pl-9 text-[0.88rem] text-ink outline-none transition-colors placeholder:text-[#a9b4c2] focus:border-blue focus:bg-white focus:ring-2 focus:ring-blue/15" />
        </div>

        <input type="hidden" name="status" value="{{ $status }}" />

        <button type="submit"
            class="shrink-0 cursor-pointer rounded border border-line bg-[#f7f9fc] px-4 py-2.5 text-[0.78rem] font-extrabold tracking-[0.03em] text-navy-dark uppercase transition-colors hover:border-blue hover:bg-[#eef4ff] hover:text-blue">
            Cari
        </button>

        @if ($search !== '')
        <a href="{{ route('admin.berita.index', ['status' => $status]) }}"
            class="shrink-0 rounded border border-line px-4 py-2.5 text-center text-[0.78rem] font-bold text-muted transition-colors hover:border-[#e05252] hover:text-[#c0392b]">
            Reset
        </a>
        @endif
    </form>

    <div class="mt-3.5 flex flex-wrap items-center gap-2 border-t border-line pt-3.5">
        @foreach ($tabs as $key => $label)
        @php $isActive = $status === $key; @endphp
        <a href="{{ route('admin.berita.index', array_filter(['status' => $key, 'q' => $search])) }}"
            class="rounded px-3 py-1.5 text-[0.78rem] font-bold transition-colors
                          {{ $isActive ? 'bg-blue text-white' : 'bg-[#f3f5f7] text-navy-dark hover:bg-[#e8eef7]' }}">
            {{ $label }}
        </a>
        @endforeach

        <span class="ml-auto text-[0.78rem] text-muted">
            {{ $posts->count() }} berita ditampilkan
        </span>
    </div>
</div>

{{-- =====================================================
         Table
    ===================================================== --}}
<div class="overflow-hidden rounded-lg border border-line bg-white">

    {{-- Desktop header --}}
    <div class="hidden items-center gap-4 border-b border-line bg-[#f7f9fc] px-5 py-3 text-[0.7rem] font-bold tracking-[0.06em] text-muted uppercase lg:flex">
        <span class="w-[76px] shrink-0">Gambar</span>
        <span class="min-w-0 flex-1">Judul</span>
        <span class="w-[110px] shrink-0">Kategori</span>
        <span class="w-[110px] shrink-0">Tanggal</span>
        <span class="w-[80px] shrink-0 text-right">Dibaca</span>
        <span class="w-[110px] shrink-0">Status</span>
        <span class="w-[140px] shrink-0 text-right">Aksi</span>
    </div>

    @forelse ($posts as $post)
    <div class="flex flex-col gap-3.5 border-b border-line px-5 py-4 last:border-b-0 hover:bg-[#fafbfd] lg:flex-row lg:items-center lg:gap-4">

        {{-- Thumbnail --}}
        <span class="hidden size-[56px] shrink-0 rounded border border-line bg-cover bg-center lg:block"
            style="background-image: url('{{ $post['image'] }}');" aria-hidden="true"></span>

        {{-- Title + meta --}}
        <span class="min-w-0 flex-1">
            <span class="flex items-start gap-3">
                <span class="size-[52px] shrink-0 rounded border border-line bg-cover bg-center lg:hidden"
                    style="background-image: url('{{ $post['image'] }}');" aria-hidden="true"></span>
                <span class="min-w-0">
                    <a href="{{ route('berita.detail', $post['slug']) }}" target="_blank"
                        class="line-clamp-2 block text-[0.9rem] leading-snug font-bold text-navy-dark hover:text-blue">
                        {{ $post['title'] }}
                    </a>
                    <span class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-[0.72rem] text-muted lg:hidden">
                        <span>{{ $post['category'] }}</span>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ \Illuminate\Support\Carbon::parse($post['date'])->format('d M Y') }}</span>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ number_format($post['views']) }} dibaca</span>
                    </span>
                </span>
            </span>
        </span>

        {{-- Category --}}
        <span class="hidden w-[110px] shrink-0 lg:block">
            <span class="inline-block rounded bg-blue/10 px-2 py-1 text-[0.7rem] font-bold text-blue">
                {{ $post['category'] }}
            </span>
        </span>

        {{-- Date --}}
        <span class="hidden w-[110px] shrink-0 text-[0.8rem] text-muted lg:block">
            {{ \Illuminate\Support\Carbon::parse($post['date'])->format('d M Y') }}
        </span>

        {{-- Views --}}
        <span class="hidden w-[80px] shrink-0 text-right text-[0.8rem] font-bold text-navy-dark lg:block">
            {{ number_format($post['views']) }}
        </span>

        {{-- Status --}}
        <span class="flex w-full shrink-0 flex-wrap items-center gap-1.5 lg:w-[110px]">
            @if ($post['published'])
            <span class="rounded bg-[#2bb673]/12 px-2 py-0.5 text-[0.68rem] font-bold tracking-[0.04em] text-[#1c7a4d] uppercase">Terbit</span>
            @else
            <span class="rounded bg-gold/20 px-2 py-0.5 text-[0.68rem] font-bold tracking-[0.04em] text-[#9a6d05] uppercase">Draf</span>
            @endif

            @if ($post['featured'])
            <span class="rounded bg-blue/12 px-2 py-0.5 text-[0.68rem] font-bold tracking-[0.04em] text-blue uppercase">Sorotan</span>
            @endif
        </span>

        {{-- Actions --}}
        <span class="flex w-full shrink-0 items-center gap-2 lg:w-[140px] lg:justify-end">
            <a href="{{ route('berita.detail', $post['slug']) }}" target="_blank"
                class="rounded border border-line p-2 text-[#6d7a8b] transition-colors hover:border-blue hover:bg-[#eef4ff] hover:text-blue"
                aria-label="Lihat {{ $post['title'] }}">
                <svg class="size-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
            </a>

            <a href="{{ route('admin.berita.edit', $post['id']) }}"
                class="flex items-center gap-1.5 rounded border border-line px-2.5 py-1.5 text-[0.74rem] font-bold text-navy-dark transition-colors hover:border-blue hover:bg-[#eef4ff] hover:text-blue">
                <svg class="size-[13px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9"></path>
                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                </svg>
                Edit
            </a>

            <form method="POST" action="{{ route('admin.berita.destroy', $post['id']) }}"
                data-confirm="Hapus berita &quot;{{ $post['title'] }}&quot;? Tindakan ini tidak dapat dibatalkan."
                class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="cursor-pointer rounded border border-line p-2 text-[#c0392b] transition-colors hover:border-[#e05252] hover:bg-[#fdf2f2]"
                    aria-label="Hapus {{ $post['title'] }}">
                    <svg class="size-[15px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"></path>
                        <path d="M8 6V4h8v2"></path>
                        <path d="M6 6v14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V6"></path>
                        <path d="M10 11v6"></path>
                        <path d="M14 11v6"></path>
                    </svg>
                </button>
            </form>
        </span>
    </div>
    @empty
    <div class="px-5 py-14 text-center">
        <svg class="mx-auto mb-3 size-10 text-[#c3cdd9]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 5h11a2 2 0 0 1 2 2v12H6a2 2 0 0 1-2-2z"></path>
            <path d="M17 8h3v9a2 2 0 0 1-2 2"></path>
        </svg>
        <p class="text-[0.9rem] font-bold text-navy-dark">Tidak ada berita ditemukan</p>
        <p class="mt-1 text-[0.82rem] text-muted">
            @if ($search !== '')
            Tidak ada hasil untuk "{{ $search }}". Coba kata kunci lain.
            @else
            Mulai dengan menambahkan berita pertama.
            @endif
        </p>
        <a href="{{ route('admin.berita.create') }}"
            class="mt-4 inline-flex items-center gap-2 rounded bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] px-4 py-2.5 text-[0.78rem] font-extrabold tracking-[0.03em] text-white uppercase">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                <path d="M12 5v14"></path>
                <path d="M5 12h14"></path>
            </svg>
            Tulis Berita
        </a>
    </div>
    @endforelse
</div>

@endsection