import Link from 'next/link';
import { apiGet } from '@/lib/api';

/**
 * VIEW — bagian "You missed" yang mengambil data dari API Laravel.
 *
 * Beberapa halaman memakai bagian ini. Daripada tiap halaman memanggil API
 * sendiri, komponen ini yang mengambil datanya (Server Component).
 */
export default async function MissedSection({ title = 'You missed' }) {
  const response = await apiGet('/berita', { params: { limit: 4 } });
  const cards = response.ok ? (response.data.data ?? []) : [];

  if (cards.length === 0) return null;

  return (
    <section className="wide-inner pb-6">
      <div className="mb-[18px] flex items-end border-b-2 border-line">
        <span className="section-label">{title}</span>
      </div>

      <div className="grid gap-[18px] sm:grid-cols-2 xl:grid-cols-4">
        {cards.map((card) => (
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
              <span className="category-chip">{String(card.category).toUpperCase()}</span>
              <h4 className="mt-1.5 mb-2 line-clamp-3 text-[0.92rem] leading-snug font-bold text-white">
                {card.title}
              </h4>
              <div className="text-[0.72rem] text-white/90">{card.date}</div>
            </Link>
          </article>
        ))}
      </div>
    </section>
  );
}