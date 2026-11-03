import EditorialPage from '@/components/EditorialPage';
import { apiGet } from '@/lib/api';
import { HalamanBody } from '@/components/HalamanContent';

export const metadata = {
  title: 'Polibatam University Berdampak - Pusat P2M Polibatam',
};

/**
 * VIEW - halaman laporan dampak.
 *
 * Teks dan tautan PDF diambil dari API (/api/halaman/berdampak) yang dapat
 * disunting lewat panel admin, jadi tidak perlu mengubah kode untuk
 * memperbarui laporan tahun berikutnya.
 */
export const dynamic = 'force-dynamic';

export default async function BerdampakPage() {
  const response = await apiGet('/halaman/berdampak');
  const data = response.ok ? response.data.data : null;

  return (
    <EditorialPage
      slug="berdampak"
      heading={data?.heading ?? 'Polibatam University Berdampak'}
      visitors={data ? Number(data.visitors ?? 0).toLocaleString('en-US') : '-'}
    >
      <article className="mx-auto max-w-[1360px] px-0 py-2 md:px-2">
        <h2 className="mb-5 text-center text-[clamp(1.25rem,1.7vw,1.6rem)] leading-tight font-bold tracking-[-0.02em] text-black">
          Laporan Dampak Sosial, Ekonomi, dan Lingkungan Politeknik Negeri Batam
        </h2>

        {data ? (
          <div className="text-justify leading-[2.05]">
            <HalamanBody data={data} />
          </div>
        ) : (
          <p>
            Konten laporan belum dapat dimuat
            {response.error ? ` (${response.error})` : ''}. Pastikan backend Laravel berjalan.
          </p>
        )}
      </article>
    </EditorialPage>
  );
}
