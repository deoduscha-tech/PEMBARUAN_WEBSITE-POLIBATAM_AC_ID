import Link from 'next/link';
import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';

/**
 * VIEW — layout bersama untuk halaman Penelitian & Pengabdian.
 *
 * Keduanya memakai susunan yang sama (angka capaian → skema → dokumen →
 * berita terbaru). Yang berbeda hanya judul, teks, dan daftar skemanya.
 */
export default function RisetPage({ heading, intro = [], schemes = [], documents = [] }) {
  const stats = [
    { value: '99', label: 'Publikasi Internasional' },
    { value: '163', label: 'Pendaftaran HKI' },
    { value: '79', label: 'Luaran PBL untuk Industri' },
    { value: '29', label: 'Kegiatan Pengabdian' },
  ];

  return (
    <>
      <SiteHeader page="home" />

      <main className="bg-[#efefef] pb-6">
        <h1 className="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">
          {heading}
        </h1>

        {/* Pengantar */}
        {intro.length > 0 && (
          <div className="wide-inner mb-6 border-line bg-[#f3f3f3] p-6 rich-copy">
            {intro.map((text, index) => (
              <p key={index}>{text}</p>
            ))}
          </div>
        )}

        {/* Angka capaian P3M */}
        <section className="wide-inner mb-6">
          <div className="grid gap-[18px] sm:grid-cols-2 xl:grid-cols-4">
            {stats.map((stat) => (
              <div
                key={stat.label}
                className="border border-[#d7dce4] bg-white px-5 py-6 text-center"
              >
                <p className="text-[clamp(1.8rem,3vw,2.4rem)] leading-none font-black tracking-[-0.04em] text-[#1e6fd9]">
                  {stat.value}
                </p>
                <p className="mt-2 text-[0.78rem] leading-snug font-bold tracking-[0.02em] text-[#5b6675] uppercase">
                  {stat.label}
                </p>
              </div>
            ))}
          </div>
        </section>

        {/* Skema & pendanaan */}
        {schemes.length > 0 && (
          <section className="wide-inner mb-6">
            <div className="mb-[18px] flex items-end border-b-2 border-line">
              <span className="section-label">Skema &amp; Pendanaan</span>
            </div>

            <div className="grid gap-[18px] md:grid-cols-2 xl:grid-cols-3">
              {schemes.map((scheme) => (
                <article key={scheme.title} className="border border-[#d7dce4] bg-white p-5">
                  <h3 className="text-[1rem] leading-snug font-extrabold text-[#0b1d35]">
                    {scheme.title}
                  </h3>
                  <p className="mt-2 text-[0.88rem] leading-relaxed text-[#5b6675]">
                    {scheme.description}
                  </p>
                  {scheme.focus?.length > 0 && (
                    <ul className="mt-3 flex flex-col gap-1.5 text-[0.85rem] text-[#5b6675]">
                      {scheme.focus.map((item) => (
                        <li key={item} className="flex gap-2">
                          <span className="text-[#1e6fd9]" aria-hidden="true">
                            &rsaquo;
                          </span>
                          {item}
                        </li>
                      ))}
                    </ul>
                  )}
                </article>
              ))}
            </div>
          </section>
        )}

        {/* Dokumen unduhan */}
        {documents.length > 0 && (
          <section className="wide-inner mb-6">
            <div className="mb-[18px] flex items-end border-b-2 border-line">
              <span className="section-label">Panduan &amp; Unduhan</span>
            </div>

            <div className="flex flex-col gap-3">
              {documents.map((doc) => (
                <div
                  key={doc.title}
                  className="flex flex-col items-start gap-3 border border-[#d7dce4] bg-white px-5 py-4 sm:flex-row sm:items-center"
                >
                  <span className="grid size-10 shrink-0 place-items-center rounded bg-[#1d2432] text-[0.8rem] font-black text-white">
                    PDF
                  </span>

                  <div className="min-w-0 flex-1">
                    <p className="text-[0.95rem] font-extrabold text-[#0b1d35]">{doc.title}</p>
                    <p className="text-[0.8rem] text-[#6b7787]">{doc.description}</p>
                  </div>

                  {doc.href ? (
                    <a
                      href={doc.href}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="inline-flex shrink-0 items-center gap-2 rounded bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] px-4 py-2.5 text-[0.72rem] font-extrabold tracking-[0.03em] text-white uppercase transition-transform hover:-translate-y-px"
                    >
                      Unduh
                    </a>
                  ) : (
                    <span
                      className="inline-flex shrink-0 cursor-not-allowed items-center gap-2 rounded border border-dashed border-[#a9b3c1] bg-[#e8ebf0] px-4 py-2.5 text-[0.72rem] font-extrabold tracking-[0.03em] text-[#6b7787] uppercase"
                      title="Dokumen belum tersedia"
                    >
                      Unduh
                    </span>
                  )}
                </div>
              ))}
            </div>
          </section>
        )}

        {/* Berita terbaru — datanya diambil dari API Laravel */}
        <MissedSection />
      </main>

      <SiteFooter />
    </>
  );
}