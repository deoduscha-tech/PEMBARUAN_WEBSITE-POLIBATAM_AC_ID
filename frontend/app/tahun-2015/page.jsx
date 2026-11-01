import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2015 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2015. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2015), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2015Page() {
  return (
    <EditorialPage
      slug="tahun2015"
      heading="TAHUN 2015"
      visitors=""
      isPublication
      publicationYear="2015"
    />
  );
}