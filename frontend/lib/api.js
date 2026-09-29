/**
 * PENGHUBUNG FRONTEND ↔ BACKEND
 *
 * Satu-satunya tempat yang tahu alamat API Laravel. Halaman dan komponen
 * memanggil fungsi di sini, bukan fetch langsung — supaya alamat API cukup
 * diubah di .env.local, tidak tersebar di banyak file.
 *
 * Alur:
 *   Halaman Next.js → apiGet('/berita') → Laravel /api/berita → JSON
 */

/**
 * Alamat dasar API Laravel.
 *
 * Di server (Server Component) dipakai alamat lengkap, karena tidak ada
 * browser yang menerjemahkan path relatif.
 * Di browser dipakai path relatif ("/api") supaya lewat proxy Next.js dan
 * tidak kena blokir CORS.
 */
function baseUrl() {
  const isServer = typeof window === 'undefined';

  if (!isServer) {
    return '';
  }

  return (
    process.env.API_URL ??
    process.env.NEXT_PUBLIC_API_URL ??
    'http://127.0.0.1:8000/api'
  );
}

function buildUrl(path, params) {
  const base = baseUrl();
  const clean = path.startsWith('/') ? path : `/${path}`;

  // Di server, API_URL sudah memuat "/api"; di browser perlu ditambah.
  const prefix = base === '' ? '/api' : '';

  const url = new URL(`${base}${prefix}${clean}`, 'http://localhost');

  if (params) {
    Object.entries(params).forEach(([key, value]) => {
      if (value !== null && value !== undefined && value !== '') {
        url.searchParams.set(key, String(value));
      }
    });
  }

  return base === '' ? `${url.pathname}${url.search}` : url.toString();
}

/**
 * Permintaan GET.
 *
 * @param {string} path   contoh: '/berita'
 * @param {object} options { params, revalidate, timeout }
 * @returns {{ ok: boolean, status: number, data: any, error?: string }}
 */
export async function apiGet(path, { params = null, revalidate = 0, timeout = 10000 } = {}) {
  const url = buildUrl(path, params);

  try {
    const controller = new AbortController();
    const timer = setTimeout(() => controller.abort(), timeout);

    const response = await fetch(url, {
      headers: { Accept: 'application/json' },
      signal: controller.signal,
      ...(revalidate > 0 ? { next: { revalidate } } : { cache: 'no-store' }),
    });

    clearTimeout(timer);

    if (!response.ok) {
      return {
        ok: false,
        status: response.status,
        error: `API mengembalikan ${response.status}`,
      };
    }

    return { ok: true, status: response.status, data: await response.json() };
  } catch (error) {
    // Laravel mungkin belum dijalankan — kembalikan galat yang bisa ditampilkan
    // halaman, bukan melempar exception yang mematikan seluruh render.
    return {
      ok: false,
      status: 0,
      error:
        error?.name === 'AbortError'
          ? 'Permintaan ke API melebihi batas waktu.'
          : 'Tidak dapat terhubung ke API Laravel.',
    };
  }
}

/** Permintaan POST (tambah data). */
export async function apiPost(path, body, { timeout = 10000 } = {}) {
  return write('POST', buildUrl(path), body, timeout);
}

/** Permintaan PUT (ubah data). */
export async function apiPut(path, body, { timeout = 10000 } = {}) {
  return write('PUT', buildUrl(path), body, timeout);
}

/** Permintaan DELETE (hapus data). */
export async function apiDelete(path, { timeout = 10000 } = {}) {
  return write('DELETE', buildUrl(path), null, timeout);
}

async function write(method, url, body, timeout) {
  try {
    const controller = new AbortController();
    const timer = setTimeout(() => controller.abort(), timeout);

    const response = await fetch(url, {
      method,
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        // Laravel memakai cookie sesi; ini membuatnya ikut terkirim.
        ...(typeof window !== 'undefined' ? { 'X-Requested-With': 'XMLHttpRequest' } : {}),
      },
      credentials: 'include',
      body: body ? JSON.stringify(body) : undefined,
      signal: controller.signal,
    });

    clearTimeout(timer);

    const payload = await response.json().catch(() => ({}));

    if (!response.ok) {
      return {
        ok: false,
        status: response.status,
        error: payload?.message ?? `API mengembalikan ${response.status}`,
        errors: payload?.errors ?? null,
      };
    }

    return { ok: true, status: response.status, data: payload };
  } catch (error) {
    return {
      ok: false,
      status: 0,
      error:
        error?.name === 'AbortError'
          ? 'Permintaan melebihi batas waktu.'
          : 'Tidak dapat terhubung ke API Laravel.',
    };
  }
}