import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Profil — Pusat P2M Polibatam' };

export default function ProfilPage() {
  return (
    <EditorialPage slug="profil" heading="PROFIL" visitors="17,874">
      <p>
        Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam
        merupakan unit yang mengelola, memfasilitasi, serta mengembangkan kegiatan penelitian
        dan pengabdian kepada masyarakat di lingkungan Polibatam.
      </p>
      <p>
        Unit ini mendorong terciptanya riset yang berkualitas, publikasi ilmiah yang
        bereputasi, serta hilirisasi hasil penelitian yang berdampak bagi industri dan
        masyarakat.
      </p>
    </EditorialPage>
  );
}