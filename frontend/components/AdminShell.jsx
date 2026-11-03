'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import { usePathname, useRouter } from 'next/navigation';
import { getToken, getAdminName, clearSession } from '@/lib/adminSession';
import Icon from '@/components/AdminIcons';
import AdminNotifications from '@/components/AdminNotifications';
import AdminAccountMenu from '@/components/AdminAccountMenu';

/**
 * VIEW (client) — kerangka panel admin.
 *
 * Sidebar biru gelap dengan ikon + submenu, topbar berisi pencarian dan kartu
 * akun. Kalau belum login (tidak ada token) pengguna dilempar ke /admin/login.
 */
const MENU = [
  { key: 'admin', label: 'Dashboard', href: '/admin', icon: 'dashboard' },
  { key: 'berita', label: 'Kelola Berita', href: '/admin/berita', icon: 'berita' },
  { key: 'beranda', label: 'Konten Beranda', href: '/admin/beranda', icon: 'beranda' },
  { key: 'hki', label: 'Kelola HKI', href: '/admin/hki', icon: 'hki' },
  { key: 'publikasi', label: 'Kelola Publikasi', href: '/admin/publikasi', icon: 'publikasi' },
  { key: 'profil', label: 'Profil & Halaman', href: '/admin/profil', icon: 'profil' },
];

/** Submenu di bawah setiap menu utama, mengikuti desain. */
const SUBMENU = {
  berita: [
    { label: 'Semua Berita', href: '/admin/berita' },
    { label: 'Tambah Berita', href: '/admin/berita?aksi=tambah' },
  ],
  beranda: [{ label: 'Pengaturan Tampilan', href: '/admin/beranda' }],
  hki: [{ label: 'Daftar Tahun', href: '/admin/hki' }],
  publikasi: [{ label: 'Daftar Tahun', href: '/admin/publikasi' }],
  profil: [{ label: 'Halaman Statis', href: '/admin/profil' }],
};

