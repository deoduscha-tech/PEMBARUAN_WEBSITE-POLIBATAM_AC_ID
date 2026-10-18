import EditorialPage from '@/components/EditorialPage';

export const metadata = {
  title: 'Renstra Penelitian — Pusat P2M Polibatam',
};

const SK_URL =
  'https://p2m.polibatam.ac.id/wp-content/uploads/2021/08/568-Penetapan-Renstra-Penelitian-Polibatam-Periode-2021-2025-1.pdf';
const RENSTRA_URL =
  'https://p2m.polibatam.ac.id/wp-content/uploads/2021/08/Renstra-Penelitian-2021-2025.pdf';

export default function RenstraPenelitianPage() {
  return (
    <EditorialPage slug="profil" heading="Renstra Penelitian" visitors="7,044">
      <div className="mx-auto max-w-[1360px] px-0 py-2 md:px-2">
        <p className="mb-6 text-justify leading-[2.05]">
          Rencana Strategis Penelitian (Renstra Penelitian) Institusi merupakan arahan kebijakan
          dan pengambilan keputusan dalam pengelolaan penelitian institusi dalam jangka waktu
          tertentu (5 tahun). Sebagai salah satu lembaga pendidikan vokasi yang menjadi garda
          terdepan dalam pengembangan keilmuan dan pengabdian masyarakat, Renstra Penelitian
          Politeknik Negeri Batam (Renstra Penelitian PoliBatam) diharapkan dapat berkontribusi
          tidak hanya kepada masyarakat tapi juga negara dan bangsa Indonesia maupun dunia.
        </p>

        <p className="mb-6 text-justify leading-[2.05]">
          Salah satu bentuk sumbangsih tersebut adalah dengan melakukan kegiatan riset yang
          hasilnya dapat diabdikan kepada peningkatan secara produktif kesejahteraan dan
          kemanusiaan masyarakat dan bangsa Indonesia pada umumnya. Berlatar belakang pada
          keperluan penyelesaian masalah kemanusiaan, perlu dibuat sebuah langkah strategis yang
          cerdas dan dinamis bagi kegiatan riset di Politeknik Negeri Batam.
        </p>

        <p className="mb-6 text-justify leading-[2.05]">
          Strategi yang dipilih adalah penentuan sebuah program strategis riset yang dilandaskan
          pada kepakaran yang dimiliki periset Politeknik Negeri Batam. Program strategis riset
          yang diunggulkan adalah di mana Politeknik Negeri Batam memang unggul (proses{' '}
          <em>bottom up</em> melalui identifikasi kompetensi riil dari <em>track record</em>{' '}
          seorang periset) dan mampu bersaing baik di skala nasional maupun internasional,
          dengan cara yang cerdas memilih program strategis (jenis riset yang diunggulkan) yang
          khas pendidikan vokasi.
        </p>

        <p className="mb-3">Selengkapnya pada Link berikut:</p>
        <ul className="list-disc pl-7">
          <li>
            <a href={SK_URL} target="_blank" rel="noopener noreferrer">
              SK PENETAPAN RESNTRA PENELITIAN POLIBATAM 2021-2025
            </a>
          </li>
          <li>
            <a href={RENSTRA_URL} target="_blank" rel="noopener noreferrer">
              RENSTRA PENELITIAN POLIBATAM 2021-2025
            </a>
          </li>
        </ul>
      </div>
    </EditorialPage>
  );
}
