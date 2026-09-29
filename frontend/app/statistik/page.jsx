import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Statistik — Pusat P2M Polibatam' };

export default function StatistikPage() {
  return (
    <EditorialPage slug="statistik" heading="STATISTIK" visitors="12,480">
      <h3>Statistik Pusat Penelitian dan Pengabdian Masyarakat</h3>
      <p>
        Pusat P2M Polibatam terus memperkuat aktivitas riset, publikasi, dan pengabdian dengan
        fokus pada inovasi, kolaborasi, serta dampak nyata bagi masyarakat dan industri.
      </p>
      <ul>
        <li>Riset dan inovasi terarah sesuai kebutuhan industri</li>
        <li>Kolaborasi lintas disiplin dan mitra strategis</li>
        <li>Publikasi ilmiah dan penguatan karya akademik</li>
        <li>Pengabdian masyarakat berbasis solusi teknologi</li>
      </ul>
    </EditorialPage>
  );
}