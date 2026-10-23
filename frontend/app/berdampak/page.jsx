import EditorialPage from '@/components/EditorialPage';

export const metadata = {
  title: 'Polibatam University Berdampak — Pusat P2M Polibatam',
};

const REPORT_URL =
  'https://polbat-my.sharepoint.com/:b:/g/personal/p3m_polibatam_ac_id/IQDeI_xg-60RTr-O1opMKgpVAfMa5u5bFb4pnu1imIJG_T8?e=ZJtv19';

export default function BerdampakPage() {
  return (
    <EditorialPage slug="berdampak" heading="Polibatam University Berdampak" visitors={405}>
      <article className="mx-auto max-w-[1360px] px-0 py-2 md:px-2">
        <h2 className="mb-5 text-center text-[clamp(1.45rem,2vw,2rem)] leading-tight font-bold tracking-[-0.035em] text-black">
          Laporan Dampak Sosial, Ekonomi, dan Lingkungan Politeknik Negeri Batam Tahun 2025
        </h2>

        <p className="mb-5 text-justify leading-[2.05]">
          Politeknik Negeri Batam (Polibatam) berkomitmen untuk terus menghadirkan pendidikan
          vokasi yang memberikan manfaat nyata bagi masyarakat. Komitmen tersebut diwujudkan
          melalui <strong>Laporan Dampak Sosial, Ekonomi, dan Lingkungan Tahun 2025</strong>,
          yang mendokumentasikan kontribusi institusi dalam mendukung pembangunan berkelanjutan
          melalui pelaksanaan Tri Dharma Perguruan Tinggi dan tata kelola kelembagaan. Laporan
          ini disusun sebagai bentuk akuntabilitas kepada para pemangku kepentingan sekaligus
          sebagai instrumen evaluasi dalam memperkuat peran Polibatam sebagai{' '}
          <em>impact-driven polytechnic</em>.
        </p>

        <p className="mb-5 text-justify leading-[2.05]">
          Laporan ini menyajikan berbagai capaian Polibatam dalam menciptakan dampak pada tiga
          dimensi utama, yaitu <strong>dampak sosial, dampak ekonomi, dan dampak lingkungan</strong>.
          Pada aspek sosial, Polibatam terus memperluas akses pendidikan yang inklusif,
          meningkatkan kualitas penelitian dan inovasi yang berorientasi pada penyelesaian
          permasalahan masyarakat, serta memperkuat program pengabdian kepada masyarakat melalui
          kolaborasi dengan berbagai mitra. Di bidang ekonomi, kontribusi institusi diwujudkan
          melalui hilirisasi hasil riset, pengembangan kewirausahaan, kemitraan dengan dunia usaha
          dan dunia industri, serta aktivitas akademik yang memberikan nilai tambah bagi
          perekonomian daerah. Sementara itu, pada aspek lingkungan, Polibatam mengintegrasikan
          prinsip keberlanjutan dalam pengelolaan kampus, pendidikan, penelitian, dan pengabdian
          sebagai bagian dari upaya mendukung pencapaian Sustainable Development Goals (SDGs).
        </p>

        <p className="mb-5 text-justify leading-[2.05]">
          Lebih dari sekadar menyajikan capaian kinerja, laporan ini menunjukkan transformasi
          Polibatam menuju perguruan tinggi vokasi yang berorientasi pada outcome dan impact.
          Melalui sinergi antara pendidikan, penelitian, pengabdian kepada masyarakat, inovasi,
          dan kemitraan strategis, Polibatam berupaya menghadirkan solusi yang relevan bagi
          kebutuhan masyarakat, industri, dan pemerintah, sekaligus memperkuat daya saing
          institusi di tingkat nasional maupun internasional.
        </p>

        <p className="mb-5 text-justify leading-[2.05]">
          Dokumen ini diharapkan menjadi referensi bagi sivitas akademika, pemerintah, dunia usaha
          dan dunia industri, mitra, serta masyarakat dalam memahami kontribusi nyata Polibatam
          terhadap pembangunan berkelanjutan. Selain itu, laporan ini menjadi landasan dalam
          pengambilan keputusan berbasis bukti serta pengembangan kebijakan yang mendukung
          implementasi RPJP Polibatam 2025–2044, paradigma Diktisaintek Berdampak, dan pencapaian
          Tujuan Pembangunan Berkelanjutan (SDGs).
        </p>

        <p className="mt-7">
          Unduh Laporan Dampak Sosial, Ekonomi, dan Lingkungan Politeknik Negeri Batam Tahun 2025
          (PDF):{' '}
          <a href={REPORT_URL} target="_blank" rel="noopener noreferrer">
            Klik Disini
          </a>
        </p>
      </article>
    </EditorialPage>
  );
}
