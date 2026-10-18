'use client';

import { useState, useRef, useEffect } from 'react';
import Link from 'next/link';

const PROFILE_SUBMENU = [
  { label: 'LAPORAN TAHUNAN P3M TAHUN 2025', href: '/laporan-tahunan' },
  { label: 'KONTAK P3M', href: '/kontak' },
  { label: 'TUPOKSI', href: '/tupoksi' },
  { label: 'RENSTRA PENELITIAN', href: '/profil/renstra-penelitian' },
  { label: 'RIP PENGABDIAN', href: '/profil/rip-pengabdian' },
];

// Anak menu HKI di dalam dropdown PROFIL — sama seperti submenu HKI di
// situs asli p2m.polibatam.ac.id.
const HKI_YEARS = ['2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017'];

const HKI_SUBMENU = [
  { label: 'HKI', href: '/hki' },
  { label: 'PENDAFTARAN HKI', href: '/hki/pendaftaran' },
  ...HKI_YEARS.map((year) => ({ label: `HKI TAHUN ${year}`, href: `/hki/tahun-${year}` })),
];

/**
 * VIEW (client) — menu dropdown PROFIL.
 *
 * Dipisah dari SiteHeader (Server Component) karena butuh state buka/tutup.
 * Terbuka saat di-hover (desktop) atau diklik, dan tertutup saat klik di luar
 * atau tombol Escape ditekan.
 */
export default function ProfileDropdown({ isActive = false }) {
  const [open, setOpen] = useState(false);
  const [hkiOpen, setHkiOpen] = useState(false);
  const ref = useRef(null);

  useEffect(() => {
    function onDocClick(event) {
      if (ref.current && !ref.current.contains(event.target)) {
        setOpen(false);
        setHkiOpen(false);
      }
    }

    function onKey(event) {
      if (event.key === 'Escape') {
        setOpen(false);
        setHkiOpen(false);
      }
    }

    document.addEventListener('click', onDocClick);
    document.addEventListener('keydown', onKey);

    return () => {
      document.removeEventListener('click', onDocClick);
      document.removeEventListener('keydown', onKey);
    };
  }, []);

  return (
    <div
      ref={ref}
      className="relative inline-flex items-stretch"
      onMouseEnter={() => setOpen(true)}
      onMouseLeave={() => {
        setOpen(false);
        setHkiOpen(false);
      }}
    >
      <button
        type="button"
        onClick={() => {
          setOpen((v) => !v);
          setHkiOpen(false);
        }}
        aria-expanded={open}
        aria-controls="profile-submenu"
        className={`nav-item profile-trigger ${isActive ? 'active' : ''}`}
      >
        PROFIL
        <svg
          className="caret"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          strokeWidth="2.5"
          strokeLinecap="round"
          strokeLinejoin="round"
          aria-hidden="true"
        >
          <path d="M6 9l6 6 6-6" />
        </svg>
      </button>

      {open && (
        <div id="profile-submenu" className="nav-submenu">
          {PROFILE_SUBMENU.map((item) => (
            <Link
              key={item.href}
              href={item.href}
              className="nav-submenu-item"
              onClick={() => setOpen(false)}
            >
              {item.label}
            </Link>
          ))}

          {/* HKI — dibuka dengan klik supaya daftar tahun tidak menutupi
              seluruh layar di HP. */}
          <button
            type="button"
            onClick={() => setHkiOpen((v) => !v)}
            aria-expanded={hkiOpen}
            aria-controls="profile-submenu-hki"
            className="nav-submenu-item flex w-full items-center justify-between text-left"
          >
            HKI
            <svg
              className="caret"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              strokeWidth="2.5"
              strokeLinecap="round"
              strokeLinejoin="round"
              aria-hidden="true"
            >
              <path d="M6 9l6 6 6-6" />
            </svg>
          </button>

          {hkiOpen && (
            <div id="profile-submenu-hki">
              {HKI_SUBMENU.map((item) => (
                <Link
                  key={item.href}
                  href={item.href}
                  className="nav-submenu-item nav-submenu-item-child"
                  onClick={() => {
                    setHkiOpen(false);
                    setOpen(false);
                  }}
                >
                  {item.label}
                </Link>
              ))}
            </div>
          )}
        </div>
      )}
    </div>
  );
}
