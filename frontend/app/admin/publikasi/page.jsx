'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import AdminShell from '@/components/AdminShell';
import BlokEditor, { blokBaru } from '@/components/BlokEditor';
import { BlokView } from '@/components/BlokView';
import { Alert } from '@/components/AdminUI';
import Icon from '@/components/AdminIcons';
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
  const [blocks, setBlocks] = useState([]);
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
    setBlocks(response.data.data.blocks ?? []);
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
    setContent('');
    // Contoh awal berupa blok siap isi, bukan HTML — admin tinggal mengubah teksnya.
    setBlocks([
      blokBaru('heading'),
      blokBaru('paragraf'),
      blokBaru('daftar'),
    ]);
    setPratinjau(false);
    setStatus({ type: '', message: '' });
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  async function save() {
    setSaving(true);
    setStatus({ type: '', message: '' });

    const response = await adminFetch(`/admin/publikasi/${editYear}`, {
      method: 'POST',
      body: { label, visitors: Number(visitors) || 0, content, blocks },
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

  const jumlahButir = blocks
    .filter((blok) => blok.tipe === 'daftar')
    .reduce((total, blok) => total + (blok.items?.length ?? 0), 0);

  return (
    <AdminShell>
      {/* Judul halaman */}
      <div className="mb-6 flex flex-wrap items-end justify-between gap-3">
        <div>
          <nav aria-label="Breadcrumb" className="mb-1.5 flex items-center gap-1.5 text-[0.72rem] font-bold text-[#9aa7b8]">
            <span>Admin</span>
            <span aria-hidden="true">/</span>
            <span className="text-[#33445c]">Kelola Publikasi</span>
          </nav>
          <h1 className="text-[1.65rem] leading-tight font-black tracking-[-0.03em] text-[#0b1d35]">
            Kelola Publikasi
          </h1>
          <p className="mt-1 max-w-[70ch] text-[0.86rem] text-[#7b8798]">
            Luaran publikasi penelitian dan pengabdian per tahun. Isi di sini langsung tampil di
            halaman Publikasi tahun tersebut.
          </p>
        </div>

        <button
          type="button"
          onClick={startNewYear}
          className="inline-flex items-center gap-2 rounded-xl bg-[#1266d2] px-4 py-2.5 text-[0.82rem] font-extrabold text-white shadow-[0_6px_18px_-4px_rgba(18,102,210,0.55)] hover:bg-[#0f56b3]"
        >
          <Icon name="plus" className="size-4" strokeWidth={2.4} /> Tahun Berikutnya
        </button>
      </div>

      <Alert type={status.type === 'success' ? 'success' : 'error'} message={status.message} />

      {editYear !== null && (
        <section className="mb-6 rounded-2xl border border-[#bcd7f8] bg-white p-6 shadow-[0_10px_30px_-18px_rgba(18,102,210,0.35)]">
          <div className="mb-5 flex items-center gap-3 border-b border-[#f0f3f8] pb-4">
            <span className="grid size-10 place-items-center rounded-xl bg-[#efeafd] text-[#6d47d9]">
              <Icon name="publikasi" className="size-5" />
            </span>
            <div>
              <h2 className="text-[1.05rem] leading-tight font-extrabold text-[#0b1d35]">
                Publikasi Tahun {editYear}
              </h2>
              <p className="text-[0.78rem] text-[#8894a6]">
                {blocks.length} blok isi · {jumlahButir} butir daftar
              </p>
            </div>
          </div>

          <div className="mb-5 grid gap-4 md:grid-cols-2">
            <div>
              <label htmlFor="pub-label" className="mb-1 block text-[0.72rem] font-bold text-[#33445c] uppercase">
                Judul halaman
              </label>
              <input
                id="pub-label"
                type="text"
                value={label}
                onChange={(event) => setLabel(event.target.value)}
                className="h-10 w-full rounded-lg border border-[#dbe3ee] px-3 text-[0.9rem] outline-none focus:border-[#1266d2]"
              />
              <p className="mt-1 text-[0.74rem] text-[#8894a6]">Tampil sebagai judul halaman publikasi.</p>
            </div>

            <div>
              <label htmlFor="pub-visitors" className="mb-1 block text-[0.72rem] font-bold text-[#33445c] uppercase">
                Jumlah pengunjung
              </label>
              <input
                id="pub-visitors"
                type="number"
                min="0"
                value={visitors}
                onChange={(event) => setVisitors(event.target.value)}
                className="h-10 w-full rounded-lg border border-[#dbe3ee] px-3 text-[0.9rem] outline-none focus:border-[#1266d2]"
              />
              <p className="mt-1 text-[0.74rem] text-[#8894a6]">Angka yang muncul di bagian bawah halaman.</p>
            </div>
          </div>

          <div className="mb-2 flex flex-wrap items-center justify-between gap-2">
            <span className="text-[0.76rem] font-bold text-[#33445c] uppercase">
              Isi publikasi
            </span>
            <div className="flex items-center gap-3 text-[0.78rem] text-[#6b7787]">
              <span>{blocks.length} blok</span>
              <button
                type="button"
                onClick={() => setPratinjau((value) => !value)}
                className="font-bold text-[#1266d2] hover:underline"
              >
                {pratinjau ? 'Sembunyikan pratinjau' : 'Lihat pratinjau'}
              </button>
            </div>
          </div>

          <p className="mb-2 text-[0.76rem] text-[#8894a6]">
            Tambah dan susun isi per blok: sub judul, paragraf, daftar butir, tautan, tabel, atau
            gambar. Tidak perlu menulis HTML.
          </p>

          <BlokEditor blocks={blocks} onChange={setBlocks} />

          {pratinjau && (
            <div className="mt-3 max-h-[420px] overflow-y-auto rounded border border-[#e2e8f0] bg-[#fbfcfe] p-4 text-[0.88rem]">
              <div className="rich-copy">
                <BlokView blocks={blocks} />
              </div>
            </div>
          )}

          <div className="mt-5 flex flex-wrap items-center gap-2 border-t border-[#f0f3f8] pt-4">
            <button
              type="button"
              onClick={save}
              disabled={saving}
              className="inline-flex items-center gap-2 rounded-xl bg-[#1266d2] px-4 py-2.5 text-[0.82rem] font-extrabold text-white shadow-[0_6px_18px_-4px_rgba(18,102,210,0.55)] hover:bg-[#0f56b3] disabled:opacity-60"
            >
              <Icon name="check" className="size-4" strokeWidth={2.4} />
              {saving ? 'Menyimpan…' : 'Simpan Publikasi'}
            </button>
            <button
              type="button"
              onClick={() => setEditYear(null)}
              className="ml-auto rounded-xl px-4 py-2.5 text-[0.82rem] font-bold text-[#5b6675] hover:bg-[#f3f6fa]"
            >
              Batal
            </button>
          </div>
        </section>
      )}

      {/* Daftar tahun */}
      <section className="rounded-xl border border-[#e8edf4] bg-white">
        <div className="flex flex-wrap items-center justify-between gap-3 border-b border-[#f0f3f8] px-5 py-4">
          <div>
            <h2 className="text-[0.98rem] font-extrabold text-[#0b1d35]">Daftar Tahun</h2>
            <p className="text-[0.78rem] text-[#8894a6]">
              Klik “Ubah” untuk menyunting isi publikasi tahun tersebut.
            </p>
          </div>
          <span className="rounded-full bg-[#f1f5fa] px-3 py-1 text-[0.76rem] font-bold text-[#546479]">
            {years.length} tahun
          </span>
        </div>

        {loading ? (
          <p className="px-5 py-8 text-center text-[0.88rem] font-bold text-[#8894a6]">
            Memuat data publikasi…
          </p>
        ) : years.length === 0 ? (
          <p className="px-5 py-10 text-center text-[0.88rem] text-[#8894a6]">
            Belum ada data publikasi. Klik “Tahun Berikutnya” untuk memulai.
          </p>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full border-collapse text-[0.86rem]">
              <thead>
                <tr className="border-b border-[#eef2f7] bg-[#f8fafc] text-left text-[0.72rem] font-extrabold tracking-[0.05em] text-[#7b8798] uppercase">
                  <th className="px-5 py-3">Tahun</th>
                  <th className="px-3 py-3">Jumlah butir</th>
                  <th className="px-3 py-3 text-right">Pengunjung</th>
                  <th className="px-3 py-3">Halaman publik</th>
                  <th className="px-5 py-3 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody>
                {years.map((item) => (
                  <tr
                    key={item.year}
                    className={`border-b border-[#f4f6fa] transition-colors last:border-b-0 hover:bg-[#fafcff] ${
                      editYear === item.year ? 'bg-[#f5f9ff]' : ''
                    }`}
                  >
                    <td className="px-5 py-3.5">
                      <span className="text-[0.92rem] font-extrabold text-[#0b1d35]">
                        {item.label}
                      </span>
                    </td>
                    <td className="px-3 py-3.5">
                      {item.items > 0 ? (
                        <span className="rounded-md bg-[#efeafd] px-2 py-0.5 text-[0.78rem] font-bold text-[#6d47d9]">
                          {item.items} butir
                        </span>
                      ) : (
                        <span className="rounded-md bg-[#fef4e3] px-2 py-0.5 text-[0.78rem] font-bold text-[#b7791f]">
                          Belum diisi
                        </span>
                      )}
                    </td>
                    <td className="px-3 py-3.5 text-right font-bold text-[#546479]">
                      {Number(item.visitors).toLocaleString('en-US')}
                    </td>
                    <td className="px-3 py-3.5">
                      <Link
                        href={`/tahun-${item.year}`}
                        target="_blank"
                        className="inline-flex items-center gap-1 text-[0.8rem] font-bold text-[#1266d2] hover:underline"
                      >
                        Lihat <Icon name="external" className="size-3" />
                      </Link>
                    </td>
                    <td className="px-5 py-3.5 text-right whitespace-nowrap">
                      <button
                        type="button"
                        onClick={() => openYear(item.year)}
                        className="inline-flex items-center gap-1.5 rounded-lg border border-[#e2e8f0] px-3 py-1.5 text-[0.78rem] font-bold text-[#33445c] transition-colors hover:border-[#bcd7f8] hover:bg-[#f2f8ff] hover:text-[#1266d2]"
                      >
                        <Icon name="edit" className="size-3.5" /> Ubah
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </section>
    </AdminShell>
  );
}
