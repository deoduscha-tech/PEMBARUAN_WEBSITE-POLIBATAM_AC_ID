import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2022 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2022. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2022), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2022Page() {
  return (
    <EditorialPage
      slug="tahun2022"
      heading="TAHUN 2022"
      visitors=""
      isPublication
      publicationYear="2022"
    />
  );
}