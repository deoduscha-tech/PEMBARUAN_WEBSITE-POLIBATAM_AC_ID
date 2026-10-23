import EditorialPage from '@/components/EditorialPage';
import { apiGet } from '@/lib/api';
import { HalamanBody, halamanMetadata } from '@/components/HalamanContent';

/**
 * VIEW — halaman Renstra Penelitian.
 *
 * Teks dan tautan PDF diambil dari API Laravel /api/halaman/renstra-penelitian
 * (sumber: backend/resources/data/halaman.php), tidak lagi ditulis di sini.
 */
export const revalidate = 60;

export async function generateMetadata({ params }) {
  return halamanMetadata((await params)?.slug ?? 'renstra-penelitian');
}

export default async function HalamanStatisPage({ params }) {
  const { slug } = await params;
  const response = await apiGet(`/halaman/${slug}`);
  const data = response.ok ? response.data.data : null;

  return (
    <EditorialPage
      slug="profil"
      heading={data?.heading ?? 'Renstra Penelitian'}
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
