import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'HKI — Pusat P2M Polibatam' };

export default function HkiPage() {
  return (
    <EditorialPage slug="hki" heading="HKI" visitors="4,342">
      <h3>Hak Kekayaan Intelektual</h3>
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
    </EditorialPage>
  );
}