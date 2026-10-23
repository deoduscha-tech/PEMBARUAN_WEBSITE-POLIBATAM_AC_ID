'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';

// Keep the menu usable immediately; the API response replaces this list with
// the years currently maintained by the backend.
const FALLBACK_YEARS = Array.from({ length: 17 }, (_, index) => 2026 - index).map((year) => ({
  key: String(year),
  label: `TAHUN ${year}`,
  href: `/publikasi?tahun=${year}`,
}));

export default function PublikasiDropdown({ active = false }) {
  const [open, setOpen] = useState(false);
  const [items, setItems] = useState(FALLBACK_YEARS);

  useEffect(() => {
    fetch('/api/publikasi', { headers: { Accept: 'application/json' } })
      .then((response) => response.ok ? response.json() : null)
      .then((payload) => {
        const menu = payload?.data?.menu;
        if (Array.isArray(menu) && menu.length > 0) setItems(menu);
      })
      .catch(() => {});
  }, []);

  return (
    <div className="relative inline-flex items-stretch" onMouseEnter={() => setOpen(true)} onMouseLeave={() => setOpen(false)}>
      <Link href="/publikasi" className={`nav-item ${active ? 'active' : ''}`} aria-expanded={open} aria-controls="publikasi-nav-submenu">
        PUBLIKASI
        <svg className="caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6" /></svg>
      </Link>
      {open && (
        <div id="publikasi-nav-submenu" className="nav-submenu publikasi-nav-submenu">
          {items.map((item) => <Link key={item.key} href={item.href} className="nav-submenu-item">{item.label}</Link>)}
        </div>
      )}
    </div>
  );
}
