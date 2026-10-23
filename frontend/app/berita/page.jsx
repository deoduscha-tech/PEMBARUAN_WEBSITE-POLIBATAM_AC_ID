import Link from 'next/link';
import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import Pagination from '@/components/Pagination';
import { apiGet } from '@/lib/api';
// Data berita di-cache 60 detik (ISR) supaya perpindahan halaman instan.
// Ubah ke `export const dynamic = 'force-dynamic';` kalau harus selalu segar.
export const revalidate = 60;

export const metadata = {
  title: 'Informasi — Pusat P2M Polibatam',
};

const PER_PAGE = 5;

export default async function BeritaIndexPage({ searchParams }) {
  const params = await searchParams;
  const page = Math.max(1, Number(params?.page ?? 1) || 1);
  const query = String(params?.q ?? '').trim();
  const response = await apiGet('/berita', {
    params: query ? { q: query, limit: 1000 } : { page, per_page: PER_PAGE },
  });

  if (!response.ok) {
    return (
      <Shell>
        <div className="wide-inner py-16">
          <div className="border-l-4 border-amber-500 bg-amber-50 px-5 py-4 text-[#7c4a03]">
            <p className="font-extrabold">Tidak dapat memuat informasi</p>
            <p className="mt-1 text-[0.9rem]">
              {response.error} — pastikan backend berjalan: <code>cd backend &amp;&amp; php artisan serve</code>
            </p>
          </div>
        </div>
      </Shell>
    );
  }

  const posts = response.data.data ?? [];
  const meta = response.data.meta ?? {};

  return (
    <Shell>
      <div className="wide-inner py-[18px]">
        {query && (
          <h1 className="mb-5 text-[clamp(1.8rem,3vw,2.5rem)] font-extrabold tracking-[-0.04em] text-[#111827]">
            Hasil pencarian: {query}
          </h1>
        )}

        <PostList posts={posts} />

        {!query && (
          <Pagination page={meta.page ?? page} lastPage={meta.last_page ?? 1} basePath="/berita" />
        )}
      </div>
    </Shell>
  );
}

function Shell({ children }) {
  return (
    <>
      <SiteHeader page="home" active="informasi" />
      <main id="main-content" className="bg-[#efefef] pb-6">{children}</main>
      <SiteFooter />
    </>
  );
}

function PostList({ posts }) {
  if (posts.length === 0) {
    return <p className="border border-[#d7dce4] bg-white p-6 text-center text-[0.9rem] text-[#8894a6]">Tidak ada informasi ditemukan.</p>;
  }

  return (
    <div className="flex flex-col">
      {posts.map((post) => (
        <article key={post.slug} className="article-post mb-[18px] flex flex-col gap-[18px] border md:flex-row">
          <Link
            href={`/berita/${post.slug}`}
            className="block min-h-[220px] w-full shrink-0 border bg-cover bg-center md:min-h-[280px] md:w-1/2"
            style={{ backgroundImage: `url('${post.image}')` }}
            aria-label={post.title}
          />
          <div className="flex min-w-0 flex-1 flex-col justify-center">
            <span className="category-chip w-fit">{String(post.category).toUpperCase()}</span>
            <h2 className="entry-title">
              <Link href={`/berita/${post.slug}`}>{post.title}</Link>
            </h2>
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
              Baca Selengkapnya <span aria-hidden="true">&rarr;</span>
            </Link>
          </div>
        </article>
      ))}
    </div>
  );
}
