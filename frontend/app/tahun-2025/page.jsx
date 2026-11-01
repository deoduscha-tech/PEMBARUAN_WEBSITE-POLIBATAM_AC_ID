import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Publikasi Tahun 2025 - Pusat P2M Polibatam' };

// Halaman publikasi tahun 2025. Isi & jumlah pengunjung diambil dari API
// Laravel (/api/publikasi?tahun=2025), jadi tidak ada teks yang ditulis di sini.
export default function Tahun2025Page() {
  return (
    <EditorialPage
      slug="tahun2025"
      heading="TAHUN 2025"
      visitors=""
      isPublication
      publicationYear="2025"
    />
  );
}