import EditorialPage from '@/components/EditorialPage';
import { apiGet } from '@/lib/api';
import { HalamanBody } from '@/components/HalamanContent';

// Halaman ini bisa diubah dari panel admin, jadi JANGAN di-cache: setelah
// admin menyimpan, pengunjung langsung melihat versi terbaru.
export const dynamic = 'force-dynamic';

export const metadata = { title: 'Informasi — Pusat P2M Polibatam' };

/**
 * VIEW — halaman INFORMASI.
 *
 * Teks, angka pengunjung, dan pengaturan "tampilkan berita" datang dari API
 * Laravel /api/halaman/informasi.
 */
export default async function InformasiPage() {
  const response = await apiGet('/halaman/informasi');
  const data = response.ok ? response.data.data : null;

  return (
    <EditorialPage
      slug="informasi"
      heading={data?.heading ?? 'INFORMASI'}
      visitors={data ? Number(data.visitors ?? 0).toLocaleString('en-US') : '—'}
      showPosts={Boolean(data?.show_posts)}
    >
      {data ? (
        <HalamanBody data={data} />
      ) : (
        <p>
          Konten informasi belum dapat dimuat
          {response.error ? ` (${response.error})` : ''}. Pastikan backend Laravel berjalan.
        </p>
      )}
    </EditorialPage>
  );
}