@extends('admin.layout')

@php
$isEdit = $post !== null;
$action = $isEdit ? route('admin.berita.update', $post['id']) : route('admin.berita.store');
$oldValue = fn (string $key, $fallback = '') => old($key, $post[$key] ?? $fallback);
@endphp

@section('title', $isEdit ? 'Edit Berita' : 'Tulis Berita')
@section('heading', $isEdit ? 'Edit Berita' : 'Tulis Berita Baru')
@section('subheading', $isEdit ? 'Perbarui isi dan status terbit' : 'Susun berita atau pengumuman baru')

@section('content')

<form id="news-form" method="POST" action="{{ $action }}" class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_340px]">
    @csrf
    @if ($isEdit)
    @method('PUT')
    @endif

    {{-- =====================================================
             Left column: content
        ===================================================== --}}
    <div class="space-y-5">

        <div class="rounded-lg border border-line bg-white p-5">
            <h2 class="mb-4 text-[0.9rem] font-extrabold tracking-[-0.01em] text-navy-dark">Konten Berita</h2>

            {{-- Title --}}
            <div class="mb-4">
                <label for="title" class="mb-1.5 block text-[0.72rem] font-bold tracking-[0.05em] text-navy-dark uppercase">
                    Judul Berita <span class="text-[#d14343]">*</span>
                </label>
                <input id="title" name="title" type="text" value="{{ $oldValue('title') }}" required
                    placeholder="Contoh: Pengumuman Hasil Seleksi Penelitian TA 2026"
                    class="w-full rounded border bg-white px-3.5 py-2.5 text-[0.92rem] text-ink outline-none transition-colors placeholder:text-[#a9b4c2] focus:border-blue focus:ring-2 focus:ring-blue/15 @error('title') border-[#e05252] @else border-line @enderror" />
                @error('title')
                <p class="mt-1.5 text-[0.76rem] font-semibold text-[#d14343]">{{ $message }}</p>
                @enderror
            </div>

            {{-- Excerpt --}}
            <div>
                <label for="excerpt" class="mb-1.5 block text-[0.72rem] font-bold tracking-[0.05em] text-navy-dark uppercase">
                    Ringkasan
                </label>
                <textarea id="excerpt" name="excerpt" rows="3"
                    placeholder="Ringkasan singkat yang tampil pada kartu berita di halaman utama."
                    class="w-full resize-y rounded border border-line bg-white px-3.5 py-2.5 text-[0.9rem] leading-relaxed text-ink outline-none transition-colors placeholder:text-[#a9b4c2] focus:border-blue focus:ring-2 focus:ring-blue/15">{{ $oldValue('excerpt') }}</textarea>
                <p class="mt-1.5 text-[0.74rem] text-muted">Kosongkan untuk mengambil otomatis dari isi berita.</p>
            </div>
        </div>

        {{-- Body --}}
        <div class="rounded-lg border border-line bg-white p-5">
            <div class="mb-4 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-[0.9rem] font-extrabold tracking-[-0.01em] text-navy-dark">
                        Isi Berita <span class="text-[#d14343]">*</span>
                    </h2>
                    <p class="mt-0.5 text-[0.76rem] text-muted">Mendukung HTML dasar: &lt;p&gt;, &lt;h3&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;strong&gt;.</p>
                </div>

                <button type="button" id="toggle-preview"
                    class="shrink-0 cursor-pointer rounded border border-line bg-[#f7f9fc] px-3 py-1.5 text-[0.74rem] font-bold text-navy-dark transition-colors hover:border-blue hover:text-blue">
                    Pratinjau
                </button>
            </div>

            <textarea id="body" name="body" rows="16" required
                placeholder="<p>Tulis isi berita di sini...</p>"
                class="w-full resize-y rounded border bg-white px-3.5 py-2.5 font-mono text-[0.86rem] leading-relaxed text-ink outline-none transition-colors placeholder:text-[#a9b4c2] focus:border-blue focus:ring-2 focus:ring-blue/15 @error('body') border-[#e05252] @else border-line @enderror">{{ $oldValue('body') }}</textarea>
            @error('body')
            <p class="mt-1.5 text-[0.76rem] font-semibold text-[#d14343]">{{ $message }}</p>
            @enderror

            {{-- Rendered preview, hidden until asked for --}}
            <div id="preview-pane" class="rich-copy mt-4 hidden rounded border border-line bg-[#f7f9fc] p-4" hidden></div>
        </div>
    </div>

    {{-- =====================================================
             Right column: meta + publish
        ===================================================== --}}
    <div class="space-y-5">

        {{-- Publish box --}}
        <div class="rounded-lg border border-line bg-white p-5">
            <h2 class="mb-4 text-[0.9rem] font-extrabold tracking-[-0.01em] text-navy-dark">Terbitkan</h2>

            <div class="space-y-3">
                <label class="flex cursor-pointer items-start gap-3 rounded border border-line bg-[#f7f9fc] p-3 transition-colors hover:border-blue/40">
                    <input type="checkbox" name="published" value="1" @checked($oldValue('published', true))
                        class="mt-0.5 size-4 cursor-pointer accent-[#1c73d9]" />
                    <span>
                        <span class="block text-[0.84rem] font-bold text-navy-dark">Terbitkan sekarang</span>
                        <span class="mt-0.5 block text-[0.74rem] leading-snug text-muted">Jika tidak dicentang, berita disimpan sebagai draf.</span>
                    </span>
                </label>

                <label class="flex cursor-pointer items-start gap-3 rounded border border-line bg-[#f7f9fc] p-3 transition-colors hover:border-blue/40">
                    <input type="checkbox" name="featured" value="1" @checked($oldValue('featured', false))
                        class="mt-0.5 size-4 cursor-pointer accent-[#1c73d9]" />
                    <span>
                        <span class="block text-[0.84rem] font-bold text-navy-dark">Jadikan sorotan</span>
                        <span class="mt-0.5 block text-[0.74rem] leading-snug text-muted">Tampil pada slider halaman utama.</span>
                    </span>
                </label>
            </div>

            <div class="mt-5 flex flex-col gap-2 border-t border-line pt-4">
                <button type="submit" form="news-form"
                        class="flex w-full cursor-pointer items-center justify-center gap-2 rounded bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] px-5 py-2.5 text-[0.82rem] font-extrabold tracking-[0.03em] text-white uppercase shadow-[0_8px_18px_rgba(29,122,230,0.28)] transition-transform hover:-translate-y-px">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"></path>
                        <path d="M17 21v-8H7v8"></path>
                        <path d="M7 3v5h8"></path>
                    </svg>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Berita' }}
                </button>

                <a href="{{ route('admin.berita.index') }}"
                    class="block w-full rounded border border-line px-5 py-2.5 text-center text-[0.82rem] font-bold text-muted transition-colors hover:border-navy-dark hover:text-navy-dark">
                    Batal
                </a>
            </div>
        </div>

        {{-- Meta --}}
        <div class="rounded-lg border border-line bg-white p-5">
            <h2 class="mb-4 text-[0.9rem] font-extrabold tracking-[-0.01em] text-navy-dark">Detail</h2>

            {{-- Category --}}
            <div class="mb-4">
                <label for="category" class="mb-1.5 block text-[0.72rem] font-bold tracking-[0.05em] text-navy-dark uppercase">
                    Kategori <span class="text-[#d14343]">*</span>
                </label>
                <input id="category" name="category" type="text" list="category-options" value="{{ $oldValue('category', 'Informasi') }}" required
                    class="w-full rounded border border-line bg-white px-3.5 py-2.5 text-[0.88rem] text-ink outline-none transition-colors focus:border-blue focus:ring-2 focus:ring-blue/15" />
                <datalist id="category-options">
                    @foreach ($categories as $category)
                    <option value="{{ $category }}"></option>
                    @endforeach
                </datalist>
            </div>

            {{-- Date --}}
            <div class="mb-4">
                <label for="date" class="mb-1.5 block text-[0.72rem] font-bold tracking-[0.05em] text-navy-dark uppercase">
                    Tanggal Terbit <span class="text-[#d14343]">*</span>
                </label>
                <input id="date" name="date" type="date" value="{{ $oldValue('date', now()->toDateString()) }}" required
                    class="w-full rounded border border-line bg-white px-3.5 py-2.5 text-[0.88rem] text-ink outline-none transition-colors focus:border-blue focus:ring-2 focus:ring-blue/15" />
            </div>

            {{-- Author --}}
            <div class="mb-4">
                <label for="author" class="mb-1.5 block text-[0.72rem] font-bold tracking-[0.05em] text-navy-dark uppercase">
                    Penulis
                </label>
                <input id="author" name="author" type="text" value="{{ $oldValue('author', 'P3M') }}"
                    class="w-full rounded border border-line bg-white px-3.5 py-2.5 text-[0.88rem] text-ink outline-none transition-colors focus:border-blue focus:ring-2 focus:ring-blue/15" />
            </div>

            {{-- Image --}}
            <div>
                <label for="image" class="mb-1.5 block text-[0.72rem] font-bold tracking-[0.05em] text-navy-dark uppercase">
                    Gambar Utama
                </label>
                <input id="image" name="image" type="text" value="{{ $oldValue('image') }}"
                    placeholder="/images/contoh.jpg"
                    class="w-full rounded border border-line bg-white px-3.5 py-2.5 font-mono text-[0.8rem] text-ink outline-none transition-colors placeholder:text-[#a9b4c2] focus:border-blue focus:ring-2 focus:ring-blue/15" />
                <p class="mt-1.5 text-[0.74rem] leading-snug text-muted">
                    Isi dengan path gambar di folder <code class="font-mono">public/images</code>.
                </p>

                @if ($oldValue('image'))
                <div class="mt-3">
                    <span class="mb-1.5 block text-[0.7rem] font-bold tracking-[0.05em] text-muted uppercase">Pratinjau gambar</span>
                    <img id="image-preview" src="{{ $oldValue('image') }}" alt="Pratinjau gambar berita"
                        class="max-h-40 w-full rounded border border-line object-cover" />
                </div>
                @else
                <img id="image-preview" src="" alt="" class="mt-3 hidden max-h-40 w-full rounded border border-line object-cover" />
                @endif
            </div>
        </div>

        @if ($isEdit)
        <div class="rounded-lg border border-line bg-white p-5">
            <h2 class="mb-2 text-[0.9rem] font-extrabold tracking-[-0.01em] text-navy-dark">Statistik</h2>
            <dl class="grid grid-cols-2 gap-y-2 text-[0.82rem]">
                <dt class="text-muted">Dibaca</dt>
                <dd class="text-right font-bold text-navy-dark">{{ number_format($post['views']) }} kali</dd>
                <dt class="text-muted">Slug</dt>
                <dd class="truncate text-right font-mono text-[0.74rem] text-navy-dark" title="{{ $post['slug'] }}">{{ $post['slug'] }}</dd>
            </dl>
        </div>
        @endif
    </div>
</form>

@endsection

@push('scripts')
<script>
    // Live image preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');

    imageInput?.addEventListener('input', () => {
        const value = imageInput.value.trim();
        imagePreview.src = value;
        imagePreview.classList.toggle('hidden', value === '');
    });

    // Toggle the rendered HTML preview of the body field
    const body = document.getElementById('body');
    const pane = document.getElementById('preview-pane');
    const toggle = document.getElementById('toggle-preview');

    toggle?.addEventListener('click', () => {
        const showing = !pane.hidden;

        if (showing) {
            pane.hidden = true;
            pane.classList.add('hidden');
            toggle.textContent = 'Pratinjau';
        } else {
            pane.innerHTML = body.value;
            pane.hidden = false;
            pane.classList.remove('hidden');
            toggle.textContent = 'Sembunyikan';
        }
    });
</script>
@endpush