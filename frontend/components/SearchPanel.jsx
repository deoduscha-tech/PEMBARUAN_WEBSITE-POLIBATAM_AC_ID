'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';

/**
 * VIEW (client) — panel pencarian di header.
 *
 * Mengirim kata kunci ke halaman /berita?q=... — pencariannya dikerjakan
 * Model di sisi server, bukan di komponen ini.
 */
export default function SearchPanel({ onClose }) {
  const router = useRouter();
  const [query, setQuery] = useState('');

  function handleSubmit(event) {
    event.preventDefault();

    const q = query.trim();

    if (q === '') return;

    router.push(`/berita?q=${encodeURIComponent(q)}`);
    onClose?.();
  }

  return (
    <div className="w-full border-b border-navy/10 bg-gradient-to-b from-[#f5f9ff] to-[#edf4ff] py-2.5">
      <form onSubmit={handleSubmit} className="site-search-inner border">
        <input
          type="search"
          autoFocus
          value={query}
          onChange={(e) => setQuery(e.target.value)}
          placeholder="Cari berita, kegiatan, atau publikasi..."
          aria-label="Cari"
          className="min-w-0 flex-1 border-0 bg-transparent py-2.5 text-[0.98rem] text-[#132c54] outline-none placeholder:text-[#71819a]"
        />
        <button
          type="submit"
          className="rounded-full bg-[#1e6fd9] px-4 py-2 text-[0.75rem] font-bold text-white uppercase transition-colors hover:bg-[#0d4ca8]"
        >
          Cari
        </button>
        <button
          type="button"
          onClick={onClose}
          className="grid size-[34px] cursor-pointer place-items-center rounded-full border-0 bg-[#eaf1ff] text-lg font-bold text-[#133b70]"
          aria-label="Tutup pencarian"
        >
          &times;
        </button>
      </form>
    </div>
  );
}