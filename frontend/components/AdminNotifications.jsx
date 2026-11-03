'use client';

import { useEffect, useRef, useState } from 'react';
import Link from 'next/link';
import Icon from '@/components/AdminIcons';
import { adminFetch, getToken } from '@/lib/adminSession';

/**
 * VIEW (client) — tombol lonceng + panel notifikasi di topbar.
 *
 * Daftar pemberitahuan diambil dari /api/admin/notifikasi dan dirakit backend
 * dari keadaan data (draf belum terbit, data HKI kurang, berita terbaru).
 * Klik di luar panel atau tombol Escape menutupnya.
 */

const TONE = {
  amber: { box: 'bg-[#fef4e3]', text: 'text-[#b7791f]', icon: 'berita' },
  blue: { box: 'bg-[#e8f1ff]', text: 'text-[#1266d2]', icon: 'berita' },
  violet: { box: 'bg-[#efeafd]', text: 'text-[#6d47d9]', icon: 'hki' },
  green: { box: 'bg-[#e6f7ee]', text: 'text-[#0e8a4f]', icon: 'check' },
};

export default function AdminNotifications() {
  const [open, setOpen] = useState(false);
  const [items, setItems] = useState([]);
  const [meta, setMeta] = useState({ total: 0, belum_dibaca: 0 });
  const [loading, setLoading] = useState(false);
  const boxRef = useRef(null);

  useEffect(() => {
    if (!getToken()) return;

    adminFetch('/admin/notifikasi').then((response) => {
      if (!response.ok) return;

      setItems(response.data.data ?? []);
      setMeta(response.data.meta ?? { total: 0, belum_dibaca: 0 });
    });
  }, []);

  // Tutup saat klik di luar atau Escape ditekan.
  useEffect(() => {
    function onDown(event) {
      if (boxRef.current && !boxRef.current.contains(event.target)) setOpen(false);
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
    <div ref={boxRef} className="relative">
      <button
        type="button"
        onClick={() => {
          setOpen((v) => !v);
          setLoading(false);
        }}
        aria-label={`Notifikasi${meta.belum_dibaca > 0 ? ` (${meta.belum_dibaca} baru)` : ''}`}
        aria-expanded={open}
        aria-haspopup="true"
        className={`relative grid size-9 place-items-center rounded-lg border transition-colors ${open
            ? 'border-[#1266d2] bg-[#f5f9ff] text-[#1266d2]'
            : 'border-[#e3e8f0] text-[#5b6675] hover:bg-[#f5f9ff]'
          }`}
      >
        <Icon name="bell" className="size-[17px]" />
        {meta.belum_dibaca > 0 && (
          <span className="absolute -top-1 -right-1 grid min-w-[16px] place-items-center rounded-full bg-[#f04438] px-1 text-[0.6rem] font-black text-white ring-2 ring-white">
            {meta.belum_dibaca}
          </span>
        )}
      </button>

      {open && (
        <div
          role="menu"
          className="absolute top-[calc(100%+10px)] right-0 z-50 w-[340px] max-w-[calc(100vw-24px)] overflow-hidden rounded-xl border border-[#e6ecf4] bg-white shadow-[0_18px_45px_rgba(11,33,56,0.16)]"
        >
          <div className="flex items-center justify-between border-b border-[#f0f3f8] px-4 py-3">
            <div>
              <p className="text-[0.9rem] font-extrabold text-[#0b1d35]">Notifikasi</p>
              <p className="text-[0.72rem] text-[#8894a6]">
                {meta.total} pemberitahuan
                {meta.belum_dibaca > 0 && ` · ${meta.belum_dibaca} perlu tindakan`}
              </p>
            </div>
            <span className="rounded-full bg-[#e8f1ff] px-2 py-0.5 text-[0.68rem] font-black text-[#1266d2]">
              {meta.total}
            </span>
          </div>

          <ul className="max-h-[340px] overflow-y-auto">
            {items.length === 0 && (
              <li className="px-4 py-8 text-center text-[0.85rem] text-[#8894a6]">
                {loading ? 'Memuat…' : 'Tidak ada notifikasi.'}
              </li>
            )}

            {items.map((item, index) => {
              const tone = TONE[item.tone] ?? TONE.blue;

              return (
                <li key={`${item.type}-${index}`} className="border-b border-[#f5f7fb] last:border-b-0">
                  <Link
                    href={item.href}
                    onClick={() => setOpen(false)}
                    className="flex gap-3 px-4 py-3 transition-colors hover:bg-[#f8fbff]"
                  >
                    <span
                      className={`mt-0.5 grid size-8 shrink-0 place-items-center rounded-lg ${tone.box} ${tone.text}`}
                    >
                      <Icon name={tone.icon} className="size-4" />
                    </span>
                    <span className="min-w-0 flex-1">
                      <span className="line-clamp-2 block text-[0.82rem] leading-snug font-bold text-[#0b1d35]">
                        {item.title}
                      </span>
                      <span className="mt-0.5 line-clamp-2 block text-[0.75rem] leading-relaxed text-[#8894a6]">
                        {item.desc}
                      </span>
                      <span
                        className={`mt-1 inline-block text-[0.68rem] font-bold ${item.time === 'Perlu tindakan' ? 'text-[#b7791f]' : 'text-[#b9c2cf]'
                          }`}
                      >
                        {item.time}
                      </span>
                    </span>
                  </Link>
                </li>
              );
            })}
          </ul>

          <Link
            href="/admin/berita"
            onClick={() => setOpen(false)}
            className="block border-t border-[#f0f3f8] bg-[#fafcfe] px-4 py-2.5 text-center text-[0.78rem] font-extrabold text-[#1266d2] hover:bg-[#f1f7ff]"
          >
            Lihat semua berita
          </Link>
        </div>
      )}
    </div>
  );
}
