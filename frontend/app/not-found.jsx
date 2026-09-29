/**
 * Komponen dasar — halaman 404.
 *
 * Dipakai Next.js otomatis untuk setiap alamat yang tidak ditemukan, dan
 * dipanggil manual lewat notFound() di halaman detail.
 */
import Link from 'next/link';

export default function NotFound() {
  return (
    <main className="grid min-h-screen place-items-center bg-[#0a1428] px-4 text-center">
      <div className="max-w-[520px]">
        <p className="text-[clamp(4rem,12vw,8rem)] leading-none font-black tracking-[-0.06em] text-[#f0c869]">
          404
        </p>

        <h1 className="mt-2 text-[clamp(1.4rem,3vw,2rem)] font-extrabold tracking-[-0.03em] text-white">
          Halaman tidak ditemukan
        </h1>

        <p className="mt-3 text-[0.95rem] leading-relaxed text-white/70">
          Alamat yang Anda tuju tidak tersedia atau sudah dipindahkan. Silakan kembali ke
          beranda atau telusuri berita terbaru.
        </p>

        <div className="mt-7 flex flex-wrap items-center justify-center gap-3">
          <Link
            href="/"
            className="inline-flex items-center gap-2 rounded bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] px-5 py-3 text-[0.78rem] font-extrabold tracking-[0.03em] text-white uppercase shadow-[0_8px_18px_rgba(29,122,230,0.28)] transition-transform hover:-translate-y-px"
          >
            &larr; Kembali ke Beranda
          </Link>

          <Link
            href="/berita"
            className="inline-flex items-center gap-2 rounded border border-white/25 px-5 py-3 text-[0.78rem] font-bold tracking-[0.03em] text-white uppercase transition-colors hover:bg-white/10"
          >
            Lihat Berita
          </Link>
        </div>
      </div>
    </main>
  );
}