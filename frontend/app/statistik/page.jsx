import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';
import { apiGet } from '@/lib/api';

export const metadata = {
  title: 'Statistik — Pusat P2M Polibatam',
  description: 'Grafik statistik penelitian, pengabdian, HKI, dan jabatan fungsional dosen Polibatam.',
};

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
  // Judul & jumlah pengunjung bisa disunting dari panel admin.
  const [response, halaman] = await Promise.all([apiGet('/statistik'), apiGet('/halaman/statistik')]);
  const statistik = response.ok ? response.data.data : null;
  const pageInfo = halaman.ok ? halaman.data.data : null;
  const charts = statistik?.charts ?? [];
  const chart = (key) => charts.find((item) => item.key === key);

  return (
    <>
      <SiteHeader page="home" active="statistik" />

      <main className="bg-[#efefef] pb-6">
        <h1 className="wide-inner py-6 text-[clamp(1.55rem,2.4vw,2.1rem)] font-black tracking-[-0.03em] text-[#101926] uppercase">
          {pageInfo?.heading ?? 'Statistik'}
        </h1>

        <div className="wide-inner mb-4 space-y-8 border-line bg-white p-5 md:p-8">
          {chart('internal') && <ChartFrame chart={chart('internal')} loading="eager" />}
          {chart('external') && <ChartFrame chart={chart('external')} />}
          {chart('hki') && <ChartFrame chart={chart('hki')} />}

          <div className="grid grid-cols-1 gap-5 lg:grid-cols-3">
            {['copyright', 'patent', 'industrialDesign'].map((key) => chart(key) && <ChartFrame key={key} chart={chart(key)} />)}
          </div>

          {chart('lecturer') && <ChartFrame chart={chart('lecturer')} />}

          <div className="grid grid-cols-1 gap-5 lg:grid-cols-2">
            {['electrical', 'informatics', 'business', 'mechanical'].map((key) => chart(key) && <ChartFrame key={key} chart={chart(key)} />)}
          </div>
        </div>

        <div className="wide-inner pb-6 text-[1.12rem] font-bold">
          Jumlah Pengunjung: {Number(pageInfo?.visitors ?? statistik?.visitors ?? 0).toLocaleString('en-US')}
        </div>

        <MissedSection />
      </main>

      <SiteFooter />
    </>
  );
}
