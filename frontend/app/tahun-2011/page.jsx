import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2011 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2011. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2011), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2011Page() {
  return (
    <EditorialPage
      slug="tahun2011"
      heading="TAHUN 2011"
      visitors=""
      isPublication
      publicationYear="2011"
    />
  );
}