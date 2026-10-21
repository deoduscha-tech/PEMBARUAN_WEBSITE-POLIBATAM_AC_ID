@extends('admin.layout')

@php($isEdit = $year !== null)
@section('title', $isEdit ? 'Kelola HKI ' . $year : 'Tambah Arsip HKI')
@section('heading', $isEdit ? 'Kelola HKI ' . $year : 'Tambah Arsip HKI')
@section('subheading', 'Atur tahun arsip dan daftar karya kekayaan intelektual')

@section('content')
<form method="POST" action="{{ $isEdit ? route('admin.hki.update', $year) : route('admin.hki.store') }}" class="mx-auto max-w-5xl space-y-5">
    @csrf
    @if ($isEdit) @method('PUT') @endif
    <div class="rounded-lg border border-line bg-white p-5">
        <label for="year" class="mb-1.5 block text-[0.72rem] font-bold uppercase tracking-[0.05em] text-navy-dark">Tahun arsip <span class="text-[#d14343]">*</span></label>
        @if ($isEdit)
        <input id="year" value="{{ $year }}" disabled class="w-full max-w-xs rounded border border-line bg-[#f7f9fc] px-3.5 py-2.5 text-[0.9rem] text-muted" />
        @else
        <input id="year" name="year" type="number" min="1900" max="2100" value="{{ old('year') }}" required placeholder="2026" class="w-full max-w-xs rounded border border-line px-3.5 py-2.5 text-[0.9rem] outline-none focus:border-blue focus:ring-2 focus:ring-blue/15" />
        @endif
        @error('year')<p class="mt-1.5 text-[0.76rem] font-semibold text-[#d14343]">{{ $message }}</p>@enderror
    </div>

    <div class="rounded-lg border border-line bg-white p-5">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div><h2 class="text-[0.9rem] font-extrabold text-navy-dark">Daftar karya</h2><p class="mt-1 text-[0.76rem] text-muted">Setiap baris menjadi satu entri pada tabel HKI publik.</p></div>
            <button type="button" id="add-record" class="rounded border border-line bg-[#f7f9fc] px-3 py-2 text-[0.76rem] font-bold text-navy-dark hover:border-blue hover:text-blue">＋ Tambah karya</button>
        </div>
        @error('daftar')<p class="mb-3 text-[0.78rem] font-semibold text-[#d14343]">{{ $message }}</p>@enderror
        <div id="records" class="space-y-4">
            @php($rows = old('daftar', $record['daftar'] ?? [['judul' => '', 'jenis' => '', 'pencipta' => '', 'nomor' => '']]))
            @foreach ($rows as $i => $row)
            <section class="record-row relative rounded border border-line bg-[#f9fafc] p-4">
                <div class="mb-3 flex items-center justify-between"><strong class="text-[0.78rem] text-navy-dark">Karya <span class="row-number">{{ $i + 1 }}</span></strong><button type="button" class="remove-record text-[0.74rem] font-bold text-[#c0392b] hover:underline">Hapus baris</button></div>
                <div class="grid gap-3 md:grid-cols-2">
                    @foreach (['judul' => 'Judul karya', 'jenis' => 'Jenis HKI', 'pencipta' => 'Nama pencipta', 'nomor' => 'Nomor permohonan/pendaftaran'] as $field => $label)
                    <label class="block text-[0.72rem] font-bold text-navy-dark">{{ $label }}
                        <input name="daftar[{{ $i }}][{{ $field }}]" value="{{ $row[$field] ?? '' }}" {{ $field === 'nomor' ? '' : 'required' }} class="mt-1.5 w-full rounded border border-line bg-white px-3 py-2.5 text-[0.84rem] font-normal text-ink outline-none focus:border-blue focus:ring-2 focus:ring-blue/15" />
                    </label>
                    @endforeach
                </div>
            </section>
            @endforeach
        </div>
    </div>

    <div class="flex flex-wrap justify-end gap-2">
        <a href="{{ route('admin.hki.index') }}" class="rounded border border-line bg-white px-4 py-2.5 text-[0.8rem] font-bold text-muted hover:text-navy-dark">Batal</a>
        <button class="cursor-pointer rounded bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] px-5 py-2.5 text-[0.8rem] font-extrabold text-white shadow hover:-translate-y-px">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Arsip HKI' }}</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
(() => {
    const records = document.getElementById('records');
    const template = (index) => `<section class="record-row relative rounded border border-line bg-[#f9fafc] p-4">
        <div class="mb-3 flex items-center justify-between"><strong class="text-[0.78rem] text-navy-dark">Karya <span class="row-number"></span></strong><button type="button" class="remove-record text-[0.74rem] font-bold text-[#c0392b] hover:underline">Hapus baris</button></div>
        <div class="grid gap-3 md:grid-cols-2">${[['judul','Judul karya'],['jenis','Jenis HKI'],['pencipta','Nama pencipta'],['nomor','Nomor permohonan/pendaftaran']].map(([key,label]) => `<label class="block text-[0.72rem] font-bold text-navy-dark">${label}<input name="daftar[${index}][${key}]" ${key !== 'nomor' ? 'required' : ''} class="mt-1.5 w-full rounded border border-line bg-white px-3 py-2.5 text-[0.84rem] font-normal text-ink outline-none focus:border-blue focus:ring-2 focus:ring-blue/15" /></label>`).join('')}</div>
    </section>`;
    const renumber = () => [...records.querySelectorAll('.record-row')].forEach((row, i) => {
        row.querySelector('.row-number').textContent = i + 1;
        row.querySelectorAll('input').forEach(input => input.name = input.name.replace(/daftar\[\d+\]/, `daftar[${i}]`));
        row.querySelector('.remove-record').disabled = records.children.length === 1;
    });
    document.getElementById('add-record').addEventListener('click', () => {
        records.insertAdjacentHTML('beforeend', template(records.children.length)); renumber();
    });
    records.addEventListener('click', event => {
        if (event.target.closest('.remove-record') && records.children.length > 1) { event.target.closest('.record-row').remove(); renumber(); }
    });
    renumber();
})();
</script>
@endpush
