@extends('admin.layout')

@section('title', 'Kelola HKI')
@section('heading', 'Kelola HKI')
@section('subheading', 'Kelola arsip dan daftar kekayaan intelektual per tahun')

@section('content')
<div class="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-line bg-white p-5">
    <div>
        <h2 class="text-[0.95rem] font-extrabold text-navy-dark">Arsip HKI</h2>
        <p class="mt-1 text-[0.8rem] text-muted">{{ count($years) }} tahun arsip · {{ array_sum(array_map(fn ($row) => count($row['daftar'] ?? []), $years)) }} data karya</p>
    </div>
    <a href="{{ route('admin.hki.create') }}" class="inline-flex items-center gap-2 rounded bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] px-4 py-2.5 text-[0.78rem] font-extrabold text-white shadow hover:-translate-y-px">
        <span aria-hidden="true">＋</span> Tambah Arsip HKI
    </a>
</div>

<div class="overflow-hidden rounded-lg border border-line bg-white">
    <div class="hidden grid-cols-[100px_1fr_150px_180px] gap-4 border-b border-line bg-[#f7f9fc] px-5 py-3 text-[0.7rem] font-extrabold tracking-[0.05em] text-muted uppercase sm:grid">
        <span>Tahun</span><span>Ringkasan</span><span>Jumlah Karya</span><span class="text-right">Aksi</span>
    </div>
    @forelse ($years as $year => $record)
    <div class="grid gap-3 border-b border-line px-5 py-4 last:border-b-0 sm:grid-cols-[100px_1fr_150px_180px] sm:items-center sm:gap-4">
        <strong class="text-[1.05rem] text-navy-dark">{{ $year }}</strong>
        <span class="text-[0.82rem] leading-relaxed text-muted">
            {{ collect($record['ringkasan']['rincian'] ?? [])->map(fn ($item) => ($item['jenis'] ?? 'HKI') . ' (' . ($item['jumlah'] ?? 0) . ')')->implode(', ') ?: 'Belum ada ringkasan jenis' }}
        </span>
        <span class="text-[0.82rem] font-bold text-navy-dark">{{ count($record['daftar'] ?? []) }} karya</span>
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.hki.edit', $year) }}" class="rounded border border-line px-3 py-1.5 text-[0.74rem] font-bold text-navy-dark hover:border-blue hover:text-blue">Kelola</a>
            <form method="POST" action="{{ route('admin.hki.destroy', $year) }}" data-confirm="Hapus seluruh arsip HKI tahun {{ $year }}?">
                @csrf @method('DELETE')
                <button class="cursor-pointer rounded border border-[#f0d0d0] px-3 py-1.5 text-[0.74rem] font-bold text-[#c0392b] hover:bg-[#fdf2f2]">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <p class="px-5 py-10 text-center text-[0.84rem] text-muted">Belum ada arsip HKI.</p>
    @endforelse
</div>

<p class="mt-4 rounded border border-line border-l-4 border-l-blue bg-white px-4 py-3 text-[0.78rem] leading-relaxed text-muted">
    Data HKI disimpan pada <code class="font-mono text-navy-dark">resources/data/hki.php</code> dan langsung dipakai oleh halaman arsip publik.
</p>
@endsection
