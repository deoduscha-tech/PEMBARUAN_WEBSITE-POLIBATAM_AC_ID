import Link from 'next/link';
import { notFound } from 'next/navigation';
import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import { apiGet } from '@/lib/api';

export async function generateMetadata({ params }) {
  const { slug } = await params;
  const response = await apiGet(`/berita/${slug}`);
  const post = response.ok ? response.data.data : null;

  return { title: post ? `${post.title} — Pusat P2M Polibatam` : 'Berita tidak ditemukan' };
}

export default async function BeritaDetailPage({ params }) {
  const { slug } = await params;

  // Data diambil dari API Laravel. Penghitungan view dikerjakan backend saat
  // permintaan ini masuk (NewsApiController::show).
  const response = await apiGet(`/berita/${slug}`);

  if (!response.ok) {
    notFound();
  }

  const post = response.data.data;
  const related = response.data.related ?? [];

  if (!post || post.published === false) {
    notFound();
  }

  return (
    <>
      <SiteHeader page="home" />

      <main className="bg-[#efefef] pb-6">
        <div className="wide-inner py-6">
          <article className="border-line bg-white p-8">
            <span className="category-chip">{String(post.category).toUpperCase()}</span>

            <h1 className="mt-3 mb-3 text-[clamp(1.7rem,3vw,2.4rem)] leading-tight font-black tracking-[-0.03em] text-[#0b1d35]">
              {post.title}
            </h1>

            <div className="mb-6 flex flex-wrap items-center gap-2.5 border-b border-[#e6eaf0] pb-4 text-[0.8rem] font-bold text-[#6b7787]">
              <span>{post.date}</span>
              <span aria-hidden="true">&middot;</span>
              <span>{post.author}</span>
              <span aria-hidden="true">&middot;</span>
              <span>{post.views ?? 0} kali dibaca</span>
            </div>

            {post.image && (
              <div
                className="mb-6 min-h-[320px] bg-cover bg-center"
                style={{ backgroundImage: `url('${post.image}')` }}
                role="img"
                aria-label={post.title}
              />
            )}

            <div
              className="rich-copy text-[1.02rem] leading-[1.85] text-[#1f2937]"
              dangerouslySetInnerHTML={{ __html: post.body ?? '' }}
            />
          </article>
        </div>

        {related.length > 0 && (
          <section className="wide-inner pb-6">
            <div className="mb-[18px] flex items-end border-b-2 border-line">
              <span className="section-label">Berita Terkait</span>
            </div>
            <div className="grid gap-[18px] sm:grid-cols-2 xl:grid-cols-3">
              {related.map((item) => (
                <article
                  key={item.slug}
                  className="flex min-h-[210px] items-end bg-cover bg-center"
                  style={{ backgroundImage: `url('${item.image}')` }}
                >
                  <Link
                    href={`/berita/${item.slug}`}
                    className="block w-full bg-gradient-to-t from-[#081d35]/92 to-[#081d35]/10 p-4"
                  >
                    <span className="category-chip">
                      {String(item.category).toUpperCase()}
                    </span>
                    <h4 className="mt-1.5 mb-2 line-clamp-3 text-[0.92rem] leading-snug font-bold text-white">
                      {item.title}
                    </h4>
                    <div className="text-[0.72rem] text-white/90">{item.date}</div>
                  </Link>
                </article>
              ))}
            </div>
          </section>
        )}
      </main>

      <SiteFooter />
    </>
  );
}