export default function AdminShell({ children }) {
  const router = useRouter();
  const pathname = usePathname();
  const [ready, setReady] = useState(false);
  const [name, setName] = useState('');
  const [sidebarOpen, setSidebarOpen] = useState(false);

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
      <div className="grid min-h-screen place-items-center bg-[#f3f5f9]">
        <p className="text-[0.9rem] font-bold text-[#5b6675]">Memeriksa sesi…</p>
      </div>
    );
  }

  const activeKey =
    MENU.slice()
      .reverse()
      .find((item) => (item.href === '/admin' ? pathname === '/admin' : pathname.startsWith(item.href)))
      ?.key ?? 'admin';

  const initial = (name || 'Admin').trim().charAt(0).toUpperCase();

  return (
    <div className="min-h-screen bg-[#f3f5f9] lg:flex">
      {/* --- Sidebar --- */}
      <aside
        className={`shrink-0 bg-[#0b2138] lg:min-h-screen lg:w-[258px] ${
          sidebarOpen ? 'block w-full' : 'hidden lg:block'
        }`}
      >
        {/* Logo */}
        <div className="flex h-[68px] items-center gap-3 border-b border-white/8 px-5">
          <span className="grid size-9 shrink-0 place-items-center rounded-lg bg-gradient-to-br from-[#2f8bf0] to-[#1266d2] text-[0.66rem] font-black tracking-[0.02em] text-white shadow-[0_4px_12px_rgba(30,111,217,0.45)]">
            P2M
          </span>
          <span className="min-w-0">
            <span className="block truncate text-[0.92rem] leading-tight font-extrabold text-white">
              Panel Admin
            </span>
            <span className="block text-[0.66rem] font-semibold tracking-[0.06em] text-white/45 uppercase">
              Pusat P2M Polibatam
            </span>
          </span>
        </div>

        {/* Menu */}
        <nav className="flex flex-col gap-0.5 p-3">
          {/* Tombol ke website publik */}
          <Link
            href="/berita"
            target="_blank"
            className="mb-2 flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-[0.84rem] font-bold text-white/70 transition-colors hover:bg-white/8 hover:text-white"
          >
            <Icon name="beritaTerkini" className="size-[17px] shrink-0" />
            Berita Terkini
            <Icon name="external" className="ml-auto size-3.5 shrink-0 opacity-50" />
          </Link>

          {MENU.map((item) => {
            const active = item.key === activeKey;
            const children = SUBMENU[item.key] ?? [];

            return (
              <div key={item.key}>
                <Link
                  href={item.href}
                  aria-current={active ? 'page' : undefined}
                  onClick={() => setSidebarOpen(false)}
                  className={`relative flex items-center gap-2.5 rounded-lg px-3 py-2.5 text-[0.84rem] font-bold transition-colors ${
                    active
                      ? 'bg-white/12 text-white'
                      : 'text-white/65 hover:bg-white/6 hover:text-white'
                  }`}
                >
                  {active && (
                    <span className="absolute top-1/2 -left-3 h-6 w-[3px] -translate-y-1/2 rounded-r bg-[#3d97f5]" />
                  )}
                  <Icon
                    name={item.icon}
                    className={`size-[17px] shrink-0 ${active ? 'text-[#5aa9ff]' : ''}`}
                  />
                  {item.label}
                </Link>

                {active && children.length > 0 && (
                  <div className="mt-0.5 mb-1 ml-[13px] flex flex-col gap-0.5 border-l border-white/12 pl-3">
                    {children.map((child) => (
                      <Link
                        key={child.href}
                        href={child.href}
                        onClick={() => setSidebarOpen(false)}
                        className="rounded px-2.5 py-1.5 text-[0.78rem] font-semibold text-white/50 transition-colors hover:text-white"
                      >
                        {child.label}
                      </Link>
                    ))}
                  </div>
                )}
              </div>
            );
          })}
        </nav>

        {/* Akun di bawah sidebar — klik untuk membuka Profil Admin */}
        <div className="mt-auto hidden border-t border-white/8 p-3 lg:block">
          <Link
            href="/admin/profil-admin"
            onClick={() => setSidebarOpen(false)}
            className="mb-2 flex items-center gap-2.5 rounded-lg bg-white/5 px-3 py-2.5 transition-colors hover:bg-white/10"
            title="Buka Profil Admin"
          >
            <span className="grid size-8 shrink-0 place-items-center rounded-full bg-gradient-to-br from-[#2f8bf0] to-[#1266d2] text-[0.78rem] font-black text-white">
              {initial}
            </span>
            <span className="min-w-0 flex-1">
              <span className="block truncate text-[0.8rem] font-bold text-white">
                {name || 'Admin'}
              </span>
              <span className="block text-[0.68rem] text-white/45">Administrator</span>
            </span>
            <Icon name="external" className="size-3.5 shrink-0 text-white/35" />
          </Link>

          <button
            type="button"
            onClick={logout}
            className="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-[0.8rem] font-bold text-white/60 transition-colors hover:bg-white/8 hover:text-white"
          >
            <Icon name="logout" className="size-[15px]" />
            Keluar
          </button>
        </div>
      </aside>

      {/* --- Isi --- */}
      <div className="min-w-0 flex-1">
        <header className="sticky top-0 z-20 flex h-[68px] items-center gap-3 border-b border-[#e3e8f0] bg-white/95 px-4 backdrop-blur md:px-6">
          {/* Tombol menu (mobile) */}
          <button
            type="button"
            onClick={() => setSidebarOpen((v) => !v)}
            aria-label="Buka menu"
            className="grid size-9 shrink-0 place-items-center rounded-lg border border-[#e3e8f0] text-[#33445c] lg:hidden"
          >
            <Icon name="menu" className="size-[18px]" />
          </button>

          {/* Pencarian */}
          <label className="relative hidden max-w-[420px] flex-1 items-center sm:flex">
            <Icon name="search" className="pointer-events-none absolute left-3 size-[17px] text-[#9aa7b8]" />
            <input
              type="search"
              placeholder="Cari berita, HKI, publikasi…"
              className="h-10 w-full rounded-lg border border-[#e3e8f0] bg-[#f7f9fc] pr-3 pl-10 text-[0.86rem] text-[#33445c] outline-none transition-colors placeholder:text-[#9aa7b8] focus:border-[#3d97f5] focus:bg-white"
            />
          </label>

          <div className="ml-auto flex items-center gap-2">
            <Link
              href="/"
              target="_blank"
              className="hidden items-center gap-1.5 rounded-lg border border-[#e3e8f0] px-3 py-2 text-[0.78rem] font-bold text-[#33445c] transition-colors hover:border-[#c7d6e8] hover:bg-[#f5f9ff] sm:inline-flex"
            >
              <Icon name="external" className="size-[14px]" />
              Lihat Website
            </Link>

            <AdminNotifications />

            <div className="border-l border-[#e3e8f0] pl-2.5">
              <AdminAccountMenu name={name || 'Admin'} onLogout={logout} />
            </div>

            <button
              type="button"
              onClick={logout}
              aria-label="Keluar"
              className="grid size-9 place-items-center rounded-lg border border-[#e3e8f0] text-[#5b6675] transition-colors hover:border-[#f8c9c3] hover:bg-[#fef3f2] hover:text-[#d92d20]"
            >
              <Icon name="logout" className="size-[17px]" />
            </button>
          </div>
        </header>

        <main className="p-4 md:p-6">{children}</main>
      </div>
    </div>
  );
}
