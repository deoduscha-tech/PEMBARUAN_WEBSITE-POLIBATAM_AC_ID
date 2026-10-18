import EditorialPage from '@/components/EditorialPage';

export const metadata = {
  title: 'RIP Pengabdian — Pusat P2M Polibatam',
};

const SK_URL =
  'https://p2m.polibatam.ac.id/wp-content/uploads/2021/08/569-Penetapan-Rencana-Induk-Pengabdian-pada-Masyarakat-RIPPM-Politeknik-Negeri-Batam-Periode-2021-2025.pdf';
const RIP_URL =
  'https://p2m.polibatam.ac.id/wp-content/uploads/2021/08/RIP-Pengabdian-Masyarakat-2021-2025.pdf';

export default function RipPengabdianPage() {
  return (
    <EditorialPage slug="profil" heading="RIP Pengabdian" visitors="6,071">
      <div className="mx-auto max-w-[1360px] px-0 py-2 md:px-2">
        <p className="mb-6 text-justify leading-[2.05]">
          Visi dari Politeknik Negeri Batam (Polibatam) adalah “Menjadi politeknik generasi baru
          yang bermutu, unggul, adaptif, inovatif dan bermitra erat dengan industri dan masyarakat
          untuk mendukung Indonesia Maju dan Sejahtera 2045” Guna mendukung Visi tersebut,
          Politeknik Negeri Batam berusaha untuk mengintegrasikan kegiatan Tridarma yaitu
          pengajaran, penelitian dan pengabdian kepada masyarakat. Oleh karena itu, untuk
          mewujudkan visi Polibatam tersebut maka Pusat Penelitian dan Pengabdian Kepada
          Masyarakat (Pusat P2M), menyusun Rencana Strategis (Renstra) Pengabdian Kepada
          Masyarakat (PPM) sebagai pedoman dalam pengembangan arah kegiatan pengabdian kepada
          masyarakat.
        </p>

        <p className="mb-6 text-justify leading-[2.05]">
          Renstra PPM Polibatam disusun berdasarkan Peraturan Menteri Pendidikan dan Kebudayaan
          nomor 3 tahun 2020 tentang Standar Nasional Pendidikan Tinggi khususnya Bab IV Standar
          Nasional Pengabdian Kepada Masyarakat. Ruang lingkup Standar Nasional Pengabdian kepada
          Masyarakat terdiri atas: Standar hasil pengabdian kepada masyarakat; Standar isi
          pengabdian kepada masyarakat; Standar proses pengabdian kepada masyarakat; Standar
          penilaian pengabdian kepada masyarakat; Standar pelaksana pengabdian kepada masyarakat;
          Standar sarana dan prasarana pengabdian kepada masyarakat; Standar pengelolaan
          pengabdian kepada masyarakat; dan Standar pendanaan dan pembiayaan pengabdian kepada
          masyarakat. Ke delapan standar PPM ini akan menjadi acuan utama dalam perencanaan,
          pelaksanaan, dan evaluasi hasil PPM Polibatam.
        </p>

        <p className="mb-3">Selengkapnya pada Link berikut:</p>
        <ul className="list-disc pl-7">
          <li>
            <a href={SK_URL} target="_blank" rel="noopener noreferrer">
              SK PENETAPAN RENCANA INDUK PENGABDIAN MASYARAKAT (RIPPM) POLIBATAM 2021-2025
            </a>
          </li>
          <li>
            <a href={RIP_URL} target="_blank" rel="noopener noreferrer">
              RIP PENGABDIAN MASYARAKAT POLIBATAM 2021-2025
            </a>
          </li>
        </ul>
      </div>
    </EditorialPage>
  );
}
