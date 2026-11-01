'use client';

/**
 * Sesi admin di sisi browser.
 *
 * Token login disimpan di localStorage dan dikirim sebagai header
 * Authorization pada setiap permintaan tulis. Semua permintaan tetap lewat
 * proxy Next.js (/api/...), jadi backend Laravel cukup diatur di .env.local.
 */

const TOKEN_KEY = 'p2m_admin_token';
const NAME_KEY = 'p2m_admin_name';

export function getToken() {
  if (typeof window === 'undefined') return null;
  return window.localStorage.getItem(TOKEN_KEY);
}

export function getAdminName() {
  if (typeof window === 'undefined') return '';
  return window.localStorage.getItem(NAME_KEY) ?? '';
}

export function saveSession(token, name) {
  window.localStorage.setItem(TOKEN_KEY, token);
  window.localStorage.setItem(NAME_KEY, name ?? '');
}

export function clearSession() {
  window.localStorage.removeItem(TOKEN_KEY);
  window.localStorage.removeItem(NAME_KEY);
}

/** Panggil API admin dengan token. */
export async function adminFetch(path, { method = 'GET', body = null } = {}) {
  const headers = { Accept: 'application/json' };

  const token = getToken();
  if (token) headers.Authorization = `Bearer ${token}`;

  const bodyIsFormData = body instanceof FormData;
  if (body && !bodyIsFormData) headers['Content-Type'] = 'application/json';

  const response = await fetch(`/api${path}`, {
    method,
    headers,
    body: body ? (bodyIsFormData ? body : JSON.stringify(body)) : undefined,
    cache: 'no-store',
  });

  const payload = await response.json().catch(() => ({}));

  if (!response.ok) {
    return {
      ok: false,
      status: response.status,
      message: payload?.message ?? `API mengembalikan ${response.status}`,
      errors: payload?.errors ?? null,
    };
  }

  return { ok: true, status: response.status, data: payload };
}
