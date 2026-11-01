'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import AdminShell from '@/components/AdminShell';
import { adminFetch } from '@/lib/adminSession';

/**
 * VIEW (client) — pengaturan konten beranda.
 *
 * Mengubah teks & jumlah tata letak beranda tanpa menyentuh kode:
 * label ticker, jumlah berita ticker & daftar, judul serta jumlah kartu
 * "You missed", dan judul slider.
 *
 * Disimpan ke /api/admin/pengaturan (tabel settings).
 */

const URUTAN = [
  {
    key: 'ticker_label',
    label: 'Label ticker',
    hint: 'Teks pada label di baris berita berjalan (contoh: Latest Post).',
    type: 'text',
    place: 'Beranda · baris berjalan di bawah menu',
  },
  {
    key: 'ticker_count',
    label: 'Jumlah berita di ticker',
    hint: 'Berapa berita yang berjalan di ticker.',
    type: 'number',
    place: 'Beranda · ticker',
  },
  {
    key: 'home_posts_count',
    label: 'Jumlah berita di daftar beranda',
    hint: 'Berapa berita yang tampil di daftar utama beranda.',
    type: 'number',
    place: 'Beranda · daftar berita',
  },
  {
    key: 'slider_title',
    label: 'Judul slider',
    hint: 'Judul bagian slider berita unggulan.',
    type: 'text',
    place: 'Beranda · slider atas',
  },
  {
    key: 'missed_title',
    label: 'Judul blok "You missed"',
    hint: 'Judul deretan kartu di bagian bawah beranda.',
    type: 'text',
    place: 'Beranda · blok bawah',
  },
  {
    key: 'missed_count',
    label: 'Jumlah kartu "You missed"',
    hint: 'Berapa kartu berita yang tampil di blok tersebut.',
    type: 'number',
    place: 'Beranda · blok bawah',
  },
];

export default function AdminBerandaPage() {
  const [values, setValues] = useState(null);
  const [status, setStatus] = useState({ type: '', message: '' });
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    adminFetch('/admin/pengaturan').then((response) => {
      if (!response.ok) {
        setStatus({ type: 'error', message: response.message });
        return;
      }

      setValues(response.data.data);
    });
  }, []);

  async function handleSubmit(event) {
    event.preventDefault();
    setSaving(true);
    setStatus({ type: '', message: '' });

    const response = await adminFetch('/admin/pengaturan', {
      method: 'PUT',
      body: values,
    });

    setSaving(false);

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      return;
    }

    setValues(response.data.data);
    setStatus({ type: 'ok', message: 'Pengaturan beranda disimpan. Buka beranda untuk melihat hasilnya.' });
  }

  return (
    <AdminShell>
      <div className="mb-5">
        <h1 className="text-[1.5rem] font-black tracking-[-0.02em] text-[#0b1d35]">
          Konten Beranda
        </h1>
        <p className="mt-1 text-[0.88rem] text-[#5b6675]">
          Atur teks dan jumlah berita yang tampil di halaman depan. Untuk memilih berita mana
          yang masuk slider atau blok &quot;You missed&quot;, gunakan{' '}
          <Link href="/admin/berita" className="font-bold text-[#1e6fd9] hover:underline">
            Kelola Berita
          </Link>
          .
        </p>
      </div>

      {status.message && (
        <div
          role={status.type === 'error' ? 'alert' : 'status'}
          className={`mb-4 rounded border-l-4 px-4 py-3 text-[0.88rem] ${status.type === 'error'
              ? 'border-red-500 bg-red-50 text-red-700'
              : 'border-green-600 bg-green-50 text-green-800'
            }`}
        >
          {status.message}
        </div>
      )}

      {!values ? (
        <p className="text-[0.9rem] font-bold text-[#5b6675]">Memuat pengaturan…</p>
      ) : (
        <form
          onSubmit={handleSubmit}
          className="rounded-lg border border-[#dde3ec] bg-white p-5"
        >
          <div className="grid gap-5 md:grid-cols-2">
            {URUTAN.map((field) => (
              <div key={field.key}>
                <label
                  htmlFor={field.key}
                  className="mb-1 block text-[0.78rem] font-bold tracking-[0.02em] text-[#33445c] uppercase"
                >
                  {field.label}
                </label>
                <input
                  id={field.key}
                  type={field.type}
                  min={field.type === 'number' ? 1 : undefined}
                  value={values[field.key] ?? ''}
                  onChange={(event) =>
                    setValues({ ...values, [field.key]: event.target.value })
                  }
                  className="w-full rounded border border-[#cfd8e3] px-3 py-2 text-[0.94rem] outline-none focus:border-[#1e6fd9]"
                />
                <p className="mt-1 text-[0.76rem] text-[#8894a6]">{field.hint}</p>
                <p className="text-[0.74rem] text-[#a8b2c1]">{field.place}</p>
              </div>
            ))}
          </div>

          <div className="mt-6 flex flex-wrap items-center gap-2 border-t border-[#eef1f5] pt-4">
            <button
              type="submit"
              disabled={saving}
              className="rounded bg-[#1e6fd9] px-5 py-2.5 text-[0.82rem] font-extrabold text-white hover:bg-[#1558b0] disabled:opacity-60"
            >
              {saving ? 'Menyimpan…' : 'Simpan Pengaturan'}
            </button>
            <Link
              href="/"
              target="_blank"
              className="rounded border border-[#cfd8e3] px-5 py-2.5 text-[0.82rem] font-extrabold text-[#3b4757] hover:bg-[#f3f6fa]"
            >
              Lihat Beranda ↗
            </Link>
          </div>
        </form>
      )}
    </AdminShell>
  );
}
