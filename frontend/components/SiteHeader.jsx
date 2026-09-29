import Link from 'next/link';
import SearchToggle from './SearchToggle';
import ProfileDropdown from './ProfileDropdown';

/**
 * Alamat panel admin (Laravel).
 *
 * Autentikasi dimiliki backend, jadi tombol ini mengarah ke panel admin
 * Laravel — bukan halaman login di Next.js.
 */
const ADMIN_URL = process.env.NEXT_PUBLIC_ADMIN_URL ?? 'http://127.0.0.1:8000/admin';

const NAV_ITEMS = [
  { label: 'BERITA', href: '/berita' },
  { label: 'PENELITIAN', href: '/penelitian' },
  { label: 'PENGABDIAN', href: '/pengabdian' },
  { label: 'PUBLIKASI', href: '/publikasi' },
  { label: 'HKI', href: '/hki' },
  {
    label: 'SINTA',
    href: 'https://sinta.kemdiktisaintek.go.id/affiliations/profile/564',
    external: true,
  },
  { label: 'JURNAL', href: 'https://jurnal.polibatam.ac.id/', external: true },
  { label: 'STATISTIK', href: '/statistik' },
  { label: 'POLIBATAM UNIVERSITY BERDAMPAK', href: '/berdampak' },
];

export default function SiteHeader({ page = 'home', active = null }) {

  return (
    <header>
      {/* Top utility bar — admin entry sits at the far right. */}
      <div className="w-full border-b border-white/10 bg-[#081d35] py-2">
        <div className="page-inner flex items-center justify-between gap-3">
          <div className="flex items-center gap-3 text-[15px] font-bold tracking-[0.01em] text-[#dfeafc]">
            <span>23 September 2026</span>
            <span className="opacity-80">19:30</span>
          </div>

          {/* Panel admin ada di Laravel — tautan langsung ke sana. */}
          <a
            href={ADMIN_URL}
            title="Masuk ke workspace admin"
            className="inline-flex shrink-0 items-center gap-2 rounded-full border border-white/15 bg-white/[0.07] py-1.5 pr-3.5 pl-2.5 text-[12.5px] font-bold tracking-[0.02em] text-[#dfeafc]/85 transition-all duration-200 hover:border-white/30 hover:bg-white/15 hover:text-white"
          >
            <svg className="size-[14px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
              <rect x="4" y="10.5" width="16" height="9.5" rx="2" />
              <path d="M8 10.5V7a4 4 0 1 1 8 0v3.5" />
            </svg>
            Login Admin
          </a>
        </div>
      </div>

      {/* Hero / branding */}
      <div className="hero-wrap">
        <div className="page-inner relative z-[1] flex min-h-[110px] items-center justify-start gap-4 py-3">
          <div className="site-logo" role="img" aria-label="Logo Pusat P2M Polibatam" />
          <h1 className="relative z-[1] m-0 text-[clamp(2rem,2.4vw,2.4rem)] leading-[1.08] font-extrabold tracking-[-0.04em] text-white/95 [text-shadow:0_4px_18px_rgba(0,0,0,0.25)]">
            Pusat P2M Polibatam
          </h1>
        </div>
      </div>

      {/* Primary navigation */}
      <nav className="nav-bar relative">
        <div className="flex w-full flex-wrap items-center">
          <Link href="/" aria-label="Beranda" className={`nav-home ${page === 'home' ? 'active' : ''}`}>
            <svg className="size-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.2" strokeLinecap="round" strokeLinejoin="round">
              <path d="M3 10.5 12 3l9 7.5" />
              <path d="M5.5 9.5V20h13V9.5" />
              <path d="M10 20v-5h4v5" />
            </svg>
          </Link>

          <ProfileDropdown isActive={active === 'profil'} />

          {NAV_ITEMS.map((item) =>
            item.external ? (
              <a key={item.label} className="nav-item" href={item.href} target="_blank" rel="noopener noreferrer">
                {item.label}
              </a>
            ) : (
              <Link
                key={item.label}
                className={`nav-item ${
                  active === item.href.slice(1) ? 'active' : ''
                }`}
                href={item.href}
              >
                {item.label}
              </Link>
            ),
          )}
        </div>

        <div className="flex items-center gap-2">
          <SearchToggle />
        </div>
      </nav>
    </header>
  );
}