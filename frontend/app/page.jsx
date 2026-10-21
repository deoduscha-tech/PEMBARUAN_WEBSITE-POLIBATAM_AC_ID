import Link from 'next/link';
import SiteHeader from '../components/SiteHeader';
import SiteFooter from '../components/SiteFooter';
import FeaturedSlider from '../components/FeaturedSlider';
import SidebarTabs from '../components/SidebarTabs';
import Pagination from '../components/Pagination';
import { apiGet } from '@/lib/api';

// Data berita di-cache 60 detik (ISR) supaya perpindahan halaman instan.
// Ubah ke `export const dynamic = 'force-dynamic';` kalau harus selalu segar.
export const revalidate = 60;

export const metadata = {
  title: 'Beranda — Pusat P2M Polibatam',
};

export default async function HomePage({ searchParams }) {
  const params = await searchParams;
  const requestedPage = Math.max(1, Number(params?.page ?? 1) || 1);

  // Data diambil dari API Laravel — frontend tidak menyimpan data sendiri.
  const response = await apiGet('/beranda');

  const payload = response.ok ? response.data : {};

  const featured = payload.featured ?? [];
  const ticker = payload.homePosts?.slice(0, 5) ?? payload.latestPosts ?? [];
  const latest = payload.latestPosts ?? [];
  const popular = payload.popularPosts ?? [];
  const trending = payload.trendingPosts ?? [];
  const missed = payload.missedCards ?? [];

  const allPosts = payload.homePosts ?? [];
  const totalPosts = allPosts.length;
  const homePageSize = 2;
  const lastHomePage = 5;
  const homePage = Math.min(requestedPage, lastHomePage);
  const posts = allPosts.slice((homePage - 1) * homePageSize, homePage * homePageSize);

  if (!response.ok) {
    return (
      <>
        <SiteHeader page="home" />
        <main id="main-content" className="wide-inner py-16">
          <div className="border-l-4 border-amber-500 bg-amber-50 px-5 py-4 text-[#7c4a03]">
            <p className="font-extrabold">Tidak dapat memuat data dari API Laravel</p>
            <p className="mt-1 text-[0.9rem]">
              {response.error} — pastikan backend berjalan:{' '}
              <code>cd backend &amp;&amp; php artisan serve</code>
            </p>
          </div>
        </main>
        <SiteFooter />
      </>
    );
  }

  const tabs = [
    { key: 'latest', label: 'Latest', posts: latest },
    { key: 'popular', label: 'Popular', posts: popular },
    { key: 'trending', label: 'Trending', posts: trending },
  ];

  const slides = featured.length > 0 ? featured : posts.slice(0, 3);

  return (
    <>
      <SiteHeader page="home" />

      {/* Latest post ticker */}
      <section className="border-y border-[#0f213d]/10 bg-[#f7f9fc]">
        <div className="page-inner">
          <div className="flex min-h-[52px] w-full items-stretch overflow-hidden">
            <div className="bn-title relative z-10 shrink-0">
              <span className="inline-flex items-center gap-2.5 text-base font-extrabold text-white">
                <span className="ticker-icon" aria-hidden="true">
                  <svg className="size-3.5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13 2 4.5 13.5H11l-1 8.5 9-12h-6.5z" />
                  </svg>
                </span>
                Latest Post
              </span>
            </div>

            <div className="relative min-w-0 flex-1 overflow-hidden">
              <div className="ticker-track" aria-label="Postingan terbaru">
                {[0, 1].map((copy) => (
                  <div
                    key={copy}
                    className="flex h-full shrink-0 items-center"
                    aria-hidden={copy === 1 ? 'true' : undefined}
                  >
                    {ticker.map((item, index) => (
                      <Link
                        key={`${copy}-${item.slug}-${index}`}
                        className="ticker-item"
                        href={`/berita/${item.slug}`}
                        tabIndex={copy === 1 ? -1 : undefined}
                      >
                        <span className="inline-block size-[9px] shrink-0 rounded-full bg-blue shadow-[0_0_0_3px_rgba(28,115,217,0.16)]" />
                        {item.title}
                      </Link>
                    ))}
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Featured slider + sidebar tabs */}
      <section id="main-content" className="bg-[#eceef2]">
        <div className="wide-inner grid gap-[18px] py-[36px] lg:grid-cols-[minmax(0,2.1fr)_minmax(300px,0.92fr)] lg:items-stretch">
          <FeaturedSlider slides={slides} />

          <SidebarTabs tabs={tabs} />
        </div>
      </section>

      {/* Post list */}
      <div className="wide-inner py-[18px]">
        {posts.map((post) => (
          <article key={post.slug} className="article-post mb-[18px] flex flex-col gap-[18px] border md:flex-row">
            <div className="flex w-full shrink-0 flex-col md:w-1/2">
              <Link
                href={`/berita/${post.slug}`}
                className="block min-h-[220px] flex-1 border bg-cover bg-center md:min-h-[280px]"
                style={{ backgroundImage: `url('${post.image}')` }}
                aria-label={post.title}
              />
            </div>
            <div className="flex min-w-0 flex-1 flex-col justify-center">
              <span className="category-chip w-fit">
                {String(post.category).toUpperCase()}
              </span>
              <h4 className="entry-title">
                <Link href={`/berita/${post.slug}`}>{post.title}</Link>
              </h4>
              <div className="flex flex-wrap items-center gap-2.5 text-[0.78rem] font-bold text-[#6b7787]">
                <span>{post.date}</span>
                <span aria-hidden="true">&middot;</span>
                <span>{post.author}</span>
              </div>
              <p className="mt-2 text-[0.95rem] leading-relaxed text-muted">{post.excerpt}</p>
              <Link
                href={`/berita/${post.slug}`}
                className="mt-3 inline-flex w-fit items-center gap-1.5 text-[0.8rem] font-bold text-blue hover:underline"
              >
                Baca Selengkapnya
                <svg className="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.6" strokeLinecap="round" strokeLinejoin="round">
                  <path d="M5 12h14" />
                  <path d="M12 5l7 7-7 7" />
                </svg>
              </Link>
            </div>
          </article>
        ))}

        {lastHomePage > 1 && (
          <div className="mt-3 flex flex-col items-center justify-center gap-1.5 sm:flex-row sm:gap-2">
            <h2 className="text-center text-[clamp(1.7rem,2.7vw,2.35rem)] leading-tight font-extrabold tracking-[-0.04em] text-[#111827]">
              Posts pagination
            </h2>
            <Pagination page={homePage} lastPage={lastHomePage} basePath="/" showAllPages variant="home" />
          </div>
        )}
      </div>

      {/* You missed */}
      <section className="border-t border-line bg-[#f3f5f7] py-[18px]">
        <div className="wide-inner">
          <div className="mb-[18px] flex items-end border-b-2 border-line">
            <span className="section-label">You missed</span>
          </div>
          <div className="grid gap-[18px] sm:grid-cols-2 xl:grid-cols-4">
            {missed.map((card) => (
              <article
                key={card.slug}
                className="flex min-h-[210px] items-end bg-cover bg-center"
                style={{ backgroundImage: `url('${card.image}')` }}
              >
                <Link
                  href={`/berita/${card.slug}`}
                  className="block w-full bg-gradient-to-t from-[#081d35]/92 to-[#081d35]/10 p-4"
                  aria-label={card.title}
                >
                  <span className="category-chip">
                    {String(card.category).toUpperCase()}
                  </span>
                  <h4 className="mt-1.5 mb-2 line-clamp-3 text-[0.92rem] leading-snug font-bold text-white">
                    {card.title}
                  </h4>
                  <div className="text-[0.72rem] text-white/90">{card.date}</div>
                </Link>
              </article>
            ))}
          </div>
        </div>
      </section>

      <SiteFooter />
    </>
  );
}
