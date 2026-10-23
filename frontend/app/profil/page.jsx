import Link from 'next/link';
import EditorialPage from '@/components/EditorialPage';
import { apiGet } from '@/lib/api';
import { HalamanBody } from '@/components/HalamanContent';

// Data berita di-cache 60 detik (ISR) supaya perpindahan halaman instan.
// Ubah ke `export const dynamic = 'force-dynamic';` kalau harus selalu segar.
export const revalidate = 60;

export const metadata = { title: 'Profil — Pusat P2M Polibatam' };

/**
 * VIEW — halaman PROFIL.
 *
 * Isi (teks + jumlah pengunjung) diambil dari API Laravel /api/halaman/profil,
 * bukan ditulis ulang di sini, supaya tidak berbeda dengan versi backend.
 */
export default async function ProfilPage() {
  const response = await apiGet('/halaman/profil');
  const data = response.ok ? response.data.data : null;

  return (
    <EditorialPage
      slug="profil"
      heading={data?.heading ?? 'PROFIL'}
      visitors={data ? Number(data.visitors ?? 0).toLocaleString('en-US') : '—'}
    >
      {data ? (
        <HalamanBody data={data} />
      ) : (
        <p>
          Konten profil belum dapat dimuat
          {response.error ? ` (${response.error})` : ''}. Pastikan backend Laravel berjalan.
        </p>
      )}

      <p className="mt-6">
        <Link
          href="/profil/renstra-penelitian"
          className="font-bold text-[#1e6fd9] underline decoration-[#1e6fd9]/40 underline-offset-2 transition-colors hover:text-[#0d4ca8]"
        >
          Renstra Penelitian
        </Link>
        {' · '}
        <Link
          href="/profil/rip-pengabdian"
          className="font-bold text-[#1e6fd9] underline decoration-[#1e6fd9]/40 underline-offset-2 transition-colors hover:text-[#0d4ca8]"
        >
          RIP Pengabdian
        </Link>
      </p>
    </EditorialPage>
  );
}