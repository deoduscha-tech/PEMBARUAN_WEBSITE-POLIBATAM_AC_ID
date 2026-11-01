import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2014 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2014. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2014), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2014Page() {
  return (
    <EditorialPage
      slug="tahun2014"
      heading="TAHUN 2014"
      visitors=""
      isPublication
      publicationYear="2014"
    />
  );
}