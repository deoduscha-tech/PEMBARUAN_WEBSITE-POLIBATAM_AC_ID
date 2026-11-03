'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import AdminShell from '@/components/AdminShell';
import { adminFetch, getToken, getAdminName } from '@/lib/adminSession';
import Icon from '@/components/AdminIcons';

/**
 * VIEW (client) — ringkasan panel admin.
 *
 * Menampilkan angka penting (jumlah berita, draf, unggulan, berita di slider &
 * "You missed", total dibaca) serta berita terpopuler. Semua data dari
 * /api/admin/ringkasan.
 */
/* Palet warna untuk ikon & aksen tiap kartu statistik. */
const TONES = {
  blue: { box: 'bg-[#e8f1ff]', text: 'text-[#1266d2]', ring: '#3d97f5' },
  green: { box: 'bg-[#e6f7ee]', text: 'text-[#0e8a4f]', ring: '#2fbf71' },
  amber: { box: 'bg-[#fef4e3]', text: 'text-[#b7791f]', ring: '#f0a93a' },
  violet: { box: 'bg-[#efeafd]', text: 'text-[#6d47d9]', ring: '#8b6ce8' },
};

function StatCard({ label, value, hint, icon, tone = 'blue' }) {
  const t = TONES[tone] ?? TONES.blue;

  return (
    <div className="group relative overflow-hidden rounded-xl border border-[#e8edf4] bg-white p-5 transition-shadow hover:shadow-[0_10px_28px_rgba(11,33,56,0.08)]">
      <div className="flex items-start justify-between gap-3">
        <div className="min-w-0">
          <p className="text-[0.74rem] font-bold tracking-[0.05em] text-[#8894a6] uppercase">
            {label}
          </p>
          <p className="mt-2.5 text-[2rem] leading-none font-black tracking-[-0.03em] text-[#0b1d35]">
            {value}
          </p>
        </div>
        <span className={`grid size-11 shrink-0 place-items-center rounded-lg ${t.box} ${t.text}`}>
          <Icon name={icon} className="size-5" />
        </span>
      </div>
      {hint && (
        <p className="mt-3 border-t border-[#f0f3f8] pt-2.5 text-[0.76rem] text-[#8894a6]">
          {hint}
        </p>
      )}
    </div>
  );
}

/** Grafik donut sederhana dari komposisi kategori (tanpa library). */
function Donut({ rows }) {
  const total = rows.reduce((sum, row) => sum + row.total, 0) || 1;
  const palette = ['#3d97f5', '#2fbf71', '#f0a93a', '#8b6ce8', '#f06595', '#38bdf8'];

  let offset = 0;
  const segments = rows.slice(0, 6).map((row, index) => {
    const percent = (row.total / total) * 100;
    const segment = {
      color: palette[index % palette.length],
      dash: `${percent} ${100 - percent}`,
      offset: -offset,
      row,
      percent,
    };
    offset += percent;
    return segment;
  });

  return (
    <div className="flex flex-wrap items-center gap-6">
      <div className="relative size-[150px] shrink-0">
        <svg viewBox="0 0 42 42" className="size-full -rotate-90">
          <circle cx="21" cy="21" r="15.9" fill="none" stroke="#eef2f7" strokeWidth="6" />
          {segments.map((segment) => (
            <circle
              key={segment.row.category}
              cx="21"
              cy="21"
              r="15.9"
              fill="none"
              stroke={segment.color}
              strokeWidth="6"
              strokeDasharray={segment.dash}
              strokeDashoffset={segment.offset}
              pathLength="100"
            />
          ))}
        </svg>
        <div className="absolute inset-0 grid place-items-center text-center">
          <div>
            <p className="text-[1.35rem] leading-none font-black text-[#0b1d35]">{total}</p>
            <p className="mt-0.5 text-[0.64rem] font-bold tracking-[0.05em] text-[#8894a6] uppercase">
              Berita
            </p>
          </div>
        </div>
      </div>

      <ul className="min-w-0 flex-1 space-y-2">
        {segments.map((segment) => (
          <li key={segment.row.category} className="flex items-center gap-2 text-[0.85rem]">
            <span
              className="size-2.5 shrink-0 rounded-sm"
              style={{ background: segment.color }}
              aria-hidden="true"
            />
            <span className="min-w-0 flex-1 truncate font-semibold text-[#33445c]">
              {segment.row.category}
            </span>
            <span className="shrink-0 text-[0.78rem] text-[#8894a6]">
              {segment.row.total} ({Math.round(segment.percent)}%)
            </span>
          </li>
        ))}
      </ul>
    </div>
  );
}

