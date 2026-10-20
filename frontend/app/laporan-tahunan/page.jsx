import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';
import { apiGet } from '@/lib/api';

// Data berita di-cache 60 detik (ISR) supaya perpindahan halaman instan.
// Ubah ke `export const dynamic = 'force-dynamic';` kalau harus selalu segar.
export const revalidate = 60;

export const metadata = {
  title: 'Laporan Tahunan P3M 2025 - Pusat P2M Polibatam',
};

/**
 * VIEW — halaman Laporan Tahunan.
 *
 * Teks, tahun, jumlah pengunjung, dan tautan PDF diambil dari API Laravel
 * (/api/laporan-tahunan) sehingga sama persis dengan versi backend dan bisa
 * diubah tanpa menyentuh frontend.
 */
export default async function LaporanTahunanPage() {
  const response = await apiGet('/laporan-tahunan');
  const data = response.ok ? response.data : {};

  const reportYear = data.reportYear ?? '2025';
  const paragraphs = data.paragraphs ?? [];

  // reportFile null selama PDF belum diunggah — jangan tampilkan tautan rusak.
  const reportFile = data.reportFile ?? null;

  return (
    <>
      <SiteHeader page="home" />

      <main className="bg-[#efefef] pb-6">
        <div className="wide-inner mb-4 border-line bg-white p-8">
          <h1 className="mb-[18px] text-[clamp(1.9rem,3vw,2.6rem)] font-black tracking-[0.02em] text-[#0b1d35] uppercase">
            {data.title ?? `LAPORAN TAHUNAN P3M TAHUN ${reportYear}`}
          </h1>

          <div className="rich-copy text-[1.05rem] leading-[1.9] text-[#1f2937]">
            {paragraphs.map((text, index) => (
              <p key={index}>{text}</p>
            ))}

            <p>
              Unduh Laporan Tahunan Penelitian dan Pengabdian kepada Masyarakat Tahun{' '}
              {reportYear} (PDF):{' '}
              {reportFile ? (
                <a
                  href={reportFile}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="font-bold text-[#1e6fd9] underline decoration-[#1e6fd9]/40 underline-offset-2 transition-colors hover:text-[#0d4ca8]"
                >
                  Klik Disini
                </a>
              ) : (
                // PDF belum diunggah — tampil sebagai teks mati, bukan tautan rusak.
                <span
                  className="cursor-not-allowed font-bold text-[#1e6fd9]/60"
                  title="Dokumen belum tersedia"
                >
                  Klik Disini
                </span>
              )}
            </p>
          </div>
        </div>

        <div className="wide-inner pb-6 text-[1.12rem] font-bold">
          Jumlah Pengunjung: {Number(data.visitors ?? 0).toLocaleString('en-US')}
        </div>

        <MissedSection />
      </main>

      <SiteFooter />
    </>
  );
}