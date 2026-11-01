'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import AdminShell from '@/components/AdminShell';
import { adminFetch, getToken } from '@/lib/adminSession';

/**
 * VIEW (client) — ringkasan panel admin.
 *
 * Menampilkan angka penting (jumlah berita, draf, unggulan, berita di slider &
 * "You missed", total dibaca) serta berita terpopuler. Semua data dari
 * /api/admin/ringkasan.
 */
function Card({ label, value, hint, tone = 'blue' }) {
  const tones = {
    blue: 'text-[#1e6fd9]',
    green: 'text-[#17864a]',
    amber: 'text-[#b7791f]',
    navy: 'text-[#0b1d35]',
  };

  return (
    <div className="rounded-lg border border-[#dde3ec] bg-white p-5">
      <p className="text-[0.76rem] font-bold tracking-[0.04em] text-[#6b7787] uppercase">
        {label}
      </p>
      <p className={`mt-2 text-[1.9rem] leading-none font-black ${tones[tone]}`}>{value}</p>
      {hint && <p className="mt-1.5 text-[0.78rem] text-[#8894a6]">{hint}</p>}
    </div>
  );
}

export default function AdminDashboardPage() {
  const [data, setData] = useState(null);
  const [error, setError] = useState('');

  useEffect(() => {
    // Tanpa token, AdminShell yang mengurus pengalihan ke halaman login —
    // jangan memanggil API supaya tidak muncul galat 401 palsu.
    if (!getToken()) return;

    adminFetch('/admin/ringkasan').then((response) => {
      if (!response.ok) {
        setError(response.message);
        return;
      }

      setData(response.data.data);
    });
  }, []);

  return (
    <AdminShell>
      <h1 className="mb-1 text-[1.5rem] font-black tracking-[-0.02em] text-[#0b1d35]">
        Ringkasan
      </h1>
      <p className="mb-5 text-[0.88rem] text-[#5b6675]">
        Gambaran singkat isi website beserta apa saja yang bisa dikelola.
      </p>

      {error && (
        <div role="alert" className="mb-4 rounded border-l-4 border-red-500 bg-red-50 px-4 py-3 text-[0.9rem] text-red-700">
          {error}
        </div>
      )}

      {!data && !error && (
        <p className="text-[0.9rem] font-bold text-[#5b6675]">Memuat data…</p>
      )}

      {data && (
        <>
          <div className="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <Card
              label="Total Berita"
              value={data.berita.total}
              hint={`${data.berita.published} terbit · ${data.berita.draft} draf`}
            />
            <Card
              label="Unggulan (Featured)"
              value={data.berita.featured}
              hint={`${data.berita.slider} tampil di slider`}
              tone="amber"
            />
            <Card
              label='Kartu "You missed"'
              value={data.berita.missed}
              hint="Berita di blok bawah beranda"
              tone="green"
            />
            <Card
              label="Total Dibaca"
              value={Number(data.berita.total_views).toLocaleString('en-US')}
              hint="Jumlah seluruh pembacaan berita"
              tone="navy"
            />
          </div>

          <div className="grid gap-4 lg:grid-cols-2">
            {/* Per kategori */}
            <section className="rounded-lg border border-[#dde3ec] bg-white p-5">
              <h2 className="mb-3 text-[1rem] font-extrabold text-[#0b1d35]">Berita per Kategori</h2>

              {data.per_kategori.length === 0 ? (
                <p className="text-[0.88rem] text-[#6b7787]">Belum ada berita.</p>
              ) : (
                <ul className="space-y-2">
                  {data.per_kategori.map((row) => (
                    <li
                      key={row.category}
                      className="flex items-center justify-between border-b border-[#eef1f5] pb-2 text-[0.9rem] last:border-b-0"
                    >
                      <span className="font-bold text-[#33445c]">{row.category}</span>
                      <span className="text-[#6b7787]">
                        {row.total} berita <span className="text-[#b9c2cf]">·</span>{' '}
                        {row.published} terbit
                      </span>
                    </li>
                  ))}
                </ul>
              )}
            </section>

            {/* Terpopuler */}
            <section className="rounded-lg border border-[#dde3ec] bg-white p-5">
              <h2 className="mb-3 text-[1rem] font-extrabold text-[#0b1d35]">Berita Terpopuler</h2>

              {data.terpopuler.length === 0 ? (
                <p className="text-[0.88rem] text-[#6b7787]">Belum ada berita.</p>
              ) : (
                <ol className="space-y-2">
                  {data.terpopuler.map((post, index) => (
                    <li key={post.id} className="flex items-start gap-3 text-[0.9rem]">
                      <span className="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-[#eef4ff] text-[0.7rem] font-black text-[#1e6fd9]">
                        {index + 1}
                      </span>
                      <span className="min-w-0 flex-1">
                        <Link
                          href={`/berita/${post.slug}`}
                          target="_blank"
                          className="font-bold text-[#0b1d35] hover:text-[#1e6fd9]"
                        >
                          {post.title}
                        </Link>
                        <span className="ml-1 text-[0.78rem] text-[#8894a6]">
                          ({post.views} dibaca)
                        </span>
                      </span>
                    </li>
                  ))}
                </ol>
              )}
            </section>
          </div>

          <div className="mt-6 rounded-lg border border-[#cfe0f7] bg-[#f2f7ff] p-5">
            <h2 className="mb-2 text-[1rem] font-extrabold text-[#0b1d35]">
              Yang bisa Anda kelola
            </h2>
            <ul className="grid gap-2 text-[0.9rem] text-[#33445c] sm:grid-cols-2">
              <li>• Berita: tambah, ubah, hapus, terbit/draf</li>
              <li>• Berita: unggulan, slider, dan blok “You missed”</li>
              <li>• Beranda: ticker, judul seksi, jumlah berita</li>
              <li>• HKI: data per tahun (judul, jenis, pencipta, nomor)</li>
              <li>• Publikasi: luaran tiap tahun</li>
              <li>• Profil: judul, pengantar, jumlah pengunjung</li>
            </ul>
            <div className="mt-4 flex flex-wrap gap-2">
              <Link
                href="/admin/berita"
                className="rounded bg-[#1e6fd9] px-4 py-2 text-[0.8rem] font-extrabold text-white hover:bg-[#1558b0]"
              >
                Kelola Berita
              </Link>
              <Link
                href="/admin/hki"
                className="rounded border border-[#1e6fd9] px-4 py-2 text-[0.8rem] font-extrabold text-[#1e6fd9] hover:bg-[#e7f0ff]"
              >
                Kelola HKI
              </Link>
              <Link
                href="/admin/publikasi"
                className="rounded border border-[#1e6fd9] px-4 py-2 text-[0.8rem] font-extrabold text-[#1e6fd9] hover:bg-[#e7f0ff]"
              >
                Kelola Publikasi
              </Link>
              <Link
                href="/admin/profil"
                className="rounded border border-[#1e6fd9] px-4 py-2 text-[0.8rem] font-extrabold text-[#1e6fd9] hover:bg-[#e7f0ff]"
              >
                Profil &amp; Halaman
              </Link>
              <Link
                href="/admin/beranda"
                className="rounded border border-[#1e6fd9] px-4 py-2 text-[0.8rem] font-extrabold text-[#1e6fd9] hover:bg-[#e7f0ff]"
              >
                Konten Beranda
              </Link>
            </div>
          </div>
        </>
      )}
    </AdminShell>
  );
}
