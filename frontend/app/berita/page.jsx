import Link from 'next/link';
import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import Pagination from '@/components/Pagination';
import { apiGet } from '@/lib/api';

export const metadata = {
  title: 'Berita — Pusat P2M Polibatam',
};

const PER_PAGE = 6;

export default async function BeritaIndexPage({ searchParams }) {
  const params = await searchParams;

  const page = Math.max(1, Number(params?.page ?? 1));
  const query = params?.q ?? '';
  const category = params?.kategori ?? '';

  // Data diambil dari API Laravel.
  const response = await apiGet('/berita', {
    params: query
      ? { q: query }
      : { page, per_page: PER_PAGE, category: category || null },
  });

  if (!response.ok) {
    return (
      <Shell>
        <div className="wide-inner py-16">
          <div className="border-l-4 border-amber-500 bg-amber-50 px-5 py-4 text-[#7c4a03]">
            <p className="font-extrabold">Tidak dapat memuat berita</p>
            <p className="mt-1 text-[0.9rem]">
              {response.error} — pastikan backend berjalan:{' '}
              <code>cd backend &amp;&amp; php artisan serve</code>
            </p>
          </div>
        </div>
      </Shell>
    );
  }

  const apiItems = response.data.data ?? [];
  const apiMeta = response.data.meta ?? {};
  const apiCategories = apiMeta.categories ?? [];

  // Kalau ada pencarian, tampilkan hasilnya tanpa pagination.
  if (query) {
    return (
      <Shell>
        <h1 className="wide-inner py-6 text-[clamp(2rem,3.5vw,3rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">
          HASIL PENCARIAN
        </h1>
        <div className="wide-inner pb-6">
          <p className="mb-5 text-[0.95rem] text-[#5b6675]">
            {apiItems.length} hasil untuk <strong>&ldquo;{query}&rdquo;</strong>
          </p>
          <PostList posts={apiItems} />
        </div>
      </Shell>
    );
  }

  const items = apiItems;
  const meta = {
    page: apiMeta.page ?? page,
    lastPage: apiMeta.last_page ?? 1,
    total: apiMeta.total ?? apiItems.length,
  };

  const categories = apiCategories;

  return (
    <Shell>
      <h1 className="wide-inner py-6 text-[clamp(2rem,3.5vw,3rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">
        BERITA
      </h1>

      {/* Filter kategori */}
      <div className="wide-inner mb-5 flex flex-wrap items-center gap-2">
        <Link
          href="/berita"
          className={`rounded-full px-3.5 py-1.5 text-[0.75rem] font-bold uppercase transition-colors ${!category
              ? 'bg-[#1e6fd9] text-white'
              : 'border border-[#c9d2de] text-[#3b4757] hover:bg-[#eaf1ff]'
            }`}
        >
          Semua
        </Link>
        {categories.map((item) => (
          <Link
            key={item}
            href={`/berita?kategori=${encodeURIComponent(item)}`}
            className={`rounded-full px-3.5 py-1.5 text-[0.75rem] font-bold uppercase transition-colors ${category === item
                ? 'bg-[#1e6fd9] text-white'
                : 'border border-[#c9d2de] text-[#3b4757] hover:bg-[#eaf1ff]'
              }`}
          >
            {item}
          </Link>
        ))}
      </div>

      <div className="wide-inner pb-6">
        <p className="mb-4 text-[0.85rem] text-[#5b6675]">
          Menampilkan {items.length} dari {meta.total} berita
        </p>

        <PostList posts={items} />

        <Pagination page={meta.page} lastPage={meta.lastPage} basePath="/berita" />
      </div>
    </Shell>
  );
}

function Shell({ children }) {
  return (
    <>
      <SiteHeader page="home" />
      <main className="bg-[#efefef] pb-6">{children}</main>
      <SiteFooter />
    </>
  );
}

function PostList({ posts }) {
  if (posts.length === 0) {
    return (
      <p className="rounded border border-[#d7dce4] bg-white p-6 text-center text-[0.9rem] text-[#8894a6]">
        Tidak ada berita ditemukan.
      </p>
    );
  }

  return (
    <div className="flex flex-col gap-[18px]">
      {posts.map((post) => (
        <article key={post.slug} className="flex gap-[18px] border border-[#e2e6ec] bg-white">
          <Link
            href={`/berita/${post.slug}`}
            className="block min-h-[180px] w-[280px] shrink-0 bg-cover bg-center"
            style={{ backgroundImage: `url('${post.image}')` }}
            aria-label={post.title}
          />
          <div className="flex min-w-0 flex-1 flex-col justify-center py-4 pr-5">
            <span className="category-chip w-fit">
              {String(post.category).toUpperCase()}
            </span>
            <h3 className="mt-2 text-[1.25rem] leading-snug font-extrabold text-[#0b1d35]">
              <Link href={`/berita/${post.slug}`}>{post.title}</Link>
            </h3>
            <div className="mt-1.5 flex flex-wrap items-center gap-2.5 text-[0.76rem] font-bold text-[#6b7787]">
              <span>{post.date}</span>
              <span aria-hidden="true">&middot;</span>
              <span>{post.author}</span>
              <span aria-hidden="true">&middot;</span>
              <span>{post.views ?? 0} dibaca</span>
            </div>
            <p className="mt-2 text-[0.92rem] leading-relaxed text-[#5b6675]">{post.excerpt}</p>
            <Link
              href={`/berita/${post.slug}`}
              className="mt-2.5 w-fit text-[0.8rem] font-bold text-[#1e6fd9] hover:underline"
            >
              Baca Selengkapnya &rarr;
            </Link>
          </div>
        </article>
      ))}
    </div>
  );
}