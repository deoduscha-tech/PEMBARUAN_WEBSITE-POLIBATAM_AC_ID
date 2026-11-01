import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2023 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2023. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2023), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2023Page() {
  return (
    <EditorialPage
      slug="tahun2023"
      heading="TAHUN 2023"
      visitors=""
      isPublication
      publicationYear="2023"
    />
  );
}