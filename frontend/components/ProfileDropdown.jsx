'use client';

import { useEffect, useRef, useState } from 'react';
import Link from 'next/link';

const ITEMS = [
  { label: 'LAPORAN TAHUNAN P3M TAHUN 2025', href: '/laporan-tahunan' },
  { label: 'KONTAK P3M', href: '/kontak' },
  { label: 'TUPOKSI', href: '/tupoksi' },
  { label: 'RENSTRA PENELITIAN', href: '/profil/renstra-penelitian' },
  { label: 'RIP PENGABDIAN', href: '/profil/rip-pengabdian' },
];

export default function ProfileDropdown({ isActive = false }) {
  const [open, setOpen] = useState(false);
  const ref = useRef(null);

  useEffect(() => {
    const closeOutside = (event) => { if (!ref.current?.contains(event.target)) setOpen(false); };
    const closeEscape = (event) => { if (event.key === 'Escape') setOpen(false); };
    document.addEventListener('click', closeOutside);
    document.addEventListener('keydown', closeEscape);
    return () => {
      document.removeEventListener('click', closeOutside);
      document.removeEventListener('keydown', closeEscape);
    };
  }, []);

  return (
    <div ref={ref} className="relative inline-flex items-stretch" onMouseEnter={() => setOpen(true)} onMouseLeave={() => setOpen(false)}>
      <button type="button" onClick={() => setOpen((value) => !value)} aria-expanded={open} aria-controls="profile-submenu" className={`nav-item profile-trigger ${isActive ? 'active' : ''}`}>
        PROFIL<svg className="caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6" /></svg>
      </button>
      {open && <div id="profile-submenu" className="nav-submenu">{ITEMS.map((item) => <Link key={item.href} href={item.href} className="nav-submenu-item" onClick={() => setOpen(false)}>{item.label}</Link>)}</div>}
    </div>
  );
}
