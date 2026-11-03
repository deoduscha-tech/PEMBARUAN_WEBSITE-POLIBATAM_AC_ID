'use client';

import { useEffect, useMemo, useState } from 'react';
import AdminShell from '@/components/AdminShell';
import BlokEditor from '@/components/BlokEditor';
import Icon from '@/components/AdminIcons';
import { adminFetch } from '@/lib/adminSession';

/**
 * VIEW (client) — kelola berita.
 *
 * Satu halaman untuk: melihat daftar, mencari/menyaring, menambah, mengubah,
 * menghapus, menerbitkan/draft, menandai unggulan, serta mengatur berita yang
 * tampil di slider beranda dan blok "You missed".
 *
 * Data dari /api/admin/berita; aksi tulis lewat /api/berita (butuh token).
 */

const KATEGORI_UMUM = ['Informasi', 'Kegiatan', 'Prestasi', 'Pengumuman'];

const FORM_KOSONG = {
  id: null,
  title: '',
  category: 'Informasi',
  author: 'P3M',
  date: new Date().toISOString().slice(0, 10),
  image: '',
  excerpt: '',
  body: '',
  bodyBlocks: [],
  featured: false,
  published: true,
  show_in_slider: true,
  show_in_missed: true,
  sort_order: 0,
};

function Toggle({ label, hint, checked, onChange, icon = 'check' }) {
  return (
    <label
      className={`flex cursor-pointer items-start gap-3 rounded-xl border p-3 transition-colors ${
        checked ? 'border-[#bcd7f8] bg-[#f4f9ff]' : 'border-[#e8edf4] bg-white hover:bg-[#fafcfe]'
      }`}
    >
      <span
        className={`mt-0.5 grid size-8 shrink-0 place-items-center rounded-lg ${
          checked ? 'bg-[#e3eeff] text-[#1266d2]' : 'bg-[#f1f4f8] text-[#9aa7b8]'
        }`}
      >
        <Icon name={icon} className="size-4" />
      </span>
      <span className="min-w-0 flex-1">
        <span className="block text-[0.86rem] font-bold text-[#0b1d35]">{label}</span>
        {hint && <span className="block text-[0.75rem] leading-snug text-[#8894a6]">{hint}</span>}
      </span>
      <span
        className={`mt-1 h-5 w-9 shrink-0 rounded-full p-0.5 transition-colors ${
          checked ? 'bg-[#1266d2]' : 'bg-[#d5dde8]'
        }`}
        aria-hidden="true"
      >
        <span
          className={`block size-4 rounded-full bg-white shadow transition-transform ${
            checked ? 'translate-x-4' : 'translate-x-0'
          }`}
        />
      </span>
          <input
        type="checkbox"
        checked={Boolean(checked)}
        onChange={(event) => onChange(event.target.checked)}
        className="sr-only"
      />
    </label>
  );
}

export default function AdminBeritaPage() {
  const [posts, setPosts] = useState([]);
  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState('');
  const [notice, setNotice] = useState('');
  const [search, setSearch] = useState('');
  const [filterCategory, setFilterCategory] = useState('');
  const [filterStatus, setFilterStatus] = useState('');
  const [form, setForm] = useState(FORM_KOSONG);
  const [formOpen, setFormOpen] = useState(false);

  async function load() {
    setLoading(true);
    const response = await adminFetch('/admin/berita');

    if (!response.ok) {
      setError(response.message);
      setLoading(false);
      return;
    }

    setPosts(response.data.data);
    setCategories(response.data.meta.categories ?? []);
    setLoading(false);
  }

  useEffect(() => {
    load();
  }, []);

  const filtered = useMemo(() => {
    const term = search.trim().toLowerCase();

    return posts.filter((post) => {
      if (filterCategory && post.category !== filterCategory) return false;
      if (filterStatus === 'published' && !post.published) return false;
      if (filterStatus === 'draft' && post.published) return false;
      if (filterStatus === 'featured' && !post.featured) return false;
      if (!term) return true;

      return (
        post.title.toLowerCase().includes(term) ||
        post.excerpt.toLowerCase().includes(term) ||
        post.slug.toLowerCase().includes(term)
      );
    });
  }, [posts, search, filterCategory, filterStatus]);

  function openCreate() {
    setForm({ ...FORM_KOSONG, sort_order: posts.length });
    setFormOpen(true);
    setError('');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function openEdit(post) {
    setForm({
      id: post.id,
      title: post.title,
      category: post.category,
      author: post.author,
      date: post.date || FORM_KOSONG.date,
      image: post.image ?? '',
      excerpt: post.excerpt ?? '',
      body: post.body ?? '',
      bodyBlocks: Array.isArray(post.body_blocks) ? post.body_blocks : [],
      featured: post.featured,
      published: post.published,
      show_in_slider: post.show_in_slider,
      show_in_missed: post.show_in_missed,
      sort_order: post.sort_order ?? 0,
    });
    setFormOpen(true);
    setError('');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function resetForm() {
    setForm(FORM_KOSONG);
    setFormOpen(false);
    setError('');
  }

  async function handleSubmit(event) {
    event.preventDefault();
    setSaving(true);
    setError('');

    const payload = {
      title: form.title,
      category: form.category,
      author: form.author,
      date: form.date,
      image: form.image,
      excerpt: form.excerpt,
      body: form.body,
      body_blocks: form.bodyBlocks,
      featured: form.featured,
      published: form.published,
      show_in_slider: form.show_in_slider,
      show_in_missed: form.show_in_missed,
      sort_order: Number(form.sort_order) || 0,
    };

    const response = form.id
      ? await adminFetch(`/berita/${form.id}`, { method: 'PUT', body: payload })
      : await adminFetch('/berita', { method: 'POST', body: payload });

    setSaving(false);

    if (!response.ok) {
      const details = response.errors
        ? Object.values(response.errors).flat().join(' ')
        : '';
      setError(`${response.message} ${details}`.trim());
      return;
    }

    setNotice(form.id ? 'Berita diperbarui.' : 'Berita ditambahkan.');
    resetForm();
    await load();
    setTimeout(() => setNotice(''), 3000);
  }

  async function handleDelete(post) {
    const yakin = window.confirm(`Hapus berita "${post.title}"? Tindakan ini tidak bisa dibatalkan.`);
    if (!yakin) return;

    const response = await adminFetch(`/berita/${post.id}`, { method: 'DELETE' });

    if (!response.ok) {
      setError(response.message);
      return;
    }

    setNotice('Berita dihapus.');
    await load();
    setTimeout(() => setNotice(''), 3000);
  }

  /** Ubah cepat satu property tanpa membuka form penuh. */
  async function quickUpdate(post, changes) {
    const payload = {
      title: post.title,
      category: post.category,
      author: post.author,
      date: post.date,
      image: post.image,
      excerpt: post.excerpt,
      body: post.body,
      body_blocks: post.body_blocks ?? [],
      featured: post.featured,
      published: post.published,
      show_in_slider: post.show_in_slider,
      show_in_missed: post.show_in_missed,
      sort_order: post.sort_order,
      ...changes,
    };

    const response = await adminFetch(`/berita/${post.id}`, { method: 'PUT', body: payload });

    if (!response.ok) {
      setError(response.message);
      return;
    }

    setPosts((current) =>
      current.map((item) => (item.id === post.id ? { ...item, ...changes } : item)),
    );
  }

  return (
    <AdminShell>
      <div className="mb-6 flex flex-wrap items-end justify-between gap-3">
        <div>
          <nav aria-label="Breadcrumb" className="mb-1.5 flex items-center gap-1.5 text-[0.72rem] font-bold text-[#9aa7b8]">
            <span>Admin</span>
            <span aria-hidden="true">/</span>
            <span className="text-[#33445c]">Kelola Berita</span>
          </nav>
          <h1 className="text-[1.65rem] leading-tight font-black tracking-[-0.03em] text-[#0b1d35]">
            Kelola Berita
          </h1>
          <p className="mt-1 text-[0.86rem] text-[#7b8798]">
            {posts.length} berita · {posts.filter((post) => post.published).length} terbit ·{' '}
            {posts.filter((post) => !post.published).length} draf
          </p>
        </div>

        <button
          type="button"
          onClick={formOpen ? resetForm : openCreate}
          className={`inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-[0.82rem] font-extrabold transition-colors ${
            formOpen
              ? 'border border-[#dbe3ee] bg-white text-[#33445c] hover:bg-[#f5f8fc]'
              : 'bg-[#1266d2] text-white shadow-[0_6px_18px_-4px_rgba(18,102,210,0.55)] hover:bg-[#0f56b3]'
          }`}
        >
          <Icon name={formOpen ? 'x' : 'plus'} className="size-4" strokeWidth={2.4} />
          {formOpen ? 'Tutup Form' : 'Tambah Berita'}
        </button>
      </div>

      {error && (
        <div role="alert" className="mb-4 flex items-start gap-2 rounded-xl border-l-4 border-red-500 bg-red-50 px-4 py-3 text-[0.88rem] text-red-700">
          <Icon name="x" className="mt-0.5 size-4 shrink-0" />
          <span>{error}</span>
        </div>
      )}

      {notice && (
        <div role="status" className="mb-4 flex items-start gap-2 rounded-xl border-l-4 border-green-600 bg-green-50 px-4 py-3 text-[0.88rem] text-green-800">
          <Icon name="check" className="mt-0.5 size-4 shrink-0" />
          <span>{notice}</span>
        </div>
      )}

      {/* Form tambah / ubah */}
      {formOpen && (
        <form
          onSubmit={handleSubmit}
          className="mb-6 rounded-2xl border border-[#e8edf4] bg-white p-6 shadow-[0_10px_30px_-18px_rgba(11,33,56,0.25)]"
        >
          <div className="mb-5 flex items-center gap-3 border-b border-[#f0f3f8] pb-4">
            <span className="grid size-9 place-items-center rounded-xl bg-[#e8f1ff] text-[#1266d2]">
              <Icon name={form.id ? 'edit' : 'plus'} className="size-[18px]" />
            </span>
            <div>
              <h2 className="text-[1.02rem] leading-tight font-extrabold text-[#0b1d35]">
                {form.id ? `Ubah Berita #${form.id}` : 'Berita Baru'}
              </h2>
              <p className="text-[0.78rem] text-[#8894a6]">
                Isi informasi berita, lalu simpan. Tanda * wajib diisi.
              </p>
            </div>
          </div>

          <div className="grid gap-4 md:grid-cols-2">
            <div className="md:col-span-2">
              <label
                htmlFor="berita-judul"
                className="mb-1 block text-[0.78rem] font-bold text-[#33445c] uppercase"
              >
                Judul *
              </label>
              <input
                id="berita-judul"
                type="text"
                value={form.title}
                onChange={(event) => setForm({ ...form, title: event.target.value })}
                required
                className="h-10 w-full rounded-lg border border-[#dbe3ee] px-3 text-[0.92rem] text-[#12203a] outline-none transition-colors focus:border-[#1266d2] focus:ring-3 focus:ring-[#1266d2]/10"
              />
            </div>

            <div>
              <label
                htmlFor="berita-kategori"
                className="mb-1 block text-[0.78rem] font-bold text-[#33445c] uppercase"
              >
                Kategori *
              </label>
              <input
                id="berita-kategori"
                type="text"
                list="kategori-list"
                value={form.category}
                onChange={(event) => setForm({ ...form, category: event.target.value })}
                required
                className="h-10 w-full rounded-lg border border-[#dbe3ee] px-3 text-[0.92rem] text-[#12203a] outline-none transition-colors focus:border-[#1266d2] focus:ring-3 focus:ring-[#1266d2]/10"
              />
              <datalist id="kategori-list">
                {[...KATEGORI_UMUM, ...categories].map((item) => (
                  <option key={item} value={item} />
                ))}
              </datalist>
            </div>

            <div>
              <label
                htmlFor="berita-penulis"
                className="mb-1 block text-[0.78rem] font-bold text-[#33445c] uppercase"
              >
                Penulis
              </label>
              <input
                id="berita-penulis"
                type="text"
                value={form.author}
                onChange={(event) => setForm({ ...form, author: event.target.value })}
                className="h-10 w-full rounded-lg border border-[#dbe3ee] px-3 text-[0.92rem] text-[#12203a] outline-none transition-colors focus:border-[#1266d2] focus:ring-3 focus:ring-[#1266d2]/10"
              />
            </div>

            <div>
              <label
                htmlFor="berita-tanggal"
                className="mb-1 block text-[0.78rem] font-bold text-[#33445c] uppercase"
              >
                Tanggal
              </label>
              <input
                id="berita-tanggal"
                type="date"
                value={form.date}
                onChange={(event) => setForm({ ...form, date: event.target.value })}
                className="h-10 w-full rounded-lg border border-[#dbe3ee] px-3 text-[0.92rem] text-[#12203a] outline-none transition-colors focus:border-[#1266d2] focus:ring-3 focus:ring-[#1266d2]/10"
              />
            </div>

            <div>
              <label
                htmlFor="berita-urutan"
                className="mb-1 block text-[0.78rem] font-bold text-[#33445c] uppercase"
              >
                Urutan Tampil
              </label>
              <input
                id="berita-urutan"
                type="number"
                value={form.sort_order}
                onChange={(event) => setForm({ ...form, sort_order: event.target.value })}
                className="h-10 w-full rounded-lg border border-[#dbe3ee] px-3 text-[0.92rem] text-[#12203a] outline-none transition-colors focus:border-[#1266d2] focus:ring-3 focus:ring-[#1266d2]/10"
              />
              <p className="mt-1 text-[0.74rem] text-[#8894a6]">
                Angka kecil tampil lebih dulu.
              </p>
            </div>

            <div className="md:col-span-2">
              <label
                htmlFor="berita-gambar"
                className="mb-1 block text-[0.78rem] font-bold text-[#33445c] uppercase"
              >
                Gambar (URL)
              </label>
              <input
                id="berita-gambar"
                type="url"
                value={form.image}
                onChange={(event) => setForm({ ...form, image: event.target.value })}
                placeholder="https://…/foto.jpg"
                className="h-10 w-full rounded-lg border border-[#dbe3ee] px-3 text-[0.92rem] text-[#12203a] outline-none transition-colors focus:border-[#1266d2] focus:ring-3 focus:ring-[#1266d2]/10"
              />
              {form.image && (
                <div
                  className="mt-2 h-32 w-full max-w-sm rounded border border-[#e2e8f0] bg-cover bg-center"
                  style={{ backgroundImage: `url('${form.image}')` }}
                  aria-label="Pratinjau gambar"
                />
              )}
            </div>

            <div className="md:col-span-2">
              <label
                htmlFor="berita-ringkasan"
                className="mb-1 block text-[0.78rem] font-bold text-[#33445c] uppercase"
              >
                Ringkasan
              </label>
              <textarea
                id="berita-ringkasan"
                value={form.excerpt}
                onChange={(event) => setForm({ ...form, excerpt: event.target.value })}
                rows={3}
                placeholder="Dikosongkan = otomatis diambil dari isi berita."
                className="h-10 w-full rounded-lg border border-[#dbe3ee] px-3 text-[0.92rem] text-[#12203a] outline-none transition-colors focus:border-[#1266d2] focus:ring-3 focus:ring-[#1266d2]/10"
              />
            </div>

            <div className="md:col-span-2">
              <label className="mb-1 block text-[0.78rem] font-bold text-[#33445c] uppercase">
                Isi Berita
              </label>
              <p className="mb-2 text-[0.76rem] text-[#8894a6]">
                Susun isi dari blok — paragraf, sub judul, daftar, tautan, tabel, atau gambar.
                Tidak perlu menulis kode.
              </p>
              <BlokEditor blocks={form.bodyBlocks} onChange={(blocks) => setForm({ ...form, bodyBlocks: blocks })} />
            </div>

            <div className="grid gap-2 md:col-span-2 md:grid-cols-2">
              <Toggle
                label="Terbitkan"
                hint="Mati = disimpan sebagai draf, tidak tampil di website."
                checked={form.published}
                onChange={(value) => setForm({ ...form, published: value })}
              />
              <Toggle
                label="Unggulan"
                hint="Ditandai sebagai berita unggulan."
                checked={form.featured}
                onChange={(value) => setForm({ ...form, featured: value })}
              />
              <Toggle
                label="Tampil di slider beranda"
                hint="Muncul besar di bagian atas beranda."
                checked={form.show_in_slider}
                onChange={(value) => setForm({ ...form, show_in_slider: value })}
              />
              <Toggle
                label='Tampil di blok "You missed"'
                hint="Muncul di deretan kartu bawah beranda."
                checked={form.show_in_missed}
                onChange={(value) => setForm({ ...form, show_in_missed: value })}
              />
            </div>
          </div>

          <div className="mt-5 flex flex-wrap gap-2 border-t border-[#eef1f5] pt-4">
            <button
              type="submit"
              disabled={saving}
              className="rounded bg-[#1266d2] px-5 py-2.5 text-[0.82rem] font-extrabold text-white hover:bg-[#0f56b3] disabled:opacity-60"
            >
              {saving ? 'Menyimpan…' : form.id ? 'Simpan Perubahan' : 'Simpan Berita'}
            </button>
            <button
              type="button"
              onClick={resetForm}
              className="rounded border border-[#cfd8e3] px-5 py-2.5 text-[0.82rem] font-extrabold text-[#3b4757] hover:bg-[#f3f6fa]"
            >
              Batal
            </button>
          </div>
        </form>
      )}

      {/* Filter */}
      <div className="mb-4 flex flex-wrap items-center gap-2 rounded-xl border border-[#e8edf4] bg-white p-2.5">
        <div className="relative min-w-[220px] flex-1">
          <Icon name="search" className="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-[#9aa7b8]" />
          <input
            type="search"
            value={search}
            onChange={(event) => setSearch(event.target.value)}
            placeholder="Cari judul atau ringkasan…"
            className="h-9 w-full rounded-lg border border-transparent bg-[#f6f9fc] pr-3 pl-9 text-[0.88rem] outline-none transition-colors placeholder:text-[#a6b2c2] focus:border-[#bcd7f8] focus:bg-white"
          />
        </div>

        <select
          value={filterCategory}
          onChange={(event) => setFilterCategory(event.target.value)}
          className="h-9 rounded-lg border border-[#e2e8f0] bg-white px-3 text-[0.84rem] text-[#33445c] outline-none focus:border-[#1266d2]"
        >
          <option value="">Semua kategori</option>
          {categories.map((item) => (
            <option key={item} value={item}>
              {item}
            </option>
          ))}
        </select>

        <select
          value={filterStatus}
          onChange={(event) => setFilterStatus(event.target.value)}
          className="h-9 rounded-lg border border-[#e2e8f0] bg-white px-3 text-[0.84rem] text-[#33445c] outline-none focus:border-[#1266d2]"
        >
          <option value="">Semua status</option>
          <option value="published">Terbit</option>
          <option value="draft">Draf</option>
          <option value="featured">Unggulan</option>
        </select>

        <span className="ml-auto pr-2 text-[0.78rem] font-bold text-[#8894a6]">
          {filtered.length} dari {posts.length}
        </span>
      </div>

      {/* Daftar */}
      {loading ? (
        <p className="text-[0.9rem] font-bold text-[#5b6675]">Memuat berita…</p>
      ) : filtered.length === 0 ? (
        <div className="rounded-lg border border-dashed border-[#cfd8e3] bg-white p-8 text-center">
          <p className="font-bold text-[#33445c]">Tidak ada berita yang cocok</p>
          <p className="mt-1 text-[0.86rem] text-[#8894a6]">
            Ubah filter, atau tambah berita baru.
          </p>
        </div>
      ) : (
        <div className="overflow-hidden rounded-xl border border-[#e8edf4] bg-white">
          <div className="overflow-x-auto">
            <table className="w-full border-collapse text-[0.86rem]">
              <thead>
                <tr className="border-b border-[#eef2f7] bg-[#f8fafc] text-left text-[0.72rem] font-extrabold tracking-[0.05em] text-[#7b8798] uppercase">
                  <th className="px-4 py-3">Berita</th>
                  <th className="px-3 py-3">Kategori</th>
                  <th className="px-3 py-3">Tanggal</th>
                  <th className="px-3 py-3 text-center">Dibaca</th>
                  <th className="px-3 py-3">Status</th>
                  <th className="px-3 py-3">Beranda</th>
                  <th className="px-4 py-3 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody>
                {filtered.map((post) => (
                  <tr
                    key={post.id}
                    className="border-b border-[#f4f6fa] transition-colors last:border-b-0 hover:bg-[#fafcff]"
                  >
                    <td className="px-4 py-3">
                      <div className="flex items-center gap-3">
                        <div
                          className="size-11 shrink-0 rounded-lg border border-[#e8edf4] bg-[#f3f6fa] bg-cover bg-center"
                          style={post.image ? { backgroundImage: `url('${post.image}')` } : undefined}
                          aria-hidden="true"
                        />
                        <div className="min-w-0">
                          <div className="line-clamp-1 max-w-[240px] font-bold text-[#0b1d35]">
                            {post.title}
                          </div>
                          <div className="max-w-[240px] truncate text-[0.74rem] text-[#9aa7b8]">/{post.slug}</div>
                        </div>
                      </div>
                    </td>
                    <td className="px-3 py-3 whitespace-nowrap">
                      <span className="rounded-md bg-[#f1f5fa] px-2 py-0.5 text-[0.75rem] font-bold text-[#546479]">
                        {post.category}
                      </span>
                    </td>
                    <td className="px-3 py-3 whitespace-nowrap text-[0.82rem] text-[#7b8798]">
                      {post.date}
                    </td>
                    <td className="px-3 py-3 text-center text-[0.82rem] font-bold text-[#546479]">
                      {post.views}
                    </td>
                    <td className="px-3 py-3">
                      <button
                        type="button"
                        onClick={() => quickUpdate(post, { published: !post.published })}
                        title="Klik untuk mengubah status"
                        className={`inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[0.72rem] font-extrabold transition-colors ${
                          post.published
                            ? 'bg-[#e6f7ee] text-[#0e8a4f] hover:bg-[#d4f0e2]'
                            : 'bg-[#fef4e3] text-[#b7791f] hover:bg-[#fbe7c6]'
                        }`}
                      >
                        <span
                          className={`size-1.5 rounded-full ${
                            post.published ? 'bg-[#0e8a4f]' : 'bg-[#b7791f]'
                          }`}
                        />
                        {post.published ? 'Terbit' : 'Draf'}
                      </button>
                    </td>
                    <td className="px-3 py-3">
                      <div className="flex gap-1">
                        {[
                          { key: 'featured', label: 'Unggulan', on: post.featured, cls: 'bg-[#fdf0cf] text-[#8a5a00]' },
                          { key: 'show_in_slider', label: 'Slider', on: post.show_in_slider, cls: 'bg-[#e3eeff] text-[#1266d2]' },
                          { key: 'show_in_missed', label: 'Missed', on: post.show_in_missed, cls: 'bg-[#e6f7ee] text-[#0e8a4f]' },
                        ].map((flag) => (
                          <button
                            key={flag.key}
                            type="button"
                            onClick={() => quickUpdate(post, { [flag.key]: !flag.on })}
                            aria-pressed={flag.on}
                            className={`rounded-md px-2 py-1 text-[0.7rem] font-bold transition-colors ${
                              flag.on ? flag.cls : 'bg-[#f1f4f8] text-[#b3bdca] hover:bg-[#e6ebf2]'
                            }`}
                          >
                            {flag.label}
                          </button>
                        ))}
                      </div>
                    </td>
                    <td className="px-4 py-3 text-right whitespace-nowrap">
                      <div className="inline-flex gap-1">
                        <button
                          type="button"
                          onClick={() => openEdit(post)}
                          aria-label={`Ubah ${post.title}`}
                          className="grid size-8 place-items-center rounded-lg border border-[#e2e8f0] text-[#5b6675] transition-colors hover:border-[#bcd7f8] hover:bg-[#f2f8ff] hover:text-[#1266d2]"
                        >
                          <Icon name="edit" className="size-4" />
                        </button>
                        <button
                          type="button"
                          onClick={() => handleDelete(post)}
                          aria-label={`Hapus ${post.title}`}
                          className="grid size-8 place-items-center rounded-lg border border-[#e2e8f0] text-[#5b6675] transition-colors hover:border-[#f6c6c1] hover:bg-[#fef3f2] hover:text-[#d92d20]"
                        >
                          <Icon name="trash" className="size-4" />
                        </button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}
    </AdminShell>
  );
}
