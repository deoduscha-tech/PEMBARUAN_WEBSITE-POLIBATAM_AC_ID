import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

/** Alamat backend Laravel, dipakai untuk proxy dan gambar. */
const BACKEND = process.env.API_URL ?? 'http://127.0.0.1:8000/api';
const BACKEND_ORIGIN = BACKEND.replace(/\/api\/?$/, '');

/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,

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
        // Gambar berita disimpan di backend (public/images).
        source: '/images/:path*',
        destination: `${BACKEND_ORIGIN}/images/:path*`,
      },
    ];
  },
};

export default nextConfig;