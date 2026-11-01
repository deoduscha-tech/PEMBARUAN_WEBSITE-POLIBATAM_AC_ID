import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2010 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2010. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2010), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2010Page() {
  return (
    <EditorialPage
      slug="tahun2010"
      heading="TAHUN 2010"
      visitors=""
      isPublication
      publicationYear="2010"
    />
  );
}