import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

/** Alamat backend Laravel, dipakai untuk proxy dan gambar. */
const BACKEND = process.env.API_URL ?? 'http://127.0.0.1:8000/api';
const BACKEND_ORIGIN = BACKEND.replace(/\/api\/?$/, '');

/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,

  // Izinkan akses 127.0.0.1 saat pengembangan (mis. dari PowerShell/curl),
  // selain localhost yang sudah default. IP LAN ditambahkan agar server dev
  // bisa dibuka dari HP pada jaringan yang sama.
  allowedDevOrigins: ['127.0.0.1', 'localhost', '10.172.18.17', '192.168.56.1'],

  // Folder ini adalah root aplikasi. Tanpa ini Next menebak ke folder induk
  // hanya karena ada package-lock.json di sana.
  turbopack: {
    root: __dirname,
  },

  // Alias "@/..." -> folder frontend ini.
  webpack: (config) => {
    config.resolve.alias['@'] = __dirname;

    return config;
  },

  async rewrites() {
    // Browser memanggil /api/... ke Next.js, lalu diteruskan ke Laravel.
    // Dengan cara ini tidak ada permintaan lintas domain, jadi CORS tidak
    // perlu diutak-atik, dan alamat backend cukup diatur di .env.local.
    return [

      {
        source: '/api/:path*',
        destination: `${BACKEND}/:path*`,
      },
      {
        // Gambar hasil upload berita disimpan di backend (public/storage).
        source: '/storage/:path*',
        destination: `${BACKEND_ORIGIN}/storage/:path*`,
      },
      {
        // Gambar berita disimpan di backend (public/images).
        source: '/images/:path*',
        destination: `${BACKEND_ORIGIN}/images/:path*`,
      },
    ];
  },
};

export default nextConfig;