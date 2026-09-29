@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('heading', 'Dashboard')
@section('subheading', 'Ringkasan konten Pusat P2M Polibatam')

@section('content')

{{-- =====================================================
         Stat cards
    ===================================================== --}}
@php
$cards = [
['label' => 'Total Berita', 'value' => number_format($stats['total']), 'tone' => 'blue', 'icon' => '<path d="M4 5h11a2 2 0 0 1 2 2v12H6a2 2 0 0 1-2-2z"></path>
<path d="M17 8h3v9a2 2 0 0 1-2 2"></path>'],
['label' => 'Terbit', 'value' => number_format($stats['published']), 'tone' => 'green', 'icon' => '<circle cx="12" cy="12" r="9"></circle>
<path d="m8.5 12.5 2.5 2.5 4.5-5"></path>'],
['label' => 'Draf', 'value' => number_format($stats['draft']), 'tone' => 'amber', 'icon' => '<path d="M12 20h9"></path>
<path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>'],
['label' => 'Total Dibaca', 'value' => number_format($stats['views']), 'tone' => 'purple', 'icon' => '<path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"></path>
<circle cx="12" cy="12" r="3"></circle>'],
];

$tones = [
'blue' => ['bg' => 'bg-blue', 'text' => 'text-blue', 'soft' => 'bg-blue/10'],
'green' => ['bg' => 'bg-[#2bb673]', 'text' => 'text-[#1c7a4d]', 'soft' => 'bg-[#2bb673]/10'],
'amber' => ['bg' => 'bg-gold', 'text' => 'text-[#9a6d05]', 'soft' => 'bg-gold/15'],
'purple' => ['bg' => 'bg-[#7a5cd6]', 'text' => 'text-[#5c43a8]', 'soft' => 'bg-[#7a5cd6]/10'],
];
@endphp

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach ($cards as $card)
    @php $tone = $tones[$card['tone']]; @endphp
    <div class="flex items-start gap-4 rounded-lg border border-line bg-white p-4 shadow-[0_4px_14px_rgba(12,24,54,0.05)]">
        <span class="grid size-11 shrink-0 place-items-center rounded-md {{ $tone['soft'] }} {{ $tone['text'] }}">
            <svg class="size-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                {!! $card['icon'] !!}
            </svg>
        </span>
        <span class="min-w-0">
            <span class="block text-[0.72rem] font-bold tracking-[0.05em] text-muted uppercase">{{ $card['label'] }}</span>
            <span class="mt-1 block text-[1.65rem] leading-none font-black tracking-[-0.03em] text-navy-dark">
                {{ $card['value'] }}
            </span>
        </span>
    </div>
    @endforeach
</div>

{{-- =====================================================
         Quick actions
    ===================================================== --}}
<div class="mt-5 rounded-lg border border-line bg-white p-5">
    <h2 class="mb-3.5 text-[0.9rem] font-extrabold tracking-[-0.01em] text-navy-dark">Aksi Cepat</h2>
    <div class="flex flex-wrap gap-2.5">
        <a href="{{ route('admin.berita.create') }}"
            class="inline-flex items-center gap-2 rounded bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] px-4 py-2.5 text-[0.78rem] font-extrabold tracking-[0.03em] text-white uppercase shadow-[0_8px_18px_rgba(29,122,230,0.28)] transition-transform hover:-translate-y-px">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                <path d="M12 5v14"></path>
                <path d="M5 12h14"></path>
            </svg>
            Tulis Berita Baru
        </a>
        <a href="{{ route('admin.berita.index') }}"
            class="inline-flex items-center gap-2 rounded border border-line bg-[#f7f9fc] px-4 py-2.5 text-[0.78rem] font-extrabold tracking-[0.03em] text-navy-dark uppercase transition-colors hover:border-blue hover:bg-[#eef4ff] hover:text-blue">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8 6h13"></path>
                <path d="M8 12h13"></path>
                <path d="M8 18h13"></path>
                <path d="M3 6h.01"></path>
                <path d="M3 12h.01"></path>
                <path d="M3 18h.01"></path>
            </svg>
            Kelola Semua Berita
        </a>
        <a href="{{ route('home') }}" target="_blank"
            class="inline-flex items-center gap-2 rounded border border-line bg-[#f7f9fc] px-4 py-2.5 text-[0.78rem] font-extrabold tracking-[0.03em] text-navy-dark uppercase transition-colors hover:border-blue hover:bg-[#eef4ff] hover:text-blue">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 4h6v6"></path>
                <path d="M20 4 10 14"></path>
                <path d="M18 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h5"></path>
            </svg>
            Lihat Situs
        </a>
    </div>
</div>

{{-- =====================================================
         Recent + popular
    ===================================================== --}}
<div class="mt-5 grid gap-5 xl:grid-cols-2">

    {{-- Recently edited --}}
    <div class="overflow-hidden rounded-lg border border-line bg-white">
        <div class="flex items-center justify-between border-b border-line px-5 py-3.5">
            <h2 class="text-[0.9rem] font-extrabold tracking-[-0.01em] text-navy-dark">Berita Terbaru</h2>
            <a href="{{ route('admin.berita.index') }}" class="text-[0.76rem] font-bold text-blue hover:underline">Lihat semua</a>
        </div>

        @forelse ($recent as $post)
        <div class="flex items-center gap-3.5 border-b border-line px-5 py-3.5 last:border-b-0">
            <span class="size-[52px] shrink-0 rounded border border-line bg-cover bg-center"
                style="background-image: url('{{ $post['image'] }}');" aria-hidden="true"></span>
            <span class="min-w-0 flex-1">
                <a href="{{ route('berita.detail', $post['slug']) }}" target="_blank"
                    class="line-clamp-1 block text-[0.86rem] font-bold text-navy-dark hover:text-blue">
                    {{ $post['title'] }}
                </a>
                <span class="mt-1 flex flex-wrap items-center gap-2 text-[0.72rem] text-muted">
                    <span>{{ \Illuminate\Support\Carbon::parse($post['date'])->format('d M Y') }}</span>
                    <span aria-hidden="true">&middot;</span>
                    <span>{{ number_format($post['views']) }} dibaca</span>
                    @unless ($post['published'])
                    <span class="rounded bg-gold/20 px-1.5 py-0.5 font-bold text-[#9a6d05]">DRAF</span>
                    @endunless
                    @if ($post['featured'])
                    <span class="rounded bg-blue/12 px-1.5 py-0.5 font-bold text-blue">SOROTAN</span>
                    @endif
                </span>
            </span>
            <a href="{{ route('admin.berita.edit', $post['id']) }}"
                class="shrink-0 rounded border border-line px-2.5 py-1.5 text-[0.72rem] font-bold text-navy-dark transition-colors hover:border-blue hover:bg-[#eef4ff] hover:text-blue">
                Edit
            </a>
        </div>
        @empty
        <p class="px-5 py-8 text-center text-[0.84rem] text-muted">Belum ada berita.</p>
        @endforelse
    </div>

    {{-- Most read --}}
    <div class="overflow-hidden rounded-lg border border-line bg-white">
        <div class="border-b border-line px-5 py-3.5">
            <h2 class="text-[0.9rem] font-extrabold tracking-[-0.01em] text-navy-dark">Paling Banyak Dibaca</h2>
        </div>

        @forelse ($popular as $index => $post)
        <div class="flex items-center gap-3.5 border-b border-line px-5 py-3.5 last:border-b-0">
            <span class="grid size-7 shrink-0 place-items-center rounded bg-[#f3f5f7] text-[0.78rem] font-black text-navy-dark">
                {{ $index + 1 }}
            </span>
            <span class="min-w-0 flex-1">
                <a href="{{ route('berita.detail', $post['slug']) }}" target="_blank"
                    class="line-clamp-2 block text-[0.85rem] leading-snug font-bold text-navy-dark hover:text-blue">
                    {{ $post['title'] }}
                </a>
                <span class="mt-1 block text-[0.72rem] text-muted">
                    {{ $post['category'] }} &middot; {{ number_format($post['views']) }} dibaca
                </span>
            </span>
        </div>
        @empty
        <p class="px-5 py-8 text-center text-[0.84rem] text-muted">Belum ada data.</p>
        @endforelse
    </div>
</div>

{{-- Storage note --}}
<div class="mt-5 flex items-start gap-2.5 rounded border border-line border-l-4 border-l-blue bg-white px-4 py-3.5 text-[0.82rem] leading-relaxed text-muted">
    <svg class="mt-px size-4 shrink-0 text-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
        <circle cx="12" cy="12" r="9"></circle>
        <path d="M12 11v5"></path>
        <path d="M12 8h.01"></path>
    </svg>
    <span>
        Berita disimpan pada berkas <code class="rounded bg-[#f3f5f7] px-1.5 py-0.5 font-mono text-[0.78rem] text-navy-dark">resources/data/berita.php</code>.
        Perubahan langsung tersimpan tanpa memerlukan basis data.
    </span>
</div>

@endsection