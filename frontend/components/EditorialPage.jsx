import Link from 'next/link';
import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';
import { apiGet } from '@/lib/api';

/**
 * VIEW — komponen bersama untuk semua halaman editorial (profil, informasi,
 * hki, statistik, berdampak, publikasi, arsip tahun).
 *
 * Data berita diambil dari API Laravel, bukan dari berkas lokal.
 */
export default async function EditorialPage({
  slug,
  heading,
  visitors,
  children,
  showPosts = false,
  isPublication = false,
}) {
  // Berita terbaru untuk blok unggulan (hanya halaman tertentu).
  const postsResponse = showPosts
    ? await apiGet('/berita', { params: { limit: 3 } })
    : null;

  const posts = postsResponse?.ok ? (postsResponse.data.data ?? []) : [];

  const yearMenu = [
    { label: 'TAHUN 2026', href: '/tahun-2026', key: 'tahun2026' },
    { label: 'TAHUN 2025', href: '/tahun-2025', key: 'tahun2025' },
    { label: 'TAHUN 2024', href: '/tahun-2024', key: 'tahun2024' },
    { label: 'TAHUN SEBELUMNYA', href: '/publikasi', key: 'publikasi' },
  ];

  return (
    <>
      <SiteHeader page="home" active={slug} />

      <main className="bg-[#efefef] pb-6">
        <h1 className="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">
          {heading}
        </h1>

        {isPublication ? (
          <div className="wide-inner mb-4 grid border-line bg-[#f3f3f3] md:grid-cols-[260px_minmax(0,1fr)]">
            <nav className="flex flex-col bg-[#1d2432] py-1">
              {yearMenu.map((year) => (
                <Link
                  key={year.key}
                  href={year.href}
                  className={`year-item ${year.key === slug || (slug === 'publikasi' && year.key === 'tahun2026')
                      ? 'active'
                      : ''
                    }`}
                >
                  {year.label}
                </Link>
              ))}
            </nav>

            <div className="min-h-[380px] bg-[#efefef] p-6 rich-copy">
              <h3 className="mb-[18px] text-center text-[clamp(1.8rem,2.5vw,2.4rem)] font-black text-[#0b1d35]">
                LUARAN PUBLIKASI
              </h3>
              <p>
                Daftar luaran publikasi penelitian dan pengabdian kepada masyarakat Pusat P2M
                Politeknik Negeri Batam. Silakan pilih tahun pada menu di samping untuk melihat
                data publikasi terkait.
              </p>
              <p>
                <a href="#">Lihat daftar publikasi lengkap &rarr;</a>
              </p>
            </div>
          </div>
        ) : (
          <div className="wide-inner mb-4 border-line bg-[#f3f3f3] p-6 rich-copy">
            {children}
          </div>
        )}

        {posts.length > 0 && (
          <div className="wide-inner mb-4 border-line bg-[#f3f3f3]">
            {posts.map((post) => (
              <div className="story-row" key={post.slug}>
                <Link
                  href={`/berita/${post.slug}`}
                  className="story-thumb !border-line bg-cover bg-center"
                  style={{ backgroundImage: `url('${post.image}')` }}
                  aria-label={post.title}
                />
                <div className="story-copy">
                  <span className="category-chip">
                    {String(post.category).toUpperCase()}
                  </span>
                  <h3 className="mt-2.5">
                    <Link href={`/berita/${post.slug}`}>{post.title}</Link>
                  </h3>
                  <p className="mb-3 text-[1.05rem] leading-relaxed text-muted">{post.excerpt}</p>
                  <Link className="read-more" href={`/berita/${post.slug}`}>
                    Baca Selengkapnya
                  </Link>
                </div>
              </div>
            ))}
          </div>
        )}

        {visitors && (
          <div className="wide-inner pb-6 text-[1.12rem] font-bold">
            Jumlah Pengunjung: {visitors}
          </div>
        )}

        <MissedSection />
      </main>

      <SiteFooter />
    </>
  );
}