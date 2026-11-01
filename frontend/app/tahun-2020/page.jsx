import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2020 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2020. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2020), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2020Page() {
  return (
    <EditorialPage
      slug="tahun2020"
      heading="TAHUN 2020"
      visitors=""
      isPublication
      publicationYear="2020"
    />
  );
}