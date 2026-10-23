import { notFound } from 'next/navigation';
import EditorialPage from '@/components/EditorialPage';
import { apiGet } from '@/lib/api';

import { halamanMetadata, HalamanBody } from '@/components/HalamanContent';

/**
 * VIEW — halaman konten statis (profil, renstra penelitian, RIP pengabdian).
 *
 * Isi halaman TIDAK lagi ditulis di sini, melainkan diambil dari API Laravel
 * (/api/halaman/{slug}) yang bersumber dari backend/resources/data/halaman.php.
 * Dengan begitu teks, angka pengunjung, dan tautannya sama dengan versi Blade.
 */
export const revalidate = 60;

// Isi halaman bisa diubah dari backend tanpa rebuild frontend.
export async function generateMetadata({ params }) {
  const { slug } = await params;

  return halamanMetadata(slug);
}

export default async function HalamanStatisPage({ params }) {
  const { slug } = await params;
  const response = await apiGet(`/halaman/${slug}`);

  if (!response.ok) {
    if (response.status === 404) notFound();

    return (
      <EditorialPage slug="profil" heading={slug} visitors={0}>
        <p>
          Konten halaman ini belum dapat dimuat
          {response.error ? ` (${response.error})` : ''}. Pastikan backend Laravel berjalan.
        </p>
      </EditorialPage>
    );
  }

  const data = response.data.data;

  return (
    <EditorialPage
      slug="profil"
      heading={data.heading ?? slug}
      visitors={data.visitors ? Number(data.visitors).toLocaleString('en-US') : 0}
      showPosts={Boolean(data.show_posts)}
    >
      <HalamanBody data={data} />
    </EditorialPage>
  );
}
