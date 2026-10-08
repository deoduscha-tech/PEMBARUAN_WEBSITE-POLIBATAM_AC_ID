import Link from 'next/link';
import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';
import { apiGet } from '@/lib/api';

export const metadata = {
  title: 'Publikasi — Pusat P2M Polibatam',
  description:
    'Luaran publikasi penelitian dan pengabdian kepada masyarakat Pusat P2M Politeknik Negeri Batam.',
};

// Selalu ambil data terbaru dari API Laravel.
export const dynamic = 'force-dynamic';

/** A, B, C, … untuk penomoran kelompok. */
function letter(index) {
  return String.fromCharCode(65 + index);
}

export default async function PublikasiPage({ searchParams }) {
  const params = await searchParams;
  const tahun = params?.tahun ?? null;

  const response = await apiGet('/publikasi', {
    params: tahun ? { tahun } : {},
  });

  if (!response.ok) {
    return (
      <Shell>
        <div className="wide-inner py-16">
          <div className="border-l-4 border-amber-500 bg-amber-50 px-5 py-4 text-[#7c4a03]">
            <p className="font-extrabold">Tidak dapat memuat data publikasi</p>
            <p className="mt-1 text-[0.9rem]">
              {response.error} — pastikan backend berjalan:{' '}
              <code>cd backend &amp;&amp; php artisan serve</code>
            </p>
          </div>
        </div>
      </Shell>
    );
  }

  const menu = response.data.data.menu ?? [];
  const active = response.data.data.active ?? { sections: [], label: '', year: '' };
  const sections = active.sections ?? [];

  return (
    <Shell>
      {/* Judul halaman mengikuti tahun yang dipilih, seperti situs aslinya. */}
      <div className="bg-[#efefef] pb-6">
        <h1 className="wide-inner py-6 text-[clamp(2rem,3.5vw,3rem)] font-black tracking-[-0.04em] text-[#101926] capitalize">
          {active.label?.toLowerCase() || `Tahun ${active.year}`}
        </h1>

        {/* Navigasi tahun — tombol sederhana, bukan sidebar. */}
        <div className="wide-inner mb-6 flex flex-wrap gap-2">
          {menu.map((year) => (
            <Link
              key={year.key}
              href={year.href}
              className={`rounded-full px-4 py-2 text-[0.78rem] font-bold tracking-[0.02em] uppercase transition-colors ${
                year.key === active.year
                  ? 'bg-[#1e6fd9] text-white'
                  : 'border border-[#c9d2de] bg-white text-[#3b4757] hover:bg-[#eaf1ff]'
              }`}
            >
              {year.label}
            </Link>
          ))}
        </div>

        <div className="wide-inner border-line bg-white p-8">
          <h2 className="mb-4 text-[clamp(1.5rem,2.4vw,2.1rem)] font-black tracking-[-0.03em] text-[#0b1d35]">
            Luaran Publikasi {active.label}
          </h2>

          {active.description && (
            <p className="mb-6 text-[1rem] leading-relaxed text-[#1f2937]">{active.description}</p>
          )}

          {sections.length === 0 ? (
            <p className="border border-dashed border-[#c9d2de] px-5 py-10 text-center text-[0.9rem] text-[#8894a6]">
              Belum ada data publikasi untuk tahun {active.year}.
            </p>
          ) : (
            <div className="flex flex-col gap-8">
              {sections.map((section, sectionIndex) => (
                <section key={section.title}>
                  {/* Judul kelompok: A. Jurnal Internasional Bereputasi */}
                  <h3 className="mb-3 text-[1.05rem] font-extrabold text-[#0b1d35]">
                    {letter(sectionIndex)}. {section.title}
                  </h3>

                  <ol className="flex flex-col gap-3">
                    {(section.items ?? []).map((item, itemIndex) => (
                      <li key={itemIndex} className="flex gap-3 text-[0.92rem] leading-relaxed">
                        <span className="mt-[2px] w-[22px] shrink-0 font-bold text-[#5b6675]">
                          {itemIndex + 1}.
                        </span>
                        <span className="text-[#1f2937]">
                          {item.authors && (
                            <span className="font-semibold text-[#0b1d35]">{item.authors}. </span>
                          )}
                          {item.title && <span className="italic">{item.title}</span>}
                          {item.venue && <span>. {item.venue}</span>}
                          {item.year && <span>, {item.year}</span>}
                          {item.note && <span>. {item.note}</span>}
                        </span>
                      </li>
                    ))}
                  </ol>
                </section>
              ))}
            </div>
          )}

          {active.note && (
            <p className="mt-8 border-t border-[#e6eaf0] pt-5 text-[0.9rem] italic text-[#5b6675]">
              {active.note}
            </p>
          )}
        </div>

        <div className="wide-inner pt-6 text-[1.12rem] font-bold">
          Jumlah Pengunjung: {Number(active.visitors ?? 0).toLocaleString('en-US')}
        </div>

        <MissedSection />
      </div>
    </Shell>
  );
}

function Shell({ children }) {
  return (
    <>
      <SiteHeader page="home" active="publikasi" />
      <main>{children}</main>
      <SiteFooter />
    </>
  );
}
