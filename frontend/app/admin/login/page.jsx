'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { getToken, saveSession, adminFetch } from '@/lib/adminSession';

/**
 * VIEW (client) — halaman masuk panel admin.
 *
 * Login ditangani backend Laravel (/api/auth/login) yang mengembalikan token;
 * token disimpan di browser lalu dipakai untuk semua aksi tulis.
 */
export default function AdminLoginPage() {
  const router = useRouter();
  const [username, setUsername] = useState('admin');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

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

  return (
    <main className="grid min-h-screen place-items-center bg-[#081d35] px-4 py-10">
      <div className="w-full max-w-[420px]">
        <div className="mb-6 text-center">
          <div className="mx-auto mb-3 grid size-14 place-items-center rounded-full bg-white/10 text-2xl font-black text-white">
            P2M
          </div>
          <h1 className="text-[1.5rem] font-black tracking-[-0.03em] text-white">
            Panel Admin P2M
          </h1>
          <p className="mt-1 text-[0.9rem] text-white/60">
            Masuk untuk mengelola berita dan isi beranda
          </p>
        </div>

        <form
          onSubmit={handleSubmit}
          className="rounded-lg border border-white/10 bg-white p-6 shadow-[0_18px_50px_rgba(0,0,0,0.35)]"
        >
          {error && (
            <div
              role="alert"
              className="mb-4 rounded border-l-4 border-red-500 bg-red-50 px-3 py-2 text-[0.88rem] text-red-700"
            >
              {error}
            </div>
          )}

          <label
            htmlFor="admin-username"
            className="mb-1.5 block text-[0.8rem] font-bold tracking-[0.02em] text-[#33445c] uppercase"
          >
            Nama pengguna
          </label>
          <input
            id="admin-username"
            type="text"
            value={username}
            onChange={(event) => setUsername(event.target.value)}
            autoComplete="username"
            required
            className="mb-4 w-full rounded border border-[#cfd8e3] px-3 py-2.5 text-[0.95rem] outline-none focus:border-[#1e6fd9] focus:ring-2 focus:ring-[#1e6fd9]/20"
          />

          <label
            htmlFor="admin-password"
            className="mb-1.5 block text-[0.8rem] font-bold tracking-[0.02em] text-[#33445c] uppercase"
          >
            Kata sandi
          </label>
          <input
            id="admin-password"
            type="password"
            value={password}
            onChange={(event) => setPassword(event.target.value)}
            autoComplete="current-password"
            required
            className="mb-5 w-full rounded border border-[#cfd8e3] px-3 py-2.5 text-[0.95rem] outline-none focus:border-[#1e6fd9] focus:ring-2 focus:ring-[#1e6fd9]/20"
          />

          <button
            type="submit"
            disabled={loading}
            className="w-full rounded bg-[#1e6fd9] px-4 py-3 text-[0.88rem] font-extrabold tracking-[0.02em] text-white uppercase transition-colors hover:bg-[#1558b0] disabled:cursor-not-allowed disabled:opacity-60"
          >
            {loading ? 'Memproses…' : 'Masuk'}
          </button>

          <p className="mt-4 text-center text-[0.82rem] text-[#6b7787]">
            <Link href="/" className="font-bold text-[#1e6fd9] hover:underline">
              ← Kembali ke website
            </Link>
          </p>
        </form>
      </div>
    </main>
  );
}
