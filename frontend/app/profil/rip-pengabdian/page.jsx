import EditorialPage from '@/components/EditorialPage';
import { apiGet } from '@/lib/api';
import { HalamanBody, halamanMetadata } from '@/components/HalamanContent';

/**
 * VIEW — halaman RIP Pengabdian.
 *
 * Teks dan tautan PDF diambil dari API Laravel /api/halaman/rip-pengabdian
 * (sumber: backend/resources/data/halaman.php), tidak lagi ditulis di sini.
 */
export const revalidate = 60;

export async function generateMetadata({ params }) {
  return halamanMetadata((await params)?.slug ?? 'rip-pengabdian');
}

export default async function HalamanStatisPage({ params }) {
  const { slug } = await params;
  const response = await apiGet(`/halaman/${slug}`);
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
