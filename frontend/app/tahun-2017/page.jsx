import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2017 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2017. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2017), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2017Page() {
  return (
    <EditorialPage
      slug="tahun2017"
      heading="TAHUN 2017"
      visitors=""
      isPublication
      publicationYear="2017"
    />
  );
}