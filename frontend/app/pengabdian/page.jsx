import RisetPage from '@/components/RisetPage';

export const metadata = {
  title: 'Pengabdian kepada Masyarakat — Pusat P2M Polibatam',
  description:
    'Kegiatan pengabdian kepada masyarakat di lingkungan Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Negeri Batam.',
};

export default function PengabdianPage() {
  return (
    <RisetPage
      heading="PENGABDIAN"
      intro={[
        'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam menyelenggarakan kegiatan pengabdian kepada masyarakat sebagai wujud kontribusi nyata perguruan tinggi bagi peningkatan kualitas hidup masyarakat.',
        'Kegiatan pengabdian diarahkan pada penerapan teknologi tepat guna, peningkatan kapasitas mitra, serta penyelesaian permasalahan nyata di masyarakat dan industri kecil menengah.',
      ]}
      schemes={[
        {
          title: 'Pengabdian Berbasis Wilayah',
          description:
            'Program pengabdian yang menyasar satu wilayah atau komunitas tertentu secara berkelanjutan.',
          focus: [
            'Pendampingan masyarakat desa',
            'Peningkatan kapasitas komunitas',
            'Program berkelanjutan',
          ],
        },
        {
          title: 'Pengabdian berbasis UMKM',
          description:
            'Pendampingan bagi usaha mikro, kecil, dan menengah agar lebih produktif dan berdaya saing.',
          focus: [
            'Pendampingan produksi dan pemasaran',
            'Penerapan teknologi tepat guna',
            'Peningkatan kualitas produk',
          ],
        },
        {
          title: 'Penerapan Teknologi Tepat Guna',
          description:
            'Penerapan hasil riset menjadi solusi teknologi yang langsung dapat digunakan masyarakat.',
          focus: [
            'Alat dan mesin tepat guna',
            'Sistem informasi sederhana',
            'Pelatihan penggunaan teknologi',
          ],
        },
        {
          title: 'Pengabdian Bidang Pendidikan',
          description:
            'Peningkatan mutu pendidikan melalui pelatihan guru, pengembangan materi, dan literasi teknologi.',
          focus: [
            'Pelatihan guru dan siswa',
            'Pengembangan bahan ajar',
            'Literasi digital sekolah',
          ],
        },
        {
          title: 'Pengabdian Kolaboratif',
          description:
            'Kegiatan pengabdian yang melibatkan mitra pemerintah, industri, atau perguruan tinggi lain.',
          focus: [
            'Kemitraan lintas lembaga',
            'Pendanaan bersama',
            'Jangkauan manfaat lebih luas',
          ],
        },
        {
          title: 'Pengabdian Berbasis PBL',
          description:
            'Kegiatan pengabdian yang melibatkan mahasiswa dalam penyelesaian permasalahan mitra secara langsung.',
          focus: [
            'Mahasiswa terjun ke lapangan',
            'Solusi berbasis kebutuhan mitra',
            'Luaran berupa produk atau layanan',
          ],
        },
      ]}
      documents={[
        {
          title: 'Buku Panduan Pengabdian kepada Masyarakat 2026',
          description: 'Acuan pengusulan proposal pengabdian kepada masyarakat tahun 2026.',
          href: null,
        },
        {
          title: 'Format Proposal Pengabdian',
          description: 'Template penulisan proposal pengabdian sesuai ketentuan P3M.',
          href: null,
        },
        {
          title: 'Format Laporan Akhir Pengabdian',
          description: 'Template pelaporan akhir kegiatan pengabdian kepada masyarakat.',
          href: null,
        },
      ]}
    />
  );
}