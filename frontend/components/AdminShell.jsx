'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import { usePathname, useRouter } from 'next/navigation';
import { getToken, getAdminName, clearSession } from '@/lib/adminSession';

/**
 * VIEW (client) — kerangka panel admin.
 *
 * Sidebar semua menu pengelolaan, plus penjaga: kalau belum login (tidak ada
 * token) pengguna dilempar ke /admin/login.
 */
const MENU = [
  { key: 'admin', label: 'Ringkasan', href: '/admin' },
  { key: 'berita', label: 'Kelola Berita', href: '/admin/berita' },
  { key: 'beranda', label: 'Konten Beranda', href: '/admin/beranda' },
  { key: 'hki', label: 'Kelola HKI', href: '/admin/hki' },
  { key: 'publikasi', label: 'Kelola Publikasi', href: '/admin/publikasi' },
  { key: 'profil', label: 'Profil & Halaman', href: '/admin/profil' },
];

export default function AdminShell({ children }) {
  const router = useRouter();
  const pathname = usePathname();
  const [ready, setReady] = useState(false);
  const [name, setName] = useState('');

  useEffect(() => {
    if (!getToken()) {
      router.replace('/admin/login');
      return;
    }

    setName(getAdminName());
    setReady(true);
  }, [router]);

  function logout() {
    clearSession();
    router.replace('/admin/login');
  }

  if (!ready) {
    return (
      <div className="grid min-h-screen place-items-center bg-[#eef1f5]">
        <p className="text-[0.9rem] font-bold text-[#5b6675]">Memeriksa sesi…</p>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-[#eef1f5] lg:flex">
      {/* Sidebar */}
      <aside className="w-full shrink-0 bg-[#0f2238] lg:min-h-screen lg:w-[250px]">
        <div className="flex h-[64px] items-center gap-2.5 border-b border-white/10 px-5">
          <span className="grid size-9 place-items-center rounded bg-white/10 text-[0.72rem] font-black text-white">
            P2M
          </span>
          <span className="text-[0.92rem] font-extrabold tracking-[-0.01em] text-white">
            Panel Admin
          </span>
        </div>

        <nav className="flex flex-wrap gap-1 p-3 lg:flex-col">
          {MENU.map((item) => {
            const active =
              item.href === '/admin' ? pathname === '/admin' : pathname.startsWith(item.href);

            return (
              <Link
                key={item.key}
                href={item.href}
                aria-current={active ? 'page' : undefined}
                className={`rounded px-3.5 py-2.5 text-[0.86rem] font-bold transition-colors ${active
                    ? 'bg-[#1e6fd9] text-white'
                    : 'text-white/70 hover:bg-white/10 hover:text-white'
                  }`}
              >
                {item.label}
              </Link>
            );
          })}
        </nav>

        <div className="mt-auto hidden border-t border-white/10 p-4 lg:block">
          <Link
            href="/"
            target="_blank"
            className="mb-2 block text-[0.8rem] font-bold text-[#8fb6ea] hover:text-white"
          >
            Lihat website ↗
          </Link>
          <button
            type="button"
            onClick={logout}
            className="w-full rounded border border-white/15 px-3 py-2 text-[0.8rem] font-bold text-white/80 transition-colors hover:bg-white/10 hover:text-white"
          >
            Keluar
          </button>
        </div>
      </aside>

      {/* Isi */}
      <div className="min-w-0 flex-1">
        <header className="flex flex-wrap items-center justify-between gap-3 border-b border-[#dde3ec] bg-white px-5 py-3.5">
          <div className="text-[0.85rem] font-bold text-[#5b6675]">
            Masuk sebagai{' '}
            <span className="text-[#0b1d35]">{name || 'Admin'}</span>
          </div>

          <div className="flex items-center gap-2">
            <Link
              href="/"
              target="_blank"
              className="rounded border border-[#cfd8e3] px-3 py-1.5 text-[0.78rem] font-bold text-[#3b4757] hover:bg-[#eef4ff]"
            >
              Lihat Website
            </Link>
            <button
              type="button"
              onClick={logout}
              className="rounded bg-[#0f2238] px-3 py-1.5 text-[0.78rem] font-bold text-white hover:bg-[#1b3a5e] lg:hidden"
            >
              Keluar
            </button>
          </div>
        </header>

        <main className="p-5">{children}</main>
      </div>
    </div>
  );
}
