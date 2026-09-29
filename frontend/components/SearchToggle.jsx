
'use client';

import { useState } from 'react';
import SearchPanel from './SearchPanel';

/**
 * VIEW (client) — tombol cari + panelnya.
 *
 * Dipisah dari SiteHeader karena SiteHeader adalah Server Component (butuh
 * baca cookie sesi), sedangkan panel ini butuh state buka/tutup.
 */
export default function SearchToggle() {
  const [open, setOpen] = useState(false);

  return (
    <>
      <button
        type="button"
        onClick={() => setOpen((v) => !v)}
        className="nav-home mr-0"
        aria-label="Cari"
        aria-expanded={open}
        aria-controls="search-panel"
      >
        <svg
          className="size-[17px]"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          strokeWidth="2.4"
          strokeLinecap="round"
        >
          <circle cx="11" cy="11" r="7" />
          <line x1="16.2" y1="16.2" x2="21" y2="21" />
        </svg>
      </button>

      {open && (
        <div id="search-panel" className="absolute top-full right-0 left-0 z-40">
          <SearchPanel onClose={() => setOpen(false)} />
        </div>
      )}
    </>
  );
}