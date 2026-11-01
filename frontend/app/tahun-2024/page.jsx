import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2024 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2024. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2024), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2024Page() {
  return (
    <EditorialPage
      slug="tahun2024"
      heading="TAHUN 2024"
      visitors=""
      isPublication
      publicationYear="2024"
    />
  );
}