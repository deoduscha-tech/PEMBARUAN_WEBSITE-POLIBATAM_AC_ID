'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { getToken, saveSession, adminFetch } from '@/lib/adminSession';
import Icon from '@/components/AdminIcons';

/**
 * VIEW (client) — halaman masuk panel admin.
 *
 * Tata letak dua kolom: panel kiri bergradasi dengan ornamen cahaya, panel
 * kanan berisi kartu form kaca (glassmorphism). Login ditangani backend
 * Laravel (/api/auth/login) yang mengembalikan token; token disimpan browser
 * lalu dipakai untuk semua aksi tulis.
 */

/* Keunggulan yang tampil di panel kiri. */
const HIGHLIGHTS = [
  {
    icon: 'shield',
    title: 'Aman & Terpercaya',
    desc: 'Autentikasi bertoken dan pembatasan percobaan masuk.',
  },
  {
    icon: 'settings',
    title: 'Mudah Digunakan',
    desc: 'Kelola berita, HKI, publikasi, dan profil tanpa menulis kode.',
  },
  {
    icon: 'layers',
    title: 'Terintegrasi',
    desc: 'Perubahan langsung tampil di website, satu sumber data.',
  },
];

/* Angka pencapaian yang berkedip lembut di panel kiri. */
const STATS = [
  { value: '10', label: 'Berita' },
  { value: '9', label: 'Tahun HKI' },
  { value: '17', label: 'Tahun Publikasi' },
];

function LogoPolibatam({ size = 'size-14' }) {
  return (
    // eslint-disable-next-line @next/next/no-img-element
    <img
      src="/images/logo-polibatam.png"
      alt="Polibatam"
      width={56}
      height={56}
      className={`${size} shrink-0 object-contain`}
    />
  );
}

/* Ikon dekoratif: cincin berputar lambat. */
function Orbit({ className }) {
  return (
    <div
      aria-hidden="true"
      className={`pointer-events-none absolute rounded-full border border-white/10 ${className}`}
    />
  );
}

export default function AdminLoginPage() {
  const router = useRouter();
  const [username, setUsername] = useState('admin');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const [capsLock, setCapsLock] = useState(false);

  // Sudah punya token? langsung ke dashboard.
  useEffect(() => {
    if (getToken()) router.replace('/admin');
  }, [router]);

  async function handleSubmit(event) {
    event.preventDefault();
    setError('');
    setLoading(true);

    const response = await adminFetch('/auth/login', {
      method: 'POST',
      body: { username, password },
    });

    setLoading(false);

    if (!response.ok) {
      setError(response.message);
      return;
    }

    saveSession(response.data.token, response.data.name);
    router.replace('/admin');
  }

  const inputBase =
    'peer h-[52px] w-full rounded-xl border border-slate-200 bg-white/90 pl-12 pr-12 text-[0.95rem] text-slate-800 outline-none transition-all duration-200 placeholder:text-slate-400 hover:border-slate-300 focus:border-[#1266d2] focus:bg-white focus:ring-4 focus:ring-[#1266d2]/12';

  return (
    <main className="relative flex min-h-screen overflow-hidden bg-[#0a1324]">
      {/* ================= Panel kiri ================= */}
      <aside className="relative hidden w-[46%] max-w-[620px] shrink-0 overflow-hidden lg:flex lg:flex-col">
        {/* Lapisan gradasi */}
        <div
          aria-hidden="true"
          className="absolute inset-0 bg-[radial-gradient(1200px_600px_at_-10%_-10%,rgba(59,130,246,0.35),transparent_55%),linear-gradient(160deg,#0b2547_0%,#0a1b33_45%,#060f1e_100%)]"
        />
        {/* Cahaya lembut */}
        <div
          aria-hidden="true"
          className="absolute -top-32 -left-24 size-[520px] rounded-full bg-[#2f8bf0]/25 blur-[120px]"
        />
        <div
          aria-hidden="true"
          className="absolute -right-28 bottom-[-10%] size-[440px] rounded-full bg-[#0ea5e9]/20 blur-[110px]"
        />
        {/* Kisi halus */}
        <div
          aria-hidden="true"
          className="absolute inset-0 opacity-[0.055]"
          style={{
            backgroundImage:
              'linear-gradient(to right, #fff 1px, transparent 1px), linear-gradient(to bottom, #fff 1px, transparent 1px)',
            backgroundSize: '46px 46px',
            maskImage: 'radial-gradient(ellipse at 30% 20%, #000 35%, transparent 75%)',
            WebkitMaskImage: 'radial-gradient(ellipse at 30% 20%, #000 35%, transparent 75%)',
          }}
        />
        {/* Ornamen cincin */}
        <Orbit className="top-[-140px] right-[-120px] size-[420px] border-[1.5px] border-white/[0.07]" />
        <Orbit className="top-[-90px] right-[-70px] size-[300px] border-white/[0.05]" />
        <Orbit className="bottom-[-180px] left-[-140px] size-[460px] border-white/[0.06]" />

        <div className="relative z-10 flex h-full flex-col px-12 py-11">
          {/* Merek */}
          <div className="flex items-center gap-3">
            <div className="grid size-[58px] place-items-center rounded-2xl bg-white/95 shadow-[0_10px_30px_rgba(0,0,0,0.35)] backdrop-blur">
              <LogoPolibatam size="size-11" />
            </div>
            <div className="leading-tight">
              <p className="text-[1.02rem] font-extrabold tracking-[-0.02em] text-white">
                Pusat P2M Polibatam
              </p>
              <p className="text-[0.72rem] font-semibold tracking-[0.14em] text-[#7fb6f0] uppercase">
                Panel Administrator
              </p>
            </div>
          </div>

          {/* Judul */}
          <div className="mt-auto">
            <span className="inline-flex items-center gap-2 rounded-full border border-[#3b82f6]/30 bg-[#3b82f6]/10 px-3 py-1 text-[0.7rem] font-bold tracking-[0.1em] text-[#9cc8f7] uppercase">
              <span className="size-1.5 animate-pulse rounded-full bg-[#5aa9ff]" />
              Sistem Pengelolaan
            </span>

            <h1 className="mt-6 text-[2.7rem] leading-[1.05] font-black tracking-[-0.04em] text-white">
              Kelola konten
              <br />
              <span className="bg-gradient-to-r from-[#8dc6ff] via-[#b9dcff] to-[#7db9f5] bg-clip-text text-transparent">
                dalam satu panel.
              </span>
            </h1>

            <p className="mt-5 max-w-[380px] text-[0.94rem] leading-relaxed text-slate-300/80">
              Berita, HKI, publikasi, dan profil website Pusat P2M — semuanya bisa diperbarui
              tanpa menyentuh kode.
            </p>

            {/* Statistik */}
            <div className="mt-8 flex gap-3">
              {STATS.map((stat) => (
                <div
                  key={stat.label}
                  className="flex-1 rounded-xl border border-white/10 bg-white/[0.06] px-3.5 py-3 backdrop-blur-sm"
                >
                  <p className="text-[1.35rem] leading-none font-black text-white">{stat.value}</p>
                  <p className="mt-1 text-[0.68rem] font-semibold tracking-[0.06em] text-slate-400 uppercase">
                    {stat.label}
                  </p>
                </div>
              ))}
            </div>
          </div>

          {/* Keunggulan */}
          <ul className="mt-9 space-y-3.5">
            {HIGHLIGHTS.map((item) => (
              <li key={item.title} className="flex items-start gap-3">
                <span className="mt-0.5 grid size-8 shrink-0 place-items-center rounded-lg border border-white/10 bg-white/[0.07] text-[#8dc6ff]">
                  <Icon name={item.icon} className="size-4" />
                </span>
                <span className="min-w-0">
                  <span className="block text-[0.86rem] font-bold text-white/95">{item.title}</span>
                  <span className="block text-[0.78rem] leading-relaxed text-slate-400">
                    {item.desc}
                  </span>
                </span>
              </li>
            ))}
          </ul>

          <p className="mt-auto pt-8 text-[0.72rem] text-slate-500">
            © {new Date().getFullYear()} Pusat P2M Politeknik Negeri Batam
          </p>
        </div>
      </aside>

      {/* ================= Panel kanan ================= */}
      <section className="relative flex flex-1 items-center justify-center px-4 py-10">
        {/* Latar terang dengan aksen biru */}
        <div
          aria-hidden="true"
          className="absolute inset-0 bg-[radial-gradient(900px_500px_at_85%_-10%,#e9f2ff_0%,transparent_60%),linear-gradient(180deg,#f7fafd_0%,#eef3f9_100%)]"
        />
        <div
          aria-hidden="true"
          className="pointer-events-none absolute top-10 right-14 hidden h-24 w-32 opacity-60 md:block"
          style={{
            backgroundImage: 'radial-gradient(#bed3ea 1.4px, transparent 1.4px)',
            backgroundSize: '17px 17px',
          }}
        />
        <Orbit className="right-[-160px] bottom-[-200px] size-[440px] border-slate-300/40" />

        <div className="relative z-10 w-full max-w-[430px]">
          {/* Logo di atas kartu (mobile) */}
          <div className="mb-7 flex justify-center lg:hidden">
            <LogoPolibatam size="size-16" />
          </div>

          <form
            onSubmit={handleSubmit}
            className="rounded-3xl border border-white/80 bg-white/85 px-8 py-9 shadow-[0_24px_70px_-20px_rgba(15,42,80,0.28)] backdrop-blur-xl"
          >
            <div className="mb-7">
              <div className="mb-4 flex items-center gap-2.5">
                <span className="grid size-9 place-items-center rounded-xl bg-gradient-to-br from-[#1266d2] to-[#0b3f8f] text-white shadow-[0_6px_16px_rgba(18,102,210,0.35)]">
                  <Icon name="shield" className="size-[18px]" />
                </span>
                <span className="text-[0.68rem] font-extrabold tracking-[0.16em] text-slate-400 uppercase">
                  Admin Access
                </span>
              </div>

              <h2 className="text-[1.6rem] leading-tight font-black tracking-[-0.03em] text-slate-900">
                Selamat datang kembali
              </h2>
              <p className="mt-1.5 text-[0.88rem] text-slate-500">
                Masuk untuk mengelola konten website P2M.
              </p>
            </div>

            {error && (
              <div
                role="alert"
                className="mb-5 flex items-start gap-2.5 rounded-xl border border-red-200 bg-red-50 px-3.5 py-3 text-[0.84rem] text-red-700"
              >
                <Icon name="x" className="mt-0.5 size-4 shrink-0" />
                <span>{error}</span>
              </div>
            )}

            {/* Nama pengguna */}
            <label
              htmlFor="admin-username"
              className="mb-2 block text-[0.74rem] font-extrabold tracking-[0.06em] text-slate-600 uppercase"
            >
              Nama Pengguna
            </label>
            <div className="relative mb-5">
              <Icon
                name="users"
                className="pointer-events-none absolute top-1/2 left-4 size-[18px] -translate-y-1/2 text-slate-400 peer-focus:text-[#1266d2]"
              />
              <input
                id="admin-username"
                type="text"
                value={username}
                onChange={(event) => setUsername(event.target.value)}
                autoComplete="username"
                placeholder="admin"
                required
                className={inputBase}
              />
            </div>

            {/* Kata sandi */}
            <label
              htmlFor="admin-password"
              className="mb-2 block text-[0.74rem] font-extrabold tracking-[0.06em] text-slate-600 uppercase"
            >
              Kata Sandi
            </label>
            <div className="relative mb-2">
              <Icon
                name="settings"
                className="pointer-events-none absolute top-1/2 left-4 size-[18px] -translate-y-1/2 text-slate-400"
              />
              <input
                id="admin-password"
                type={showPassword ? 'text' : 'password'}
                value={password}
                onChange={(event) => setPassword(event.target.value)}
                onKeyUp={(event) => {
                  if (typeof event.getModifierState === 'function') {
                    setCapsLock(event.getModifierState('CapsLock'));
                  }
                }}
                autoComplete="current-password"
                placeholder="••••••••"
                required
                className={inputBase}
              />
              <button
                type="button"
                onClick={() => setShowPassword((v) => !v)}
                aria-label={showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'}
                className="absolute top-1/2 right-3 -translate-y-1/2 rounded-lg p-1.5 text-slate-400 transition-colors hover:bg-slate-100 hover:text-[#1266d2]"
              >
                <Icon name="eye" className="size-[18px]" />
              </button>
            </div>

            {capsLock && (
              <p className="mb-3 flex items-center gap-1.5 text-[0.76rem] font-semibold text-amber-600">
                <Icon name="bell" className="size-3.5" />
                Caps Lock sedang aktif
              </p>
            )}

            <div className="mb-6 mt-4 flex items-center justify-between text-[0.8rem]">
              <label className="flex cursor-pointer items-center gap-2 text-slate-500">
                <input type="checkbox" className="size-4 rounded border-slate-300 accent-[#1266d2]" />
                Ingat saya
              </label>
              <Link href="/" className="font-bold text-[#1266d2] hover:underline">
                Lupa kata sandi?
              </Link>
            </div>

            <button
              type="submit"
              disabled={loading}
              className="group relative inline-flex h-[52px] w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-[#1266d2] via-[#1a74e0] to-[#0f56b3] text-[0.86rem] font-extrabold tracking-[0.08em] text-white uppercase shadow-[0_10px_26px_-6px_rgba(18,102,210,0.6)] transition-all duration-200 hover:shadow-[0_14px_32px_-6px_rgba(18,102,210,0.7)] disabled:cursor-not-allowed disabled:opacity-60"
            >
              <span className="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/25 to-transparent transition-transform duration-700 group-hover:translate-x-full" />
              {loading ? (
                <>
                  <span className="size-4 animate-spin rounded-full border-2 border-white/40 border-t-white" />
                  MEMPROSES…
                </>
              ) : (
                <>
                  <Icon name="shield" className="size-[16px]" />
                  Masuk ke Panel
                </>
              )}
            </button>

            <div className="my-6 flex items-center gap-3">
              <span className="h-px flex-1 bg-gradient-to-r from-transparent to-slate-200" />
              <span className="text-[0.74rem] font-semibold tracking-[0.08em] text-slate-400 uppercase">
                atau
              </span>
              <span className="h-px flex-1 bg-gradient-to-l from-transparent to-slate-200" />
            </div>

            <Link
              href="/"
              className="flex h-[46px] items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white text-[0.85rem] font-bold text-slate-600 transition-colors hover:border-[#1266d2]/40 hover:bg-[#f5f9ff] hover:text-[#1266d2]"
            >
              <Icon name="arrowUp" className="size-4 -rotate-90" strokeWidth={2.4} />
              Kembali ke Website
            </Link>
          </form>

          <p className="mt-6 text-center text-[0.76rem] text-slate-400">
            Dilindungi autentikasi bertoken · Panel khusus administrator
          </p>
        </div>
      </section>
    </main>
  );
}
