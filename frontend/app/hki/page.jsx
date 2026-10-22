import Link from 'next/link';
import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';
import { apiGet } from '@/lib/api';

export const metadata = { title: 'HKI — Pusat P2M Polibatam' };

export default async function HkiPage() {
  const response = await apiGet('/hki');
  const menu = response.ok ? response.data?.data?.menu ?? [] : [];
  const content = response.ok ? response.data?.data?.content : null;
  const visitors = response.ok ? response.data?.data?.views ?? 8490 : null;

  return (
    <>
      <SiteHeader page="home" active="hki" />
      <main className="bg-[#efefef] pb-6">
        <h1 className="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">HKI</h1>

        <div className="wide-inner mb-4 border border-line bg-white p-6 rich-copy">
          {content ? <div dangerouslySetInnerHTML={{ __html: content }} /> : (
            <>
              <p>Hak Kekayaan Intelektual (HKI) merupakan bagian dari komitmen Polibatam University Berdampak dalam mendorong lahirnya karya intelektual yang terlindungi dan bermanfaat bagi masyarakat serta industri.</p>
              <ul>
                <li>Perlindungan inovasi produk dan teknologi</li>
                <li>Pengembangan karya riset yang aplikatif</li>
                <li>Dukungan komersialisasi hasil penelitian</li>
                <li>Kolaborasi dengan industri dan mitra strategis</li>
              </ul>
            </>
          )}
        </div>

        <div className="wide-inner mb-4">
          <div className="mb-[18px] flex items-end border-b-2 border-line"><span className="section-label">Pilih Tahun</span></div>
          <div className="flex flex-wrap gap-2">
            <Link href="/hki/pendaftaran" className="rounded-full border border-[#c9d2de] bg-white px-4 py-2 text-[0.78rem] font-bold tracking-[0.02em] text-[#3b4757] uppercase transition-colors hover:bg-[#eaf1ff]">Pendaftaran HKI</Link>
            {menu.map((year) => (
              <Link key={year.key} href={year.href} className="rounded-full border border-[#c9d2de] bg-white px-4 py-2 text-[0.78rem] font-bold tracking-[0.02em] text-[#3b4757] uppercase transition-colors hover:bg-[#eaf1ff]">{year.label}</Link>
            ))}
          </div>
        </div>

        {visitors !== null && <div className="wide-inner mb-4"><div className="border border-line bg-white p-5 text-[1.12rem] font-bold text-[#0b1d35]">Jumlah Pengunjung: {Number(visitors).toLocaleString('en-US')}</div></div>}
        <MissedSection />
      </main>
      <SiteFooter />
    </>
  );
}
