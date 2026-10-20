import Link from 'next/link';
import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'HKI — Pusat P2M Polibatam' };

/**
 * Pilihan tahun arsip HKI — sama seperti submenu HKI di situs asli
 * p2m.polibatam.ac.id.
 */
const HKI_YEARS = ['2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017'];

export default function HkiPage() {
  return (
    <EditorialPage slug="hki" heading="HKI" visitors="8,490">
      <h3>Polibatam University Berdampak</h3>
      <p>
        Hak Kekayaan Intelektual (HKI) merupakan bagian dari komitmen Polibatam University
        Berdampak dalam mendorong lahirnya karya intelektual yang terlindungi dan bermanfaat
        bagi masyarakat serta industri.
      </p>
      <p>
        Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam aktif
        mendorong pengembangan inovasi, karya ilmiah, dan produk teknologi yang memiliki nilai
        komersial serta manfaat bagi masyarakat.
      </p>
      <p>
        Berbagai karya inovatif dari dosen dan mahasiswa didaftarkan sebagai HKI untuk
        melindungi, meningkatkan nilai ekonomi, serta memperkuat ekosistem riset dan inovasi
        perguruan tinggi.
      </p>

      <h3 className="mt-6">Prioritas Pengembangan HKI</h3>
      <p>
        Beberapa fokus utama pengembangan HKI meliputi teknologi tepat guna, perangkat lunak,
        desain produk, inovasi pendidikan, serta solusi berbasis kebutuhan industri dan
        masyarakat.
      </p>
      <ul>
        <li>Perlindungan inovasi produk dan teknologi</li>
        <li>Pengembangan karya riset yang aplikatif</li>
        <li>Dukungan komersialisasi hasil penelitian</li>
        <li>Kolaborasi dengan industri dan mitra strategis</li>
      </ul>

      {/* Pilihan tahun arsip HKI + tautan pendaftaran. */}
      <h3 className="mt-6">Pilih Tahun</h3>
      <div className="flex flex-wrap gap-2">
        <Link
          href="/hki/pendaftaran"
          className="rounded-full border border-[#c9d2de] bg-white px-4 py-2 text-[0.78rem] font-bold tracking-[0.02em] text-[#3b4757] uppercase transition-colors hover:bg-[#eaf1ff]"
        >
          Pendaftaran HKI
        </Link>
        {HKI_YEARS.map((year) => (
          <Link
            key={year}
            href={`/hki/tahun-${year}`}
            className="rounded-full border border-[#c9d2de] bg-white px-4 py-2 text-[0.78rem] font-bold tracking-[0.02em] text-[#3b4757] uppercase transition-colors hover:bg-[#eaf1ff]"
          >
            HKI TAHUN {year}
          </Link>
        ))}
      </div>
    </EditorialPage>
  );
}
