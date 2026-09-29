import { redirect } from 'next/navigation';

export const metadata = {
  title: 'Kelola Berita — Admin P2M',
};

/**
 * Panel admin diarahkan ke Laravel.
 *
 * Sebelumnya halaman ini memakai Model lokal (lib/berita.js). Sekarang data dan
 * autentikasi dimiliki backend, jadi pengelolaan konten dilakukan di panel admin
 * Laravel pada /admin — satu tempat untuk seluruh pengelolaan.
 *
 * Kalau nanti panel admin dibangun ulang di Next.js, endpoint auth + CRUD perlu
 * ditambahkan lebih dulu di backend (routes/api.php).
 */
export default function AdminBeritaPage() {
  const backend = process.env.BACKEND_ADMIN_URL ?? 'http://127.0.0.1:8000/admin';

  redirect(backend);
}