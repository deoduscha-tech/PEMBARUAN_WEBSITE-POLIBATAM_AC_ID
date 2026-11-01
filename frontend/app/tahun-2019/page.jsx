import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2019 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2019. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2019), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2019Page() {
  return (
    <EditorialPage
      slug="tahun2019"
      heading="TAHUN 2019"
      visitors=""
      isPublication
      publicationYear="2019"
    />
  );
}