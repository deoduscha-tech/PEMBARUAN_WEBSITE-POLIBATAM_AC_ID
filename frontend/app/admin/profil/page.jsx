'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import AdminShell from '@/components/AdminShell';
import { Alert, Button, Empty, Loading, PageHead } from '@/components/AdminUI';
import { adminFetch } from '@/lib/adminSession';

/**
 * VIEW (client) — kelola halaman profil & unit.
 *
 * Setiap halaman punya judul, jumlah pengunjung, dan paragraf pengantar yang
 * bisa disunting. Perubahan disimpan sebagai penimpa (override) di
 * site_contents, jadi isi asli dari berkas data tetap utuh dan publik langsung
 * menampilkan versi terbaru.
 */

const JALUR = {
  profil: '/profil',
  informasi: '/informasi',
  'renstra-penelitian': '/profil/renstra-penelitian',
  'rip-pengabdian': '/profil/rip-pengabdian',
};

export default function AdminProfilPage() {
  const [pages, setPages] = useState([]);
  const [loading, setLoading] = useState(true);
  const [status, setStatus] = useState({ type: '', message: '' });
  const [saving, setSaving] = useState(false);

  const [slug, setSlug] = useState(null);
  const [heading, setHeading] = useState('');
  const [visitors, setVisitors] = useState('0');
  const [intro, setIntro] = useState([]);

  async function load() {
    setLoading(true);
    const response = await adminFetch('/admin/profil');

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      setLoading(false);
      return;
    }

    setPages(response.data.data);
    setLoading(false);
  }

  useEffect(() => {
    load();
  }, []);

  async function open(slugToEdit) {
    const response = await adminFetch(`/admin/profil/${slugToEdit}`);

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      return;
    }

    const data = response.data.data;

    setSlug(slugToEdit);
    setHeading(data.heading ?? '');
    setVisitors(String(data.visitors ?? 0));
    setIntro((data.intro ?? []).map((text) => ({ text })));
    setStatus({ type: '', message: '' });
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function updateIntro(index, text) {
    setIntro((current) => current.map((row, i) => (i === index ? { text } : row)));
  }

  async function save() {
    setSaving(true);
    setStatus({ type: '', message: '' });

    const response = await adminFetch(`/admin/profil/${slug}`, {
      method: 'POST',
      body: {
        heading,
        visitors: Number(visitors) || 0,
        intro: intro.map((row) => row.text).filter((text) => text.trim() !== ''),
      },
    });

    setSaving(false);

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      return;
    }

    setStatus({ type: 'success', message: `Halaman ${slug} disimpan.` });
    setSlug(null);
    await load();
  }

  return (
    <AdminShell>
      <PageHead
        title="Kelola Profil & Halaman"
        description="Judul, jumlah pengunjung, dan paragraf pengantar tiap halaman. Daftar skema dan tautan dokumen tetap mengikuti berkas data backend."
      />

      <Alert type={status.type === 'success' ? 'success' : 'error'} message={status.message} />

      {slug !== null && (
        <section className="mb-6 rounded-lg border border-[#dde3ec] bg-white p-5">
          <h2 className="mb-4 text-[1.05rem] font-extrabold text-[#0b1d35]">
            Halaman: {slug}
          </h2>

          <div className="mb-4 grid gap-4 md:grid-cols-2">
            <div>
              <label htmlFor="profil-judul" className="mb-1 block text-[0.76rem] font-bold text-[#33445c] uppercase">
                Judul halaman
              </label>
              <input
                id="profil-judul"
                type="text"
                value={heading}
                onChange={(event) => setHeading(event.target.value)}
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.92rem]"
              />
            </div>

            <div>
              <label htmlFor="profil-pengunjung" className="mb-1 block text-[0.76rem] font-bold text-[#33445c] uppercase">
                Jumlah pengunjung
              </label>
              <input
                id="profil-pengunjung"
                type="number"
                min="0"
                value={visitors}
                onChange={(event) => setVisitors(event.target.value)}
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.92rem]"
              />
            </div>
          </div>

          <div className="mb-2 flex items-center justify-between">
            <span className="text-[0.76rem] font-bold text-[#33445c] uppercase">
              Paragraf pengantar
            </span>
            <button
              type="button"
              onClick={() => setIntro((current) => [...current, { text: '' }])}
              className="text-[0.8rem] font-bold text-[#1e6fd9] hover:underline"
            >
              + Tambah paragraf
            </button>
          </div>

          <div className="flex flex-col gap-2">
            {intro.length === 0 && (
              <p className="rounded border border-dashed border-[#cfd8e3] px-3 py-4 text-[0.86rem] text-[#8894a6]">
                Belum ada paragraf. Klik &quot;Tambah paragraf&quot;.
              </p>
            )}

            {intro.map((row, index) => (
              <div key={index} className="flex items-start gap-2">
                <span className="mt-2 w-5 shrink-0 text-center text-[0.78rem] font-bold text-[#8894a6]">
                  {index + 1}
                </span>
                <textarea
                  value={row.text}
                  onChange={(event) => updateIntro(index, event.target.value)}
                  rows={4}
                  className="min-w-0 flex-1 rounded border border-[#cfd8e3] px-3 py-2 text-[0.9rem] leading-relaxed"
                />
                <button
                  type="button"
                  onClick={() => setIntro((current) => current.filter((_, i) => i !== index))}
                  className="mt-1 shrink-0 rounded px-2 py-1 text-[0.78rem] font-bold text-red-600 hover:bg-red-50"
                >
                  Hapus
                </button>
              </div>
            ))}
          </div>

          <div className="mt-4 flex flex-wrap gap-2 border-t border-[#eef1f5] pt-4">
            <Button onClick={save} disabled={saving}>
              {saving ? 'Menyimpan…' : 'Simpan'}
            </Button>
            <Button variant="ghost" onClick={() => setSlug(null)}>
              Batal
            </Button>
          </div>
        </section>
      )}

      {loading ? (
        <Loading text="Memuat halaman…" />
      ) : pages.length === 0 ? (
        <Empty title="Belum ada halaman" />
      ) : (
        <div className="overflow-x-auto rounded-lg border border-[#dde3ec] bg-white">
          <table className="w-full border-collapse text-[0.86rem]">
            <thead>
              <tr className="bg-[#0f2238] text-left text-white">
                <th className="px-3 py-2.5">Halaman</th>
                <th className="px-3 py-2.5">Judul</th>
                <th className="px-3 py-2.5">Paragraf</th>
                <th className="px-3 py-2.5">Pengunjung</th>
                <th className="px-3 py-2.5">Status</th>
                <th className="px-3 py-2.5 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              {pages.map((page, index) => {
                const jalur = JALUR[page.slug] ?? `/${page.slug}`;

                return (
                  <tr key={page.slug} className={index % 2 ? 'bg-[#f7f9fc]' : 'bg-white'}>
                    <td className="px-3 py-2.5 font-bold text-[#0b1d35]">{page.slug}</td>
                    <td className="px-3 py-2.5">{page.heading}</td>
                    <td className="px-3 py-2.5">{page.intro.length} paragraf</td>
                    <td className="px-3 py-2.5">
                      {Number(page.visitors).toLocaleString('en-US')}
                    </td>
                    <td className="px-3 py-2.5">
                      {page.edited ? (
                        <span className="rounded bg-[#e3f6e9] px-2 py-0.5 text-[0.72rem] font-bold text-[#146c39]">
                          disunting
                        </span>
                      ) : (
                        <span className="text-[0.78rem] text-[#8894a6]">asli</span>
                      )}
                    </td>
                    <td className="px-3 py-2.5 text-right whitespace-nowrap">
                      <Link
                        href={jalur}
                        target="_blank"
                        className="mr-2 rounded px-2.5 py-1 text-[0.78rem] font-bold text-[#6b7787] hover:bg-[#f3f6fa]"
                      >
                        Lihat ↗
                      </Link>
                      <button
                        type="button"
                        onClick={() => open(page.slug)}
                        className="rounded px-2.5 py-1 text-[0.78rem] font-bold text-[#1e6fd9] hover:bg-[#e7f0ff]"
                      >
                        Ubah
                      </button>
                    </td>
                  </tr>
                );
              })}
            </tbody>
          </table>
        </div>
      )}
    </AdminShell>
  );
}
