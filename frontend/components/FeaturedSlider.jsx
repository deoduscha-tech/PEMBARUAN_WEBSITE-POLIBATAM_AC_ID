'use client';

import { useState } from 'react';
import Link from 'next/link';

/**
 * VIEW (client) — slider unggulan.
 *
 * Butuh state (slide aktif), karena itu komponen client. Datanya dikirim
 * dari Server Component lewat props, jadi tidak ada fetch di sini.
 */
export default function FeaturedSlider({ slides = [] }) {
  const [active, setActive] = useState(0);

  if (slides.length === 0) return null;

  const go = (next) => setActive((next + slides.length) % slides.length);

  return (
    <div className="relative min-h-[480px] overflow-hidden border-navy-dark/10 bg-[#eef2f7] shadow-card">
      <div
        className="feature-track"
        style={{ transform: `translateX(-${active * 100}%)` }}
      >
        {slides.map((slide) => (
          <article key={slide.slug} className="feature-slide">
            <div className="feature-image" style={{ backgroundImage: `url('${slide.image}')` }}>
              <div className="feature-content">
                <span className="feature-category">{slide.category}</span>
                <h4 className="feature-title">
                  <Link href={`/berita/${slide.slug}`}>{slide.title}</Link>
                </h4>
                <div className="feature-meta">
                  <span>{slide.date}</span>
                  <span className="dot" aria-hidden="true" />
                  <span>{slide.author}</span>
                </div>
              </div>
            </div>
          </article>
        ))}
      </div>

      {slides.length > 1 && (
        <>
          <div className="absolute bottom-5 left-1/2 z-10 flex -translate-x-1/2 gap-2">
            {slides.map((slide, index) => (
              <button
                key={slide.slug}
                type="button"
                onClick={() => go(index)}
                aria-label={`Tampilkan slide ${index + 1}`}
                aria-current={active === index ? 'true' : undefined}
                className={`grid size-8 place-items-center rounded-full text-sm font-bold shadow ${active === index ? 'bg-white text-[#0e5ebf]' : 'bg-black/45 text-white hover:bg-black/65'}`}
              >
                {index + 1}
              </button>
            ))}
          </div>
          <button
            type="button"
            onClick={() => go(active - 1)}
            className="feature-nav prev"
            aria-label="Slide sebelumnya"
          >
            &#8249;
          </button>
          <button
            type="button"
            onClick={() => go(active + 1)}
            className="feature-nav next"
            aria-label="Slide berikutnya"
          >
            &#8250;
          </button>
        </>
      )}
    </div>
  );
}
