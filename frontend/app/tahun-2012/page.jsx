import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2012 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2012. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2012), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2012Page() {
  return (
    <EditorialPage
      slug="tahun2012"
      heading="TAHUN 2012"
      visitors=""
      isPublication
      publicationYear="2012"
    />
  );
}