import Link from 'next/link';
import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Pendaftaran HKI — Pusat P2M Polibatam' };

// Tahun arsip HKI — selalu ditampilkan di bawah tiap halaman HKI.
const HKI_YEARS = ['2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017'];

/**
 * VIEW — halaman "Pendaftaran HKI".
 *
 * Isinya sama dengan halaman Pendaftaran HKI di situs asli
 * p2m.polibatam.ac.id (page_id=5346).
 */
export default function PendaftaranHkiPage() {
  return (
    <EditorialPage slug="hki" heading="Pendaftaran HKI" visitors="10,568">
      <p>
        Dalam rangka mendukung dan melindungi karya civitas akademika dalam penelitian,
        pengabdian, atau program karya ilmiah mahasiswa, dengan ini Sentra HKI mengajak
        Bapak/Ibu untuk mendaftarkan hak kekayaan intelektualnya. Adapun KI yang bisa
        didaftarkan melalui Sentra HKI Polibatam adalah sebagai berikut:
      </p>

      <ul>
        <li>
          <strong>Hak Cipta</strong>, hak eksklusif bagi pencipta atau penerima hak untuk
          mengumumkan atau memperbanyak ciptaannya.
        </li>
        <li>
          <strong>Hak kekayaan industri</strong>, yang mencakup:
          <ul>
            <li>
              <strong>Paten</strong>, hak eksklusif yang diberikan oleh negara kepada inventor
              atas hasil invensinya di bidang teknologi.
            </li>
            <li>
              <strong>Desain industri</strong>, suatu kreasi tentang bentuk, konfigurasi, atau
              komposisi garis atau warna, atau garis dan warna, atau gabungan daripadanya serta
              dapat dipakai untuk menghasilkan suatu produk, barang, komoditas industri, atau
              kerajinan tangan.
            </li>
            <li>
              <strong>Merek</strong>, suatu tanda yang berupa gambar, nama, kata, huruf, angka,
              susunan warna atau kombinasi dari unsur tersebut yang memiliki daya pembeda dan
              digunakan dalam kegiatan perdagangan barang atau jasa.
            </li>
            <li>
              <strong>Desain tata letak sirkuit terpadu</strong>, Sirkuit Terpadu adalah suatu
              produk dalam bentuk jadi atau setengah jadi, yang di dalamnya terdapat berbagai
              elemen dan sekurang-kurangnya satu elemen adalah elemen aktif, yang saling
              berkaitan serta dibentuk secara terpadu di dalam sebuah bahan semikonduktor.
              Desain Tata Letak adalah kreasi berupa rancangan peletakan tiga dimensi,
              sekurang-kurangnya satu elemen adalah elemen aktif, serta interkoneksi dalam suatu
              Sirkuit Terpadu dan peletakan tiga dimensi tersebut untuk persiapan pembuatan
              Sirkuit Terpadu.
            </li>
          </ul>
        </li>
      </ul>

      <p>
        Materi terkait HKI:{' '}
        <a
          href="https://p2m.polibatam.ac.id/?page_id=5346"
          target="_blank"
          rel="noopener noreferrer"
        >
          Klik disini
        </a>
      </p>

      <p>
        Untuk proses pendaftarannya bisa mengikuti panduan pada Linktree (
        <a href="https://linktr.ee/sentrahkipolibatam" target="_blank" rel="noopener noreferrer">
          Klik disini
        </a>
        ) atau dengan mengakses situs{' '}
        <a href="https://dgip.go.id" target="_blank" rel="noopener noreferrer">
          dgip.go.id
        </a>
        .
      </p>

      <p>
        Tim pengelola Sentra HKI Politeknik Negeri Batam, dan berikut Surat Keputusan No.
        171/K/PL29/I/2026:
      </p>

      <ul>
        <li>Ketua Sentra HKI: Fitriyanti Nakul</li>
        <li>PIC Hak Cipta Jurusan Manajemen Bisnis dan Teknik Mesin : Muhammad Ali Faisal</li>
        <li>
          PIC Hak Cipta Jurusan Teknik Informatika dan Teknik Elektro: Widya Putri Ramadhani
        </li>
        <li>
          PIC Paten/ Paten Sederhana, dan DTLST Jurusan Teknik Elektro, Teknik Mesin, Teknik
          Informatika dan Manajemen Bisnis: Mishthafiyatillah
        </li>
        <li>
          PIC Desain Industri Jurusan Teknik Elektro, Teknik Mesin, Teknik Informatika dan
          Manajemen Bisnis: Adi Syahputra Purba
        </li>
      </ul>

      <p>
        Proses pendaftaran KI ini akan dibuka hingga tanggal 15 setiap bulan (jika melewati
        tanggal 15 akan diproses dibulan berikutnya) dan akan dilanjutkan dengan proses review
        dari Tim Sentra HKI Polibatam untuk kemudian di input ke efilling DJKI (bagi pengajuan
        yang lolos review).
      </p>

      {/* Pilihan tahun HKI — selalu tampil di bawah tiap halaman HKI,
          termasuk halaman Pendaftaran HKI ini. */}
      <h3 className="mt-6">Pilih Tahun</h3>
      <div className="flex flex-wrap gap-2">
        <Link
          href="/hki"
          className="rounded-full border border-[#c9d2de] bg-white px-4 py-2 text-[0.78rem] font-bold tracking-[0.02em] text-[#3b4757] uppercase transition-colors hover:bg-[#eaf1ff]"
        >
          HKI
        </Link>
        {HKI_YEARS.map((year) => (
          <a
            key={year}
            href={`/hki/tahun-${year}`}
            className="rounded-full border border-[#c9d2de] bg-white px-4 py-2 text-[0.78rem] font-bold tracking-[0.02em] text-[#3b4757] uppercase transition-colors hover:bg-[#eaf1ff]"
          >
            HKI TAHUN {year}
          </a>
        ))}
      </div>

      <p className="mt-6">
        <Link
          href="/hki"
          className="font-bold text-[#1e6fd9] underline decoration-[#1e6fd9]/40 underline-offset-2 transition-colors hover:text-[#0d4ca8]"
        >
          &larr; Kembali ke Halaman HKI
        </Link>
      </p>
    </EditorialPage>
  );
}
