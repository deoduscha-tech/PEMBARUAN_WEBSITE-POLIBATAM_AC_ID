import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';
import { apiGet } from '@/lib/api';

// Data berita di-cache 60 detik (ISR) supaya perpindahan halaman instan.
// Ubah ke `export const dynamic = 'force-dynamic';` kalau harus selalu segar.
export const revalidate = 60;

export const metadata = {
  title: 'Statistik - Pusat P2M Polibatam',
  description: 'Grafik statistik penelitian, pengabdian, HKI, dan jabatan fungsional dosen Polibatam.',
};

// Grafik + jumlah pengunjung diambil dari API Laravel (/api/halaman/statistik)
// sehingga tidak ada lagi angka/susunan grafik yang berbeda dengan backend.
function ChartFrame({ chart, loading = 'lazy' }) {
  return (
    <iframe
      title={chart.title}
      aria-label="Grafik interaktif"
      src={`https://datawrapper.dwcdn.net/${chart.id}/${chart.version}/`}
      width={chart.width}
      height={chart.height}
      loading={loading}
      scrolling="no"
      frameBorder="0"
      data-external="1"
      className="block w-full border-0"
      style={{ maxWidth: `${chart.width}px`, height: `${chart.height}px` }}
    />
  );
}

export default async function StatistikPage() {
  const response = await apiGet('/halaman/statistik');
  const data = response.ok ? response.data.data : null;
  const charts = data?.charts ?? [];

  const internal = charts.filter((chart) => chart.key === 'internal');
  const external = charts.filter((chart) => chart.key === 'external');
  const hki = charts.filter((chart) => chart.key === 'hki');
  const hkiDetail = charts.filter((chart) => chart.group === 'hki-detail');
  const lecturer = charts.filter((chart) => chart.key === 'lecturer');
  const prodi = charts.filter((chart) => chart.group === 'prodi');

  return (
    <>
      <SiteHeader page="home" active="statistik" />

      <main className="bg-[#efefef] pb-6">
        <h1 className="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">
          {data?.heading ?? 'Statistik'}
        </h1>

        <div className="wide-inner mb-4 space-y-8 border-line bg-white p-5 md:p-8">
          {!data && (
            <p>
              Grafik statistik belum dapat dimuat
              {response.error ? ` (${response.error})` : ''}. Pastikan backend Laravel berjalan.
            </p>
          )}

          {internal.map((chart) => (
            <ChartFrame key={chart.key} chart={chart} loading="eager" />
          ))}
          {external.map((chart) => (
            <ChartFrame key={chart.key} chart={chart} />
          ))}
          {hki.map((chart) => (
            <ChartFrame key={chart.key} chart={chart} />
          ))}

          {hkiDetail.length > 0 && (
            <div className="grid grid-cols-1 gap-5 lg:grid-cols-3">
              {hkiDetail.map((chart) => (
                <ChartFrame key={chart.key} chart={chart} />
              ))}
            </div>
          )}

          {lecturer.map((chart) => (
            <ChartFrame key={chart.key} chart={chart} />
          ))}

          {prodi.length > 0 && (
            <div className="grid grid-cols-1 gap-5 lg:grid-cols-2">
              {prodi.map((chart) => (
                <ChartFrame key={chart.key} chart={chart} />
              ))}
            </div>
          )}
        </div>

        <div className="wide-inner pb-6 text-[1.12rem] font-bold">
          Jumlah Pengunjung: {Number(data?.visitors ?? 0).toLocaleString('en-US')}
        </div>

        <MissedSection />
      </main>

      <SiteFooter />
    </>
  );
}
