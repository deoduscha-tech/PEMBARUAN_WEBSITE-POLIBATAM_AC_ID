import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2016 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2016. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2016), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2016Page() {
  return (
    <EditorialPage
      slug="tahun2016"
      heading="TAHUN 2016"
      visitors=""
      isPublication
      publicationYear="2016"
    />
  );
}