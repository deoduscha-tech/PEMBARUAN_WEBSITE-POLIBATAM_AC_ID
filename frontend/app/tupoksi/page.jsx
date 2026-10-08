import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';
import { apiGet } from '@/lib/api';

export const metadata = {
  title: 'Tupoksi — Pusat P2M Polibatam',
  description:
    'Tugas pokok dan fungsi Pusat Penelitian dan Pengabdian Masyarakat (Pusat P2M) Politeknik Negeri Batam.',
};

// Selalu ambil data terbaru dari API Laravel.
export const dynamic = 'force-dynamic';

export default async function TupoksiPage() {
  const response = await apiGet('/tupoksi');
  const data = response.ok ? response.data.data : null;

  if (!data) {
    return (
      <Shell>
        <div className="wide-inner py-16">
          <div className="border-l-4 border-amber-500 bg-amber-50 px-5 py-4 text-[#7c4a03]">
            <p className="font-extrabold">Tidak dapat memuat data tupoksi</p>
            <p className="mt-1 text-[0.9rem]">
              {response.error ?? 'Data tupoksi belum tersedia.'} — pastikan backend berjalan:{' '}
              <code>cd backend &amp;&amp; php artisan serve</code>
            </p>
          </div>
        </div>
      </Shell>
    );
  }

  const duties = data.duties ?? {};
  const authorities = data.authorities ?? {};

  return (
    <Shell>
      <div className="wide-inner py-6">
        <div className="border-line bg-white p-8">
          <h1 className="mb-6 text-[clamp(1.9rem,3vw,2.6rem)] font-black tracking-[-0.03em] text-[#0b1d35]">
            {data.heading ?? 'Tupoksi'}
          </h1>

          <div className="rich-copy text-[1.02rem] leading-[1.85] text-[#1f2937]">
            {(data.intro ?? []).map((paragraph, index) => (
              <p key={index}>{paragraph}</p>
            ))}

            {/* Tugas dan tanggung jawab */}
            {duties.title && <p>{duties.title}</p>}

            <ul className="mb-6">
              {(duties.items ?? []).map((item, index) => (
                <li key={index}>{item}</li>
              ))}
            </ul>

            {/* Kewenangan */}
            {authorities.title && <p>{authorities.title}</p>}

            <ul className="mb-2">
              {(authorities.items ?? []).map((item, index) => (
                <li key={index}>{item}</li>
              ))}
            </ul>
          </div>
        </div>
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
      <SiteHeader page="home" active="tupoksi" />
      <main className="bg-[#efefef] pb-6">{children}</main>
      <SiteFooter />
    </>
  );
}
