import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2026 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2026. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2026), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2026Page() {
  return (
    <EditorialPage
      slug="tahun2026"
      heading="TAHUN 2026"
      visitors=""
      isPublication
      publicationYear="2026"
    />
  );
}