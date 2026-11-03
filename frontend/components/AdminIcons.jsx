
'use client';

import Link from 'next/link';
import { usePathname } from 'next/navigation';

/**
 * VIEW — ikon garis untuk sidebar & kartu admin.
 *
 * Sengaja SVG kecil tanpa library tambahan supaya bundle ringan dan
 * warna mengikuti `currentColor`.
 */

const PATHS = {
  dashboard: 'M4 4h7v7H4zM13 4h7v4h-7zM13 10h7v10h-7zM4 13h7v7H4z',
  berita: 'M4 5h16v14H4zM7 9h10M7 13h10M7 17h6',
  beranda: 'M3 11l9-7 9 7M5 10v10h14V10M10 20v-6h4v6',
  hki: 'M12 3l7 4v5c0 4.5-3 8-7 9-4-1-7-4.5-7-9V7z',
  shield: 'M12 3l7 4v5c0 4.5-3 8-7 9-4-1-7-4.5-7-9V7zM9 12l2 2 4-4',
  publikasi: 'M6 3h9l4 4v14H6zM15 3v4h4M9 12h7M9 16h7',
  profil: 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM4 20c0-3.5 3.6-6 8-6s8 2.5 8 6',
  pengabdian: 'M12 21s-7-4.4-7-9a4 4 0 0 1 7-2.6A4 4 0 0 1 19 12c0 4.6-7 9-7 9z',
  beritaTerkini: 'M4 6h16v12H4zM8 10h8M8 14h5',
  logout: 'M15 12H4m0 0l4-4m-4 4l4 4M10 4h9v16h-9',
  external: 'M14 4h6v6M20 4l-9 9M18 14v6H4V6h6',
  search: 'M11 18a7 7 0 1 0 0-14 7 7 0 0 0 0 14zM20 20l-3.5-3.5',
  bell: 'M6 9a6 6 0 1 1 12 0c0 5 2 6 2 6H4s2-1 2-6zM10 20a2 2 0 0 0 4 0',
  eye: 'M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6zM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z',
  clock: 'M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18zM12 7v5l3 2',
  users: 'M16 20v-1.5A3.5 3.5 0 0 0 12.5 15h-5A3.5 3.5 0 0 0 4 18.5V20M10 11a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM20 20v-1.5a3.5 3.5 0 0 0-2.6-3.4M15.5 4.2a3.5 3.5 0 0 1 0 6.6',
  star: 'M12 3.5l2.7 5.6 6 .9-4.4 4.3 1 6-5.3-2.9-5.3 2.9 1-6L3.3 10l6-.9z',
  plus: 'M12 5v14M5 12h14',
  edit: 'M4 20h4l10-10-4-4L4 16zM14 6l4 4',
  trash: 'M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13',
  check: 'M4 12l5 5L20 6',
  x: 'M6 6l12 12M18 6L6 18',
  chart: 'M4 20V10M10 20V4M16 20v-7M22 20H2',
  layers: 'M12 3l9 5-9 5-9-5zM3 13l9 5 9-5',
  settings: 'M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM19.4 15a7.9 7.9 0 0 0 .1-1 7.9 7.9 0 0 0-.1-1l2-1.6-2-3.4-2.4 1a8 8 0 0 0-1.7-1L15 4.5h-4l-.3 2.5a8 8 0 0 0-1.7 1l-2.4-1-2 3.4 2 1.6a7.9 7.9 0 0 0 0 2l-2 1.6 2 3.4 2.4-1a8 8 0 0 0 1.7 1l.3 2.5h4l.3-2.5a8 8 0 0 0 1.7-1l2.4 1 2-3.4z',
  download: 'M12 3v12m0 0l-4-4m4 4l4-4M4 21h16',
  arrowUp: 'M12 19V5m0 0l-6 6m6-6l6 6',
  arrowDown: 'M12 5v14m0 0l6-6m-6 6l-6-6',
  menu: 'M4 7h16M4 12h16M4 17h16',
};

export default function Icon({ name, className = 'size-4', strokeWidth = 1.8 }) {
  const path = PATHS[name] ?? PATHS.dashboard;

  return (
    <svg
      className={className}
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      strokeWidth={strokeWidth}
      strokeLinecap="round"
      strokeLinejoin="round"
      aria-hidden="true"
    >
      <path d={path} />
    </svg>
  );
}

export { Link, Icon, usePathname };
