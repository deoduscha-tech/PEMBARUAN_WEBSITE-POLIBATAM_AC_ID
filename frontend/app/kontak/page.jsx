import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';
import { apiGet } from '@/lib/api';

export const metadata = {
  title: 'Kontak P3M — Pusat P2M Polibatam',
  description:
    'Kontak dan lokasi Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam.',
};

// Selalu ambil data terbaru dari API Laravel.
export const dynamic = 'force-dynamic';

export default async function KontakPage() {
  const response = await apiGet('/kontak');
  const data = response.ok ? response.data.data : null;

  if (!data) {
    return (
      <Shell>
        <div className="wide-inner py-16">
          <div className="border-l-4 border-amber-500 bg-amber-50 px-5 py-4 text-[#7c4a03]">
            <p className="font-extrabold">Tidak dapat memuat data kontak</p>
            <p className="mt-1 text-[0.9rem]">
              {response.error ?? 'Data kontak belum tersedia.'} — pastikan backend berjalan:{' '}
              <code>cd backend &amp;&amp; php artisan serve</code>
            </p>
          </div>
        </div>
      </Shell>
    );
  }

  const person = data.contact_person ?? {};
  const address = data.address ?? {};
  const map = data.map ?? {};

  return (
    <Shell>
      {/* Judul halaman */}
      <h1 className="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">
        {data.heading ?? 'KONTAK P3M'}
      </h1>

      <div className="wide-inner mb-4 border-line bg-white p-8">
        {/* Kontak */}
        <h2 className="mb-4 text-[clamp(1.4rem,2.4vw,2rem)] font-black tracking-[-0.03em] text-[#0b1d35]">
          {data.section_title ?? 'Kontak'}
        </h2>

        <p className="text-[1rem] leading-relaxed text-[#1f2937]">
          {person.role ?? 'Kepala P3M Polibatam'}:{' '}
          <span className="font-bold text-[#0b1d35]">{person.name}</span>
        </p>

        {person.emails?.length > 0 && (
          <p className="mt-3 flex flex-wrap items-center gap-x-2 text-[1rem] text-[#1f2937]">
            <span>Email:</span>
            {person.emails.map((email, index) => (
              <span key={email} className="flex items-center gap-x-2">
                <a
                  href={`mailto:${email}`}
                  className="font-semibold text-[#1e6fd9] underline decoration-[#1e6fd9]/50 underline-offset-2 transition-colors hover:text-[#0d4ca8]"
                >
                  {email}
                </a>
                {index < person.emails.length - 1 && <span>atau</span>}
              </span>
            ))}
          </p>
        )}

        {/* Alamat */}
        <h2 className="mt-10 mb-4 text-[clamp(1.4rem,2.4vw,2rem)] font-black tracking-[-0.03em] text-[#0b1d35]">
          {address.label ?? 'Alamat'}
        </h2>

        <p className="text-[1rem] leading-relaxed text-[#1f2937]">{address.lines}</p>

        {/* Peta lokasi */}
        {map.embed && (
          <div className="mt-8">
            <div className="relative overflow-hidden border border-[#d7dce4]">
              <iframe
                src={map.embed}
                title={`Peta lokasi ${map.title ?? 'Pusat P2M Polibatam'}`}
                className="w-full border-0"
                style={{ height: `${map.height ?? 520}px` }}
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                allowFullScreen
              />

              {/* Tombol di dalam peta, seperti situs aslinya. */}
              {map.link && (
                <a
                  href={map.link}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="absolute top-3 left-3 inline-flex items-center gap-2 rounded-sm bg-[#1a73e8] px-3.5 py-2.5 text-[0.8rem] font-bold text-white shadow-[0_2px_6px_rgba(0,0,0,0.3)] transition-colors hover:bg-[#1666d0]"
                >
                  <svg
                    className="size-[15px]"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    aria-hidden="true"
                  >
                    <path d="M12 2 4.5 20l7.5-4 7.5 4z" />
                  </svg>
                  Buka di Maps
                </a>
              )}
            </div>
          </div>
        )}
      </div>

      <div className="wide-inner pb-6 text-[1.12rem] font-bold">
        Jumlah Pengunjung: {Number(data.visitors ?? 0).toLocaleString('en-US')}
      </div>

      <MissedSection />
    </Shell>
  );
}

function Shell({ children }) {
  return (
    <>
      <SiteHeader page="home" active="kontak" />
      <main className="bg-[#efefef] pb-6">{children}</main>
      <SiteFooter />
    </>
  );
}
