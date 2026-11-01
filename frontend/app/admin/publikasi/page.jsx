'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import AdminShell from '@/components/AdminShell';
import { Alert, Button, Empty, Loading, PageHead } from '@/components/AdminUI';
import { adminFetch } from '@/lib/adminSession';

/**
 * VIEW (client) — kelola luaran publikasi per tahun.
 *
 * Isi publikasi disimpan sebagai HTML (daftar judul, penulis, jurnal, tautan).
 * Admin bisa menyunting langsung lewat kotak HTML, dan melihat berapa butir
 * (<li>) serta berapa huruf isinya.
 */
export default function AdminPublikasiPage() {
  const [years, setYears] = useState([]);
  const [loading, setLoading] = useState(true);
  const [status, setStatus] = useState({ type: '', message: '' });
  const [saving, setSaving] = useState(false);

  const [editYear, setEditYear] = useState(null);
  const [label, setLabel] = useState('');
  const [visitors, setVisitors] = useState('0');
  const [content, setContent] = useState('');
  const [pratinjau, setPratinjau] = useState(false);

  async function load() {
    setLoading(true);
    const response = await adminFetch('/admin/publikasi');

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      setLoading(false);
      return;
    }

    setYears(response.data.data);
    setLoading(false);
  }

  useEffect(() => {
    load();
  }, []);

  async function openYear(year) {
    const response = await adminFetch(`/admin/publikasi/${year}`);

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      return;
    }

    setEditYear(year);
    setLabel(response.data.data.label ?? `TAHUN ${year}`);
    setVisitors(String(response.data.data.visitors ?? 0));
    setContent(response.data.data.content ?? '');
    setPratinjau(false);
    setStatus({ type: '', message: '' });
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function startNewYear() {
    const next =
      years.length > 0 ? Math.max(...years.map((item) => item.year)) + 1 : new Date().getFullYear();

    setEditYear(next);
    setLabel(`TAHUN ${next}`);
    setVisitors('0');
    setContent('<p><strong>A. Publikasi Jurnal Internasional Bereputasi</strong></p>\n<ol>\n  <li>Nama Penulis – <a href="#">Judul artikel</a>. Terbit pada Nama Jurnal. (Q1)</li>\n</ol>');
    setPratinjau(false);
    setStatus({ type: '', message: '' });
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  async function save() {
    setSaving(true);
    setStatus({ type: '', message: '' });

    const response = await adminFetch(`/admin/publikasi/${editYear}`, {
      method: 'POST',
      body: { label, visitors: Number(visitors) || 0, content },
    });

    setSaving(false);

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      return;
    }

    setStatus({ type: 'success', message: `Publikasi tahun ${editYear} disimpan.` });
    setEditYear(null);
    await load();
  }

  const jumlahButir = (content.match(/<li/gi) ?? []).length;

  return (
    <AdminShell>
      <PageHead
        title="Kelola Publikasi"
        description="Luaran publikasi penelitian & pengabdian per tahun. Isi yang disimpan di sini tampil di halaman /publikasi dan /tahun-20xx."
      >
        <Button onClick={startNewYear}>+ Tahun Berikutnya</Button>
      </PageHead>

      <Alert type={status.type === 'success' ? 'success' : 'error'} message={status.message} />

      {editYear !== null && (
        <section className="mb-6 rounded-lg border border-[#dde3ec] bg-white p-5">
          <h2 className="mb-4 text-[1.05rem] font-extrabold text-[#0b1d35]">
            Publikasi Tahun {editYear}
          </h2>

          <div className="mb-4 grid gap-4 md:grid-cols-2">
            <div>
              <label htmlFor="pub-label" className="mb-1 block text-[0.76rem] font-bold text-[#33445c] uppercase">
                Judul halaman
              </label>
              <input
                id="pub-label"
                type="text"
                value={label}
                onChange={(event) => setLabel(event.target.value)}
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.92rem]"
              />
            </div>

            <div>
              <label htmlFor="pub-visitors" className="mb-1 block text-[0.76rem] font-bold text-[#33445c] uppercase">
                Jumlah pengunjung
              </label>
              <input
                id="pub-visitors"
                type="number"
                min="0"
                value={visitors}
                onChange={(event) => setVisitors(event.target.value)}
                className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.92rem]"
              />
            </div>
          </div>

          <div className="mb-2 flex flex-wrap items-center justify-between gap-2">
            <label htmlFor="pub-content" className="text-[0.76rem] font-bold text-[#33445c] uppercase">
              Isi publikasi (HTML)
            </label>
            <div className="flex items-center gap-3 text-[0.78rem] text-[#6b7787]">
              <span>{jumlahButir} butir</span>
              <button
                type="button"
                onClick={() => setPratinjau((value) => !value)}
                className="font-bold text-[#1e6fd9] hover:underline"
              >
                {pratinjau ? 'Sembunyikan pratinjau' : 'Lihat pratinjau'}
              </button>
            </div>
          </div>

          <textarea
            id="pub-content"
            value={content}
            onChange={(event) => setContent(event.target.value)}
            rows={14}
            className="w-full rounded border border-[#cfd8e3] px-3 py-2 font-mono text-[0.8rem] leading-relaxed"
          />

          {pratinjau && (
            <div className="mt-3 max-h-[420px] overflow-y-auto rounded border border-[#e2e8f0] bg-[#fbfcfe] p-4 text-[0.88rem]">
              <div className="publication-original-content" dangerouslySetInnerHTML={{ __html: content }} />
            </div>
          )}

          <div className="mt-4 flex flex-wrap gap-2 border-t border-[#eef1f5] pt-4">
            <Button onClick={save} disabled={saving}>
              {saving ? 'Menyimpan…' : 'Simpan'}
            </Button>
            <Button variant="ghost" onClick={() => setEditYear(null)}>
              Batal
            </Button>
          </div>
        </section>
      )}

      {loading ? (
        <Loading text="Memuat data publikasi…" />
      ) : years.length === 0 ? (
        <Empty title="Belum ada data publikasi" />
      ) : (
        <div className="overflow-x-auto rounded-lg border border-[#dde3ec] bg-white">
          <table className="w-full border-collapse text-[0.86rem]">
            <thead>
              <tr className="bg-[#0f2238] text-left text-white">
                <th className="px-3 py-2.5">Tahun</th>
                <th className="px-3 py-2.5">Jumlah Butir</th>
                <th className="px-3 py-2.5">Pengunjung</th>
                <th className="px-3 py-2.5">Halaman Publik</th>
                <th className="px-3 py-2.5 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              {years.map((item, index) => (
                <tr key={item.year} className={index % 2 ? 'bg-[#f7f9fc]' : 'bg-white'}>
                  <td className="px-3 py-2.5 font-bold text-[#0b1d35]">{item.label}</td>
                  <td className="px-3 py-2.5">
                    {item.items} butir
                    {item.items === 0 && (
                      <span className="ml-1 rounded bg-amber-100 px-1.5 py-0.5 text-[0.7rem] font-bold text-amber-800">
                        kosong
                      </span>
                    )}
                  </td>
                  <td className="px-3 py-2.5">{Number(item.visitors).toLocaleString('en-US')}</td>
                  <td className="px-3 py-2.5">
                    <Link
                      href={`/tahun-${item.year}`}
                      target="_blank"
                      className="font-bold text-[#1e6fd9] hover:underline"
                    >
                      Lihat ↗
                    </Link>
                  </td>
                  <td className="px-3 py-2.5 text-right">
                    <button
                      type="button"
                      onClick={() => openYear(item.year)}
                      className="rounded px-2.5 py-1 text-[0.78rem] font-bold text-[#1e6fd9] hover:bg-[#e7f0ff]"
                    >
                      Ubah
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