function Panel({ title, action, children }) {
  return (
    <section className="rounded-xl border border-[#e8edf4] bg-white p-5">
      <div className="mb-4 flex items-center justify-between gap-3">
        <h2 className="text-[0.98rem] font-extrabold text-[#0b1d35]">{title}</h2>
        {action}
      </div>
      {children}
    </section>
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
      {/* Judul halaman */}
      <div className="mb-6 flex flex-wrap items-end justify-between gap-3">
        <div>
          <nav aria-label="Breadcrumb" className="mb-1.5 flex items-center gap-1.5 text-[0.72rem] font-bold text-[#9aa7b8]">
            <span>Admin</span>
            <span aria-hidden="true">/</span>
            <span className="text-[#33445c]">Dashboard</span>
          </nav>
          <h1 className="text-[1.65rem] leading-tight font-black tracking-[-0.03em] text-[#0b1d35]">
            Selamat datang{getAdminName() ? `, ${getAdminName()}` : ''}
          </h1>
          <p className="mt-1 text-[0.86rem] text-[#7b8798]">
            Ringkasan konten website Pusat P2M Polibatam.
          </p>
        </div>

        <div className="flex flex-wrap gap-2">
          <Link
            href="/"
            target="_blank"
            className="inline-flex items-center gap-2 rounded-xl border border-[#dbe3ee] bg-white px-4 py-2.5 text-[0.82rem] font-bold text-[#33445c] transition-colors hover:border-[#b9cde6] hover:bg-[#f7fafd]"
          >
            <Icon name="external" className="size-4" />
            Lihat Website
          </Link>
          <Link
            href="/admin/berita?aksi=tambah"
            className="inline-flex items-center gap-2 rounded-xl bg-[#1266d2] px-4 py-2.5 text-[0.82rem] font-extrabold text-white shadow-[0_6px_18px_-4px_rgba(18,102,210,0.55)] transition-colors hover:bg-[#0f56b3]"
          >
            <Icon name="plus" className="size-4" strokeWidth={2.4} />
            Tambah Berita
          </Link>
        </div>
      </div>

      {error && (
        <div role="alert" className="mb-4 rounded-lg border-l-4 border-red-500 bg-red-50 px-4 py-3 text-[0.9rem] text-red-700">
          {error}
        </div>
      )}

      {!data && !error && (
        <p className="text-[0.9rem] font-bold text-[#5b6675]">Memuat data…</p>
      )}

      {data && (
        <>
          {/* Kartu statistik */}
          <div className="mb-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <StatCard
              label="Total Berita"
              value={data.berita.total}
              icon="berita"
              tone="blue"
              hint={`${data.berita.published} terbit · ${data.berita.draft} draf`}
            />
            <StatCard
              label="Unggulan"
              value={data.berita.featured}
              icon="star"
              tone="amber"
              hint={`${data.berita.slider} tampil di slider beranda`}
            />
            <StatCard
              label='Kartu "You missed"'
              value={data.berita.missed}
              icon="layers"
              tone="green"
              hint="Berita di blok bawah beranda"
            />
            <StatCard
              label="Total Dibaca"
              value={Number(data.berita.total_views).toLocaleString('en-US')}
              icon="eye"
              tone="violet"
              hint="Seluruh pembacaan berita"
            />
          </div>

          {/* Perhatian: hal yang perlu ditindaklanjuti */}
          {(data.berita.draft > 0 || data.berita.featured === 0) && (
            <div className="mb-5 flex flex-wrap items-center gap-3 rounded-xl border border-[#fbe3b5] bg-[#fffbf0] px-4 py-3.5">
              <span className="grid size-9 shrink-0 place-items-center rounded-lg bg-[#fef4e3] text-[#b7791f]">
                <Icon name="bell" className="size-[17px]" />
              </span>
              <div className="min-w-0 flex-1">
                <p className="text-[0.86rem] font-extrabold text-[#7a4c05]">
                  Perlu perhatian
                </p>
                <p className="text-[0.8rem] text-[#9a6a1e]">
                  {data.berita.draft > 0 && `${data.berita.draft} berita masih berstatus draf`}
                  {data.berita.draft > 0 && data.berita.featured === 0 && ' · '}
                  {data.berita.featured === 0 && 'Belum ada berita unggulan untuk slider'}
                </p>
              </div>
              <Link
                href="/admin/berita"
                className="rounded-lg border border-[#e8c98a] bg-white px-3.5 py-2 text-[0.78rem] font-extrabold text-[#8a5a00] hover:bg-[#fff6e5]"
              >
                Tinjau
              </Link>
            </div>
          )}

          {/* Baris tengah: donut + terpopuler */}
          <div className="mb-5 grid gap-4 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.15fr)]">
            <Panel
              title="Berita per Kategori"
              action={
                <Link
                  href="/admin/berita"
                  className="text-[0.76rem] font-bold text-[#1266d2] hover:underline"
                >
                  Lihat semua
                </Link>
              }
            >
              {data.per_kategori.length === 0 ? (
                <p className="text-[0.86rem] text-[#8894a6]">Belum ada berita.</p>
              ) : (
                <Donut rows={data.per_kategori} />
              )}
            </Panel>

            <Panel
              title="Berita Terpopuler"
              action={<span className="text-[0.72rem] font-bold text-[#8894a6]">Top 5</span>}
            >
              {data.terpopuler.length === 0 ? (
                <p className="text-[0.86rem] text-[#8894a6]">Belum ada berita.</p>
              ) : (
                <ol className="space-y-1">
                  {data.terpopuler.map((post, index) => (
                    <li
                      key={post.id}
                      className="flex items-start gap-3 rounded-lg py-2 transition-colors hover:bg-[#f7f9fc]"
                    >
                      <span className="mt-0.5 grid size-6 shrink-0 place-items-center rounded-md bg-[#eef4ff] text-[0.72rem] font-black text-[#1266d2]">
                        {index + 1}
                      </span>
                      <span className="min-w-0 flex-1">
                        <Link
                          href={`/berita/${post.slug}`}
                          target="_blank"
                          className="line-clamp-2 text-[0.86rem] leading-snug font-bold text-[#0b1d35] hover:text-[#1266d2]"
                        >
                          {post.title}
                        </Link>
                      </span>
                      <span className="mt-0.5 flex shrink-0 items-center gap-1 text-[0.74rem] font-bold text-[#8894a6]">
                        <Icon name="eye" className="size-3.5" />
                        {post.views}
                      </span>
                    </li>
                  ))}
                </ol>
              )}
            </Panel>
          </div>

          {/* Aksi cepat */}
          <Panel title="Aksi Cepat">
            <div className="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
              {[
                { href: '/admin/berita?aksi=tambah', icon: 'plus', label: 'Tambah Berita', desc: 'Publikasikan berita baru', tone: 'blue' },
                { href: '/admin/beranda', icon: 'settings', label: 'Konten Beranda', desc: 'Ticker, judul & jumlah berita', tone: 'violet' },
                { href: '/admin/hki', icon: 'hki', label: 'Kelola HKI', desc: 'Data HKI per tahun', tone: 'green' },
                { href: '/admin/publikasi', icon: 'publikasi', label: 'Kelola Publikasi', desc: 'Luaran publikasi per tahun', tone: 'amber' },
                { href: '/admin/profil', icon: 'profil', label: 'Profil & Halaman', desc: 'Halaman statis website', tone: 'blue' },
                { href: '/admin/berita', icon: 'chart', label: 'Semua Berita', desc: 'Ubah, hapus, atur status', tone: 'violet' },
              ].map((action) => {
                const t = TONES[action.tone] ?? TONES.blue;

                return (
                  <Link
                    key={action.href + action.label}
                    href={action.href}
                    className="group flex items-center gap-3 rounded-lg border border-[#e8edf4] p-3.5 transition-all hover:border-[#c7dcf7] hover:bg-[#f8fbff]"
                  >
                    <span className={`grid size-9 shrink-0 place-items-center rounded-lg ${t.box} ${t.text}`}>
                      <Icon name={action.icon} className="size-[17px]" />
                    </span>
                    <span className="min-w-0">
                      <span className="block text-[0.84rem] font-bold text-[#0b1d35]">
                        {action.label}
                      </span>
                      <span className="block truncate text-[0.74rem] text-[#8894a6]">
                        {action.desc}
                      </span>
                    </span>
                  </Link>
                );
              })}
            </div>
          </Panel>
        </>
      )}
    </AdminShell>
  );
}
