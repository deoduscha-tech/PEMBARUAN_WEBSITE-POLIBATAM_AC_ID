import Link from 'next/link';
import SiteHeader from '@/components/SiteHeader';
import SiteFooter from '@/components/SiteFooter';
import MissedSection from '@/components/MissedSection';
import { apiGet } from '@/lib/api';

// Data berita di-cache 60 detik (ISR) supaya perpindahan halaman instan.
// Ubah ke `export const dynamic = 'force-dynamic';` kalau harus selalu segar.
export const revalidate = 60;

export const metadata = {
  title: 'Publikasi — Pusat P2M Polibatam',
  description: 'Arsip luaran penelitian dan pengabdian kepada masyarakat Pusat P2M Polibatam.',
};

export default async function PublikasiPage({ searchParams }) {
  const params = await searchParams;
  const tahun = params?.tahun ?? null;
  const response = await apiGet('/publikasi', { params: tahun ? { tahun } : {} });

  if (!response.ok) {
    return (
      <Shell>
        <div className="wide-inner py-16">
          <div className="border-l-4 border-amber-500 bg-amber-50 px-5 py-4 text-[#7c4a03]">
            <p className="font-extrabold">Tidak dapat memuat arsip publikasi</p>
            <p className="mt-1 text-[0.9rem]">
              {response.error} — pastikan backend berjalan: <code>cd backend &amp;&amp; php artisan serve</code>
            </p>
          </div>
        </div>
      </Shell>
    );
  }

  const payload = response.data.data ?? {};
  const menu = payload.menu ?? [];
  const active = payload.active ?? {};

  return (
    <Shell>
      <main className="bg-[#efefef] pb-6">
        <h1 className="wide-inner py-6 text-[clamp(2rem,3.5vw,3rem)] font-black tracking-[-0.04em] text-[#101926] uppercase">
          {active.label ?? `TAHUN ${tahun ?? ''}`}
        </h1>

        <nav aria-label="Arsip publikasi per tahun" className="wide-inner mb-6 flex flex-wrap gap-2">
          {menu.map((year) => (
            <Link
              key={year.key}
              href={year.href}
              aria-current={year.key === String(active.year) ? 'page' : undefined}
              className={`rounded-full px-4 py-2 text-[0.78rem] font-bold tracking-[0.02em] uppercase transition-colors ${
                year.key === String(active.year)
                  ? 'bg-[#1e6fd9] text-white'
                  : 'border border-[#c9d2de] bg-white text-[#3b4757] hover:bg-[#eaf1ff]'
              }`}
            >
              {year.label}
            </Link>
          ))}
        </nav>

        <article className="wide-inner mb-4 border-line bg-white p-6 md:p-8">
          {active.content ? (
            <>
              {/* Konten asli dari backend sudah memuat "Jumlah Pengunjung: xxx"
                  di bagian bawahnya, jadi tidak ditambahkan lagi di sini. */}
              <div
                className="publication-original-content"
                dangerouslySetInnerHTML={{ __html: active.content }}
              />
            </>
          ) : (
            <>
              <p>Konten publikasi untuk tahun {active.year} belum tersedia.</p>
              <div className="pb-2 text-[1.12rem] font-bold">
                Jumlah Pengunjung: {Number(active.visitors ?? 0).toLocaleString('en-US')}
              </div>
            </>
          )}
        </article>

        <MissedSection />
      </main>
    </Shell>
  );
}

function Shell({ children }) {
  return (
    <>
      <SiteHeader page="home" active="publikasi" />
      {children}
      <SiteFooter />
    </>
  );
}
