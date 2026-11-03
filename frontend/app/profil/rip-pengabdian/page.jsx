import EditorialPage from '@/components/EditorialPage';
import { apiGet } from '@/lib/api';
import { HalamanBody } from '@/components/HalamanContent';

/**
 * VIEW — halaman RIP Pengabdian.
 *
 * Teks dan tautan PDF diambil dari API Laravel /api/halaman/rip-pengabdian
 * (sumber: backend/resources/data/halaman.php), tidak lagi ditulis di sini.
 */
export const revalidate = 60;

export const metadata = {
  title: 'RIP Pengabdian — Pusat P2M Polibatam',
};

export default async function RipPengabdianPage() {
  // Slug ditulis langsung: halaman ini statis (bukan [slug]), jadi params
  // tidak tersedia dan dulu membuat API dipanggil dengan slug kosong → 404.
  const response = await apiGet('/halaman/rip-pengabdian');
  const data = response.ok ? response.data.data : null;

  return (
    <EditorialPage
      slug="profil"
      heading={data?.heading ?? 'RIP Pengabdian'}
      visitors={data ? Number(data.visitors ?? 0).toLocaleString('en-US') : '—'}
    >
      {data ? (
        <HalamanBody data={data} />
      ) : (
        <p>
          Konten halaman ini belum dapat dimuat
          {response.error ? ` (${response.error})` : ''}. Pastikan backend Laravel berjalan.
        </p>
      )}
    </EditorialPage>
  );
}
