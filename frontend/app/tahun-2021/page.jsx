import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2021 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2021. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2021), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2021Page() {
  return (
    <EditorialPage
      slug="tahun2021"
      heading="TAHUN 2021"
      visitors=""
      isPublication
      publicationYear="2021"
    />
  );
}