import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2018 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2018. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2018), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2018Page() {
  return (
    <EditorialPage
      slug="tahun2018"
      heading="TAHUN 2018"
      visitors=""
      isPublication
      publicationYear="2018"
    />
  );
}