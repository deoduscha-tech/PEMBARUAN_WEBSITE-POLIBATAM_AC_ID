import Link from 'next/link';
import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';
import { apiGet } from '@/lib/api';

// Tahun arsip HKI — selalu ditampilkan sebagai opsi di bawah tiap halaman HKI.
const HKI_YEARS = ['2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017'];

/**
 * VIEW (server) — tabel arsip "HKI TAHUN 20xx".
 *
 * Data diambil dari API Laravel (/api/hki/{tahun}), yang membacanya dari
 * resources/data/hki.php. Server component ini juga bisa memuat bagian async
 * "You missed" tanpa mencampur komponen server ke dalam client component.
 */
export default async function HkiTahunView({ tahun }) {
  const response = await apiGet(`/hki/${tahun}`);
  const data = response.ok ? response.data?.data : null;
  const error = response.ok ? null : response.error;
  const daftar = data?.daftar ?? [];
  const ringkasan = data?.ringkasan ?? { total: 0, rincian: [] };
  const kolom = data?.kolom ?? ['Judul', 'Jenis HKI', 'Nama Pencipta', 'Nomor Permohonan'];
  const adaNomorPermohonan = kolom.length > 3;

  return (
    <>
      <SiteHeader page="home" active="hki" />

      <main className="bg-[#efefef] pb-6">
        <h1 className="wide-inner py-6 text-[clamp(2.3rem,4vw,4rem)] font-black tracking-[-0.06em] text-[#101926] uppercase">
          HKI TAHUN {tahun}
        </h1>

        <div className="wide-inner mb-4 border border-line bg-white p-6 rich-copy">
          {error && (
            <p>
              Data HKI tahun {tahun} tidak dapat dimuat ({error}). Pastikan backend
              berjalan: <code>cd backend &amp;&amp; php artisan serve</code>.
            </p>
          )}

          {!error && daftar.length === 0 && (
            <p>
              Daftar HKI Politeknik Negeri Batam {tahun} belum tersedia pada situs ini.
              Silakan pilih tahun lain pada halaman <Link href="/hki">HKI</Link>.
            </p>
          )}

          {!error && daftar.length > 0 && (
            <>
              {data.show_summary ? (
                <>
                  <p>
                    {String(tahun) === '2025' ? 'Daftar' : 'Berikut daftar'} HKI Politeknik Negeri
                    Batam {tahun}, terdapat{' '}
                    <strong>{Number(ringkasan.total ?? 0).toLocaleString('en-US')} Judul</strong>{' '}
                    yang terdiri dari:
                  </p>
                  <ul>
                    {(ringkasan.rincian ?? []).map((baris) => (
                      <li key={baris.jenis}>
                        {baris.jumlah} Judul {baris.jenis}
                      </li>
                    ))}
                  </ul>
                </>
              ) : (
                <p>HKI Politeknik Negeri Batam Tahun {tahun}</p>
              )}

              <div className="mt-4 overflow-x-auto">
                <table className="w-full border-collapse text-[0.86rem]">
                  <thead>
                    <tr className="bg-[#1d2432] text-left text-white">
                      <th className="border border-line px-3 py-2">No</th>
                      {kolom.map((label) => (
                        <th key={label} className="border border-line px-3 py-2">
                          {label}
                        </th>
                      ))}
                    </tr>
                  </thead>
                  <tbody>
                    {daftar.map((item, index) => (
                      <tr
                        key={`${tahun}-${index}`}
                        className={`align-top ${index % 2 ? 'bg-[#f7f9fc]' : 'bg-white'}`}
                      >
                        <td className="border border-line px-3 py-2">{index + 1}</td>
                        <td className="border border-line px-3 py-2 font-bold text-[#0b1d35]">{item.judul}</td>
                        <td className="border border-line px-3 py-2">{item.jenis}</td>
                        <td className="border border-line px-3 py-2 whitespace-pre-line">{item.pencipta}</td>
                        {adaNomorPermohonan && (
                          <td className="border border-line px-3 py-2 whitespace-nowrap">{item.nomor}</td>
                        )}
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </>
          )}
        </div>

        <div className="wide-inner pb-6 text-[1.12rem] font-bold">
          Jumlah Pengunjung: {Number(data?.views ?? 0).toLocaleString('en-US')}
        </div>

        {/* Opsi tahun HKI — selalu tampil di bawah tiap halaman HKI,
            termasuk halaman arsip tahun seperti ini. */}
        <div className="wide-inner mb-4 border border-line bg-white p-6">
          <h3 className="mb-3 text-[1.05rem] font-bold text-[#101926]">Pilih Tahun</h3>
          <div className="flex flex-wrap gap-2">
            <Link
              key="hki"
              href="/hki"
              className="rounded-full border border-[#c9d2de] bg-white px-4 py-2 text-[0.78rem] font-bold tracking-[0.02em] text-[#3b4757] uppercase transition-colors hover:bg-[#eaf1ff]"
            >
              HKI
            </Link>
            {HKI_YEARS.map((year) => (
              <Link
                key={year}
                href={`/hki/tahun-${year}`}
                className={`rounded-full border px-4 py-2 text-[0.78rem] font-bold tracking-[0.02em] uppercase transition-colors ${
                  year === String(tahun)
                    ? 'border-[#1e6fd9] bg-[#1e6fd9] text-white'
                    : 'border-[#c9d2de] bg-white text-[#3b4757] hover:bg-[#eaf1ff]'
                }`}
              >
                HKI TAHUN {year}
              </Link>
            ))}
          </div>
        </div>

        <MissedSection />
      </main>

      <SiteFooter />
    </>
  );
}
