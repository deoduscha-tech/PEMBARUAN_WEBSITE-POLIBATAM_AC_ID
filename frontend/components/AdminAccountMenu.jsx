'use client';

import { useEffect, useRef, useState } from 'react';
import Link from 'next/link';
import Icon from '@/components/AdminIcons';

/**
 * VIEW (client) — menu akun di topbar (klik avatar).
 *
 * Isinya pintasan ke Profil Admin dan tombol Keluar. Ditutup saat klik di luar
 * atau Escape ditekan.
 */
export default function AdminAccountMenu({ name = 'Admin', onLogout }) {
  const [open, setOpen] = useState(false);
  const ref = useRef(null);

  const initial = String(name).trim().charAt(0).toUpperCase() || 'A';

  useEffect(() => {
    function onDown(event) {
      if (ref.current && !ref.current.contains(event.target)) setOpen(false);
    }

    function onKey(event) {
      if (event.key === 'Escape') setOpen(false);
    }

    document.addEventListener('mousedown', onDown);
    document.addEventListener('keydown', onKey);

    return () => {
      document.removeEventListener('mousedown', onDown);
      document.removeEventListener('keydown', onKey);
    };
  }, []);

  return (
    <div ref={ref} className="relative">
      <button
        type="button"
        onClick={() => setOpen((v) => !v)}
        aria-expanded={open}
        aria-haspopup="menu"
        aria-label="Menu akun"
        className={`flex items-center gap-2.5 rounded-lg px-1.5 py-1 transition-colors ${open ? 'bg-[#f5f9ff]' : 'hover:bg-[#f5f9ff]'
          }`}
      >
        <span className="grid size-9 shrink-0 place-items-center rounded-full bg-gradient-to-br from-[#2f8bf0] to-[#1266d2] text-[0.8rem] font-black text-white">
          {initial}
        </span>
        <span className="hidden leading-tight md:block">
          <span className="block max-w-[140px] truncate text-[0.82rem] font-bold text-[#0b1d35]">
            {name}
          </span>
          <span className="block text-[0.68rem] text-[#8894a6]">Administrator</span>
        </span>
        <Icon
          name="arrowDown"
          className={`hidden size-3.5 text-[#9aa7b8] transition-transform md:block ${open ? 'rotate-180' : ''}`}
        />
      </button>

      {open && (
        <div
          role="menu"
          className="absolute top-[calc(100%+10px)] right-0 z-50 w-[232px] overflow-hidden rounded-xl border border-[#e6ecf4] bg-white shadow-[0_18px_45px_rgba(11,33,56,0.16)]"
        >
          <div className="border-b border-[#f0f3f8] px-4 py-3">
            <p className="truncate text-[0.86rem] font-extrabold text-[#0b1d35]">{name}</p>
            <p className="text-[0.74rem] text-[#8894a6]">Administrator</p>
          </div>

          <Link
            href="/admin/profil-admin"
            role="menuitem"
            onClick={() => setOpen(false)}
            className="flex items-center gap-2.5 px-4 py-2.5 text-[0.84rem] font-semibold text-[#33445c] transition-colors hover:bg-[#f8fbff]"
          >
            <Icon name="users" className="size-4 text-[#8894a6]" />
            Profil Admin
          </Link>

          <Link
            href="/"
            target="_blank"
            role="menuitem"
            onClick={() => setOpen(false)}
            className="flex items-center gap-2.5 px-4 py-2.5 text-[0.84rem] font-semibold text-[#33445c] transition-colors hover:bg-[#f8fbff]"
          >
            <Icon name="external" className="size-4 text-[#8894a6]" />
            Lihat Website
          </Link>

          <button
            type="button"
            role="menuitem"
            onClick={onLogout}
            className="flex w-full items-center gap-2.5 border-t border-[#f0f3f8] px-4 py-2.5 text-left text-[0.84rem] font-semibold text-[#d92d20] transition-colors hover:bg-[#fef3f2]"
          >
            <Icon name="logout" className="size-4" />
            Keluar
          </button>
        </div>
      )}
    </div>
  );
}
