'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';

export default function HkiDropdown({ active = false }) {
  const [open, setOpen] = useState(false);
  const [items, setItems] = useState([]);

  useEffect(() => {
    fetch('/api/hki', { headers: { Accept: 'application/json' } })
      .then((response) => response.ok ? response.json() : null)
      .then((payload) => setItems(payload?.data?.menu ?? []))
      .catch(() => setItems([]));
  }, []);

  return (
    <div className="relative inline-flex items-stretch" onMouseEnter={() => setOpen(true)} onMouseLeave={() => setOpen(false)}>
      <Link href="/hki" className={`nav-item ${active ? 'active' : ''}`} aria-expanded={open} aria-controls="hki-nav-submenu">
        HKI
        <svg className="caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6" /></svg>
      </Link>
      {open && (
        <div id="hki-nav-submenu" className="nav-submenu">
          <Link href="/hki/pendaftaran" className="nav-submenu-item">Pendaftaran HKI</Link>
          {items.map((item) => <Link key={item.key} href={item.href} className="nav-submenu-item">{item.label}</Link>)}
        </div>
      )}
    </div>
  );
}
