import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Informasi — Pusat P2M Polibatam' };

export default function InformasiPage() {
  return (
    <EditorialPage slug="informasi" heading="INFORMASI" visitors="6,589" showPosts>
      <p>
        Informasi terkini seputar penelitian, pengabdian kepada masyarakat, serta kegiatan
        Pusat P2M Politeknik Negeri Batam.
      </p>
    </EditorialPage>
  );
}