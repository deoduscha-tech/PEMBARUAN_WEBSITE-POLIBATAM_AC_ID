import Link from 'next/link';
import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';

export const metadata = {
  title: 'Laporan Tahunan P3M 2025 — Pusat P2M Polibatam',
};

/**
 * VIEW — halaman Laporan Tahunan.
 *
 * Isi laporan didefinisikan di sini karena murni konten statis. Kalau nanti
 * perlu diubah lewat admin, pindahkan ke Model.
 */
const REPORT_YEAR = '2025';
const VISITORS = 264;

// Null selama PDF belum diunggah ke public/documents/.
const REPORT_FILE = null;

const PARAGRAPHS = [
  'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam merupakan unit yang mengelola, memfasilitasi, dan mengembangkan kegiatan penelitian serta pengabdian kepada masyarakat sebagai implementasi Tri Dharma Perguruan Tinggi. Melalui kolaborasi dengan dosen, pusat kajian, pusat unggulan, dunia usaha, dunia industri, pemerintah, dan masyarakat, P3M berkomitmen menghasilkan riset yang inovatif, berkualitas, dan memberikan manfaat nyata bagi pembangunan nasional.',
  'Sepanjang tahun 2025, P3M berhasil menunjukkan kinerja yang sangat baik dengan penyelesaian 100% terhadap seluruh Indikator Kinerja Utama (IKU). Berbagai capaian strategis berhasil diraih, di antaranya 99 publikasi internasional, 163 pendaftaran Hak Kekayaan Intelektual (HKI), 79 luaran penelitian berbasis Project Based Learning (PBL) yang dimanfaatkan oleh industri, serta 29 kegiatan pengabdian kepada masyarakat yang melibatkan 233 dosen. Capaian tersebut mencerminkan komitmen P3M dalam memperkuat ekosistem riset, inovasi, hilirisasi teknologi, dan pengabdian yang berdampak bagi masyarakat serta mendukung peningkatan daya saing Politeknik Negeri Batam di tingkat nasional maupun internasional.',
  'P3M akan terus mendorong peningkatan kualitas penelitian, publikasi ilmiah bereputasi, perlindungan kekayaan intelektual, kemitraan strategis dengan industri, serta pengembangan inovasi yang berorientasi pada kebutuhan masyarakat dan pembangunan berkelanjutan.',
];

export default function LaporanTahunanPage() {
  return (
    <>
      <SiteHeader page="home" />

      <main className="bg-[#efefef] pb-6">
        <div className="wide-inner mb-4 border-line bg-white p-8">
          <h1 className="mb-[18px] text-[clamp(1.9rem,3vw,2.6rem)] font-black tracking-[0.02em] text-[#0b1d35] uppercase">
            LAPORAN TAHUNAN P3M TAHUN {REPORT_YEAR}
          </h1>

          <div className="rich-copy text-[1.05rem] leading-[1.9] text-[#1f2937]">
            {PARAGRAPHS.map((text, index) => (
              <p key={index}>{text}</p>
            ))}

            <p>
              Unduh Laporan Tahunan Penelitian dan Pengabdian kepada Masyarakat Tahun{' '}
              {REPORT_YEAR} (PDF):{' '}
              {REPORT_FILE ? (
                <a
                  href={REPORT_FILE}
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
          Jumlah Pengunjung: {VISITORS.toLocaleString('en-US')}
        </div>

        <MissedSection />
      </main>

      <SiteFooter />
    </>
  );
}