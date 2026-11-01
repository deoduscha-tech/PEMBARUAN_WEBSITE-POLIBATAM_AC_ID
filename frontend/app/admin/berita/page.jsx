'use client';

import { useEffect, useMemo, useState } from 'react';
import AdminShell from '@/components/AdminShell';
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
  featured: false,
  published: true,
  show_in_slider: true,
  show_in_missed: true,
  sort_order: 0,
};

function Toggle({ label, hint, checked, onChange }) {
  return (
    <label className="flex cursor-pointer items-start gap-3 rounded border border-[#e2e8f0] px-3 py-2.5">
      <input
        type="checkbox"
        checked={Boolean(checked)}
        onChange={(event) => onChange(event.target.checked)}
        className="mt-0.5 size-4 accent-[#1e6fd9]"
      />
      <span className="min-w-0">
        <span className="block text-[0.86rem] font-bold text-[#0b1d35]">{label}</span>
        {hint && <span className="block text-[0.76rem] text-[#8894a6]">{hint}</span>}
      </span>
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
      <div className="mb-5 flex flex-wrap items-end justify-between gap-3">
        <div>
          <h1 className="text-[1.5rem] font-black tracking-[-0.02em] text-[#0b1d35]">
            Kelola Berita
          </h1>
          <p className="mt-1 text-[0.88rem] text-[#5b6675]">
            {posts.length} berita ·{' '}
            {posts.filter((post) => post.published).length} terbit ·{' '}
            {posts.filter((post) => !post.published).length} draf
          </p>
        </div>

        <button
          type="button"
          onClick={formOpen ? resetForm : openCreate}
          className="rounded bg-[#1e6fd9] px-4 py-2.5 text-[0.82rem] font-extrabold tracking-[0.02em] text-white uppercase hover:bg-[#1558b0]"
        >
          {formOpen ? 'Tutup Form' : '+ Tambah Berita'}
        </button>
      </div>

      {error && (
        <div role="alert" className="mb-4 rounded border-l-4 border-red-500 bg-red-50 px-4 py-3 text-[0.88rem] text-red-700">
          {error}
        </div>
      )}

      {notice && (
        <div role="status" className="mb-4 rounded border-l-4 border-green-600 bg-green-50 px-4 py-3 text-[0.88rem] text-green-800">
          {notice}
        </div>
      )}

      {/* Form tambah / ubah */}
      {formOpen && (
        <form
          onSubmit={handleSubmit}
          className="mb-6 rounded-lg border border-[#dde3ec] bg-white p-5"
        >
          <h2 className="mb-4 text-[1.05rem] font-extrabold text-[#0b1d35]">
            {form.id ? `Ubah Berita #${form.id}` : 'Berita Baru'}
          </h2>

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
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.94rem] outline-none focus:border-[#1e6fd9]"
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
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.94rem] outline-none focus:border-[#1e6fd9]"
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
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.94rem] outline-none focus:border-[#1e6fd9]"
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
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.94rem] outline-none focus:border-[#1e6fd9]"
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
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.94rem] outline-none focus:border-[#1e6fd9]"
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
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.94rem] outline-none focus:border-[#1e6fd9]"
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
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.94rem] outline-none focus:border-[#1e6fd9]"
              />
            </div>

            <div className="md:col-span-2">
              <label
                htmlFor="berita-isi"
                className="mb-1 block text-[0.78rem] font-bold text-[#33445c] uppercase"
              >
                Isi Berita (HTML diizinkan)
              </label>
              <textarea
                id="berita-isi"
                value={form.body}
                onChange={(event) => setForm({ ...form, body: event.target.value })}
                rows={10}
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 font-mono text-[0.86rem] outline-none focus:border-[#1e6fd9]"
              />
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
              className="rounded bg-[#1e6fd9] px-5 py-2.5 text-[0.82rem] font-extrabold text-white hover:bg-[#1558b0] disabled:opacity-60"
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
      <div className="mb-4 flex flex-wrap items-center gap-2">
        <input
          type="search"
          value={search}
          onChange={(event) => setSearch(event.target.value)}
          placeholder="Cari judul atau ringkasan…"
          className="min-w-[220px] flex-1 rounded border border-[#cfd8e3] px-3 py-2 text-[0.9rem] outline-none focus:border-[#1e6fd9]"
        />

        <select
          value={filterCategory}
          onChange={(event) => setFilterCategory(event.target.value)}
          className="rounded border border-[#cfd8e3] px-3 py-2 text-[0.86rem]"
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
          className="rounded border border-[#cfd8e3] px-3 py-2 text-[0.86rem]"
        >
          <option value="">Semua status</option>
          <option value="published">Terbit</option>
          <option value="draft">Draf</option>
          <option value="featured">Unggulan</option>
        </select>
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
        <div className="overflow-x-auto rounded-lg border border-[#dde3ec] bg-white">
          <table className="w-full border-collapse text-[0.86rem]">
            <thead>
              <tr className="bg-[#0f2238] text-left text-white">
                <th className="px-3 py-2.5">Judul</th>
                <th className="px-3 py-2.5">Kategori</th>
                <th className="px-3 py-2.5">Tanggal</th>
                <th className="px-3 py-2.5">Dibaca</th>
                <th className="px-3 py-2.5">Status</th>
                <th className="px-3 py-2.5">Beranda</th>
                <th className="px-3 py-2.5 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              {filtered.map((post, index) => (
                <tr
                  key={post.id}
                  className={index % 2 ? 'bg-[#f7f9fc]' : 'bg-white'}
                >
                  <td className="max-w-[420px] px-3 py-2.5">
                    <div className="font-bold text-[#0b1d35]">{post.title}</div>
                    <div className="truncate text-[0.76rem] text-[#8894a6]">/{post.slug}</div>
                  </td>
                  <td className="px-3 py-2.5 whitespace-nowrap">{post.category}</td>
                  <td className="px-3 py-2.5 whitespace-nowrap">{post.date}</td>
                  <td className="px-3 py-2.5">{post.views}</td>
                  <td className="px-3 py-2.5">
                    <button
                      type="button"
                      onClick={() => quickUpdate(post, { published: !post.published })}
                      className={`rounded-full px-2.5 py-1 text-[0.72rem] font-extrabold uppercase ${post.published
                          ? 'bg-green-100 text-green-800 hover:bg-green-200'
                          : 'bg-amber-100 text-amber-800 hover:bg-amber-200'
                        }`}
                      title="Klik untuk mengubah status"
                    >
                      {post.published ? 'Terbit' : 'Draf'}
                    </button>
                  </td>
                  <td className="px-3 py-2.5">
                    <div className="flex flex-wrap gap-1">
                      <button
                        type="button"
                        onClick={() => quickUpdate(post, { featured: !post.featured })}
                        className={`rounded px-2 py-1 text-[0.7rem] font-bold ${post.featured
                            ? 'bg-[#fdecc8] text-[#8a5a00]'
                            : 'bg-[#eef1f5] text-[#8894a6] hover:bg-[#e2e8f0]'
                          }`}
                        title="Unggulan"
                      >
                        ★
                      </button>
                      <button
                        type="button"
                        onClick={() => quickUpdate(post, { show_in_slider: !post.show_in_slider })}
                        className={`rounded px-2 py-1 text-[0.7rem] font-bold ${post.show_in_slider
                            ? 'bg-[#e3eeff] text-[#1558b0]'
                            : 'bg-[#eef1f5] text-[#8894a6] hover:bg-[#e2e8f0]'
                          }`}
                        title="Tampil di slider beranda"
                      >
                        Slider
                      </button>
                      <button
                        type="button"
                        onClick={() => quickUpdate(post, { show_in_missed: !post.show_in_missed })}
                        className={`rounded px-2 py-1 text-[0.7rem] font-bold ${post.show_in_missed
                            ? 'bg-[#e3f6e9] text-[#146c39]'
                            : 'bg-[#eef1f5] text-[#8894a6] hover:bg-[#e2e8f0]'
                          }`}
                        title="Tampil di blok You missed"
                      >
                        Missed
                      </button>
                    </div>
                  </td>
                  <td className="px-3 py-2.5 text-right whitespace-nowrap">
                    <button
                      type="button"
                      onClick={() => openEdit(post)}
                      className="rounded px-2.5 py-1 text-[0.78rem] font-bold text-[#1e6fd9] hover:bg-[#e7f0ff]"
                    >
                      Ubah
                    </button>
                    <button
                      type="button"
                      onClick={() => handleDelete(post)}
                      className="rounded px-2.5 py-1 text-[0.78rem] font-bold text-red-600 hover:bg-red-50"
                    >
                      Hapus
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </AdminShell>
  );
}
