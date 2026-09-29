import RisetPage from '@/components/RisetPage';

export const metadata = {
  title: 'Penelitian — Pusat P2M Polibatam',
  description:
    'Kegiatan penelitian dan skema pendanaan di lingkungan Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam.',
};

export default function PenelitianPage() {
  return (
    <RisetPage
      heading="PENELITIAN"
      intro={[
        'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam mengelola kegiatan penelitian sebagai bagian dari pelaksanaan Tri Dharma Perguruan Tinggi. Penelitian diarahkan pada pengembangan ilmu pengetahuan dan teknologi yang aplikatif serta selaras dengan kebutuhan industri dan masyarakat.',
        'Melalui kolaborasi dengan dosen, pusat kajian, pusat unggulan, dunia usaha, dan dunia industri, P3M mendorong lahirnya riset yang inovatif, berkualitas, dan memberikan manfaat nyata bagi pembangunan nasional.',
      ]}
      schemes={[
        {
          title: 'Penelitian Dasar',
          description:
            'Penelitian yang berorientasi pada pengembangan teori, konsep, dan metode keilmuan sebagai fondasi pengembangan riset lanjutan.',
          focus: [
            'Pengembangan konsep dan metode baru',
            'Kajian keilmuan dasar bidang vokasi',
            'Publikasi pada jurnal bereputasi',
          ],
        },
        {
          title: 'Penelitian Terapan',
          description:
            'Penelitian yang diarahkan pada penerapan ilmu pengetahuan untuk menyelesaikan permasalahan nyata di industri dan masyarakat.',
          focus: [
            'Solusi teknologi tepat guna',
            'Prototipe dan purwarupa produk',
            'Hilirisasi hasil riset ke industri',
          ],
        },
        {
          title: 'Penelitian Pengembangan',
          description:
            'Penelitian yang mengembangkan produk, teknologi, atau sistem yang sudah ada agar lebih efektif, efisien, dan siap digunakan.',
          focus: [
            'Pengembangan produk dan sistem',
            'Uji coba dan evaluasi teknologi',
            'Dukungan komersialisasi hasil riset',
          ],
        },
        {
          title: 'Penelitian Kerja Sama',
          description:
            'Penelitian kolaboratif antara Polibatam dengan perguruan tinggi lain, pemerintah, maupun mitra industri.',
          focus: [
            'Kemitraan lintas institusi',
            'Riset sesuai kebutuhan industri',
            'Pendanaan bersama mitra',
          ],
        },
        {
          title: 'Penelitian Berbasis PBL',
          description:
            'Penelitian yang terintegrasi dengan Project Based Learning, melibatkan mahasiswa langsung dalam penyelesaian proyek nyata.',
          focus: [
            'Mahasiswa terlibat dalam riset',
            'Luaran bermanfaat bagi industri',
            'Penguatan kompetensi lulusan',
          ],
        },
        {
          title: 'Publikasi & Diseminasi',
          description:
            'Dukungan penyebarluasan hasil penelitian melalui publikasi ilmiah, seminar, dan konferensi nasional maupun internasional.',
          focus: [
            'Pendampingan penulisan artikel ilmiah',
            'Dukungan biaya publikasi',
            'Dokumentasi luaran riset',
          ],
        },
      ]}
      documents={[
        {
          title: 'Buku Panduan Penelitian dan Pengabdian 2026',
          description: 'Acuan utama pengusulan proposal penelitian dan pengabdian tahun 2026.',
          href: null,
        },
        {
          title: 'Format Proposal Penelitian',
          description: 'Template penulisan proposal penelitian sesuai ketentuan P3M.',
          href: null,
        },
        {
          title: 'Format Laporan Kemajuan',
          description: 'Template pelaporan kemajuan kegiatan penelitian.',
          href: null,
        },
      ]}
    />
  );
}