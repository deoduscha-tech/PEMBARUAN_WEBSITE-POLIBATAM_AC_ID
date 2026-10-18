import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';

export const metadata = {
  title: 'Statistik — Pusat P2M Polibatam',
  description: 'Grafik statistik penelitian, pengabdian, HKI, dan jabatan fungsional dosen Polibatam.',
};

const CHARTS = {
  internal: {
    title: 'Penelitian dan Pengabdian Internal',
    id: 'R7LDv',
    version: 3,
    height: 414,
    width: 970,
  },
  external: {
    title: 'Penelitian dan Pengabdian Eksternal',
    id: 'T8EQF',
    version: 2,
    height: 414,
    width: 600,
  },
  hki: {
    title: 'HKI (Hak Kekayaan Intelektual) Polibatam 2017-2024',
    id: 'd5xu9',
    version: 2,
    height: 361,
    width: 600,
  },
  copyright: {
    title: 'Hak Cipta',
    id: 'wFoOi',
    version: 5,
    height: 361,
    width: 600,
  },
  patent: {
    title: 'Paten/ Paten Sederhana 2017-2024',
    id: 'dLDrv',
    version: 1,
    height: 361,
    width: 600,
  },
  industrialDesign: {
    title: 'Desain Industri',
    id: 'fkF82',
    version: 1,
    height: 361,
    width: 600,
  },
  lecturer: {
    title: 'Jabatan Fungsional Dosen Polibatam (24 Feb 2025)',
    id: 'PN2h5',
    version: 1,
    height: 237,
    width: 600,
  },
  electrical: {
    title: 'Jabatan Fungsional Dosen Teknik Elektro',
    id: 'F77g5',
    version: 2,
    height: 237,
    width: 600,
  },
  informatics: {
    title: 'Jabatan Fungsional Dosen Teknik Informatika',
    id: 'NOaHv',
    version: 1,
    height: 237,
    width: 600,
  },
  business: {
    title: 'Jabatan Fungsional Dosen Manajemen Bisnis',
    id: '4reGJ',
    version: 1,
    height: 237,
    width: 600,
  },
  mechanical: {
    title: 'Jabatan Fungsional Dosen Teknik Mesin',
    id: 'F4ffL',
    version: 1,
    height: 237,
    width: 600,
  },
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

export default function StatistikPage() {
  return (
    <>
      <SiteHeader page="home" active="statistik" />

      <main className="bg-[#efefef] pb-6">
        <h1 className="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">
          Statistik
        </h1>

        <div className="wide-inner mb-4 space-y-8 border-line bg-white p-5 md:p-8">
          <ChartFrame chart={CHARTS.internal} loading="eager" />
          <ChartFrame chart={CHARTS.external} />
          <ChartFrame chart={CHARTS.hki} />

          <div className="grid grid-cols-1 gap-5 lg:grid-cols-3">
            <ChartFrame chart={CHARTS.copyright} />
            <ChartFrame chart={CHARTS.patent} />
            <ChartFrame chart={CHARTS.industrialDesign} />
          </div>

          <ChartFrame chart={CHARTS.lecturer} />

          <div className="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <ChartFrame chart={CHARTS.electrical} />
            <ChartFrame chart={CHARTS.informatics} />
            <ChartFrame chart={CHARTS.business} />
            <ChartFrame chart={CHARTS.mechanical} />
          </div>
        </div>

        <div className="wide-inner pb-6 text-[1.12rem] font-bold">
          Jumlah Pengunjung: 2,702
        </div>

        <MissedSection />
      </main>

      <SiteFooter />
    </>
  );
}
