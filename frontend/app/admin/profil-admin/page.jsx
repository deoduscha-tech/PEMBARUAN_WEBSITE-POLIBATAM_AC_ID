'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import AdminShell from '@/components/AdminShell';
import Icon from '@/components/AdminIcons';
import { adminFetch } from '@/lib/adminSession';

/**
 * VIEW (client) — Profil Admin.
 *
 * Menampilkan data akun, ringkasan aktivitas, dan form ubah nama tampilan serta
 * ganti kata sandi. Data dari /api/admin/profil-admin.
 */

const TONES = {
  blue: 'bg-[#e8f1ff] text-[#1266d2]',
  green: 'bg-[#e6f7ee] text-[#0e8a4f]',
  amber: 'bg-[#fef4e3] text-[#b7791f]',
  violet: 'bg-[#efeafd] text-[#6d47d9]',
};

function Field({ id, label, value, onChange, type = 'text', placeholder, hint }) {
  return (
    <div>
      <label
        htmlFor={id}
        className="mb-1.5 block text-[0.74rem] font-extrabold tracking-[0.05em] text-[#5a6a80] uppercase"
      >
        {label}
      </label>
      <input
        id={id}
        type={type}
        value={value}
        onChange={(event) => onChange(event.target.value)}
        placeholder={placeholder}
        className="h-[42px] w-full rounded-lg border border-[#dbe3ee] px-3.5 text-[0.9rem] text-[#12203a] outline-none transition-colors placeholder:text-[#a6b2c2] focus:border-[#1266d2] focus:ring-3 focus:ring-[#1266d2]/12"
      />
      {hint && <p className="mt-1 text-[0.74rem] text-[#8894a6]">{hint}</p>}
    </div>
  );
}

function Panel({ title, desc, children }) {
  return (
    <section className="rounded-xl border border-[#e8edf4] bg-white p-5">
      <div className="mb-4 border-b border-[#f0f3f8] pb-3">
        <h2 className="text-[0.98rem] font-extrabold text-[#0b1d35]">{title}</h2>
        {desc && <p className="mt-0.5 text-[0.8rem] text-[#8894a6]">{desc}</p>}
      </div>
      {children}
    </section>
  );
}

export default function ProfilAdminPage() {
  const [data, setData] = useState(null);
  const [name, setName] = useState('');
  const [sandi, setSandi] = useState({ lama: '', baru: '', konfirmasi: '' });
  const [status, setStatus] = useState({ type: '', message: '' });
  const [saving, setSaving] = useState(false);

  useEffect(() => {
    adminFetch('/admin/profil-admin').then((response) => {
      if (!response.ok) {
        setStatus({ type: 'error', message: response.message });
        return;
      }

      setData(response.data.data);
      setName(response.data.data.name);
    });
  }, []);

  async function simpanNama(event) {
    event.preventDefault();
    setSaving(true);
    setStatus({ type: '', message: '' });

    const response = await adminFetch('/admin/profil-admin', {
      method: 'PUT',
      body: { name },
    });

    setSaving(false);

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      return;
    }

    setData((current) => ({ ...current, name }));
    setStatus({ type: 'ok', message: 'Nama tampilan berhasil diperbarui.' });
  }

  async function gantiSandi(event) {
    event.preventDefault();
    setSaving(true);
    setStatus({ type: '', message: '' });

    const response = await adminFetch('/admin/ganti-sandi', {
      method: 'POST',
      body: {
        sandi_lama: sandi.lama,
        sandi_baru: sandi.baru,
        konfirmasi: sandi.konfirmasi,
      },
    });

    setSaving(false);

    if (!response.ok) {
      const detail = response.errors ? Object.values(response.errors).flat().join(' ') : '';
      setStatus({ type: 'error', message: `${response.message} ${detail}`.trim() });
      return;
    }

    setSandi({ lama: '', baru: '', konfirmasi: '' });
    setStatus({ type: 'ok', message: response.data.message });
  }

  return (
    <AdminShell>
      <div className="mb-5">
        <nav
          aria-label="Breadcrumb"
          className="mb-1 flex items-center gap-1.5 text-[0.74rem] font-bold text-[#8894a6]"
        >
          <span>Admin</span>
          <span aria-hidden="true">/</span>
          <span className="text-[#33445c]">Profil Admin</span>
        </nav>
        <h1 className="text-[1.6rem] leading-tight font-black tracking-[-0.025em] text-[#0b1d35]">
          Profil Admin
        </h1>
        <p className="mt-1 text-[0.86rem] text-[#5b6675]">
          Informasi akun, aktivitas pengelolaan, dan keamanan panel admin.
        </p>
      </div>

      {status.message && (
        <div
          role={status.type === 'error' ? 'alert' : 'status'}
          className={`mb-4 flex items-start gap-2 rounded-lg border-l-4 px-4 py-3 text-[0.87rem] ${status.type === 'error'
              ? 'border-[#d92d20] bg-[#fef3f2] text-[#912018]'
              : 'border-[#12b76a] bg-[#ecfdf3] text-[#05603a]'
            }`}
        >
          <Icon name={status.type === 'error' ? 'x' : 'check'} className="mt-0.5 size-4 shrink-0" />
          <span>{status.message}</span>
        </div>
      )}

      {!data ? (
        <p className="text-[0.9rem] font-bold text-[#5b6675]">Memuat profil…</p>
      ) : (
        <div className="grid gap-4 xl:grid-cols-[minmax(0,340px)_minmax(0,1fr)]">
          {/* --- Kartu identitas --- */}
          <div className="flex flex-col gap-4">
            <section className="relative overflow-hidden rounded-xl border border-[#e8edf4] bg-white p-6 text-center">
              <div
                aria-hidden="true"
                className="absolute inset-x-0 top-0 h-20 bg-gradient-to-br from-[#1266d2] to-[#0b2f63]"
              />
              <div className="relative">
                <span className="mx-auto grid size-20 place-items-center rounded-full border-4 border-white bg-gradient-to-br from-[#2f8bf0] to-[#1266d2] text-[1.9rem] font-black text-white shadow-[0_6px_18px_rgba(18,102,210,0.35)]">
                  {data.avatar_initial}
                </span>
                <h2 className="mt-3 text-[1.06rem] font-extrabold text-[#0b1d35]">{data.name}</h2>
                <p className="mt-0.5 text-[0.82rem] text-[#8894a6]">@{data.username}</p>
                <span className="mt-2.5 inline-flex items-center gap-1.5 rounded-full bg-[#e8f1ff] px-3 py-1 text-[0.72rem] font-extrabold text-[#1266d2]">
                  <Icon name="shield" className="size-3.5" />
                  {data.role}
                </span>
              </div>

              <dl className="mt-5 space-y-2 border-t border-[#f0f3f8] pt-4 text-left">
                <div className="flex items-center justify-between text-[0.82rem]">
                  <dt className="flex items-center gap-1.5 text-[#8894a6]">
                    <Icon name="clock" className="size-3.5" /> Terakhir masuk
                  </dt>
                  <dd className="font-bold text-[#33445c]">{data.terakhir_masuk}</dd>
                </div>
                <div className="flex items-center justify-between text-[0.82rem]">
                  <dt className="flex items-center gap-1.5 text-[#8894a6]">
                    <Icon name="shield" className="size-3.5" /> Status akun
                  </dt>
                  <dd className="font-bold text-[#0e8a4f]">Aktif</dd>
                </div>
              </dl>
            </section>

            {/* Aktivitas */}
            <section className="rounded-xl border border-[#e8edf4] bg-white p-5">
              <h2 className="mb-3 text-[0.98rem] font-extrabold text-[#0b1d35]">Aktivitas</h2>
              <div className="grid grid-cols-2 gap-2.5">
                {[
                  { label: 'Total Berita', value: data.stats.total_berita, tone: 'blue' },
                  { label: 'Terbit', value: data.stats.terbit, tone: 'green' },
                  { label: 'Draf', value: data.stats.draft, tone: 'amber' },
                  { label: 'Total Dibaca', value: Number(data.stats.dibaca).toLocaleString('en-US'), tone: 'violet' },
                ].map((item) => (
                  <div key={item.label} className="rounded-lg border border-[#f0f3f8] p-3">
                    <p className="text-[0.68rem] font-bold tracking-[0.04em] text-[#8894a6] uppercase">
                      {item.label}
                    </p>
                    <p className={`mt-1.5 inline-block rounded px-1.5 text-[1.15rem] font-black ${TONES[item.tone]}`}>
                      {item.value}
                    </p>
                  </div>
                ))}
              </div>
            </section>
          </div>

          {/* --- Form kanan --- */}
          <div className="flex flex-col gap-4">
            <Panel title="Informasi Akun" desc="Nama ini tampil di topbar dan sapaan dashboard.">
              <form onSubmit={simpanNama} className="space-y-4">
                <Field id="nama" label="Nama tampilan" value={name} onChange={setName} />
                <Field
                  id="username"
                  label="Nama pengguna"
                  value={data.username}
                  onChange={() => { }}
                  hint="Nama pengguna tidak dapat diubah dari panel."
                />
                <button
                  type="submit"
                  disabled={saving}
                  className="inline-flex items-center gap-2 rounded-lg bg-[#1266d2] px-4 py-2.5 text-[0.82rem] font-extrabold text-white hover:bg-[#0f56b3] disabled:opacity-60"
                >
                  <Icon name="check" className="size-4" strokeWidth={2.4} />
                  Simpan Perubahan
                </button>
              </form>
            </Panel>

            <Panel title="Keamanan" desc="Ganti kata sandi akun administrator.">
              <form onSubmit={gantiSandi} className="space-y-4">
                <Field
                  id="sandi-lama"
                  label="Kata sandi saat ini"
                  type="password"
                  value={sandi.lama}
                  onChange={(v) => setSandi({ ...sandi, lama: v })}
                />
                <div className="grid gap-4 sm:grid-cols-2">
                  <Field
                    id="sandi-baru"
                    label="Kata sandi baru"
                    type="password"
                    value={sandi.baru}
                    onChange={(v) => setSandi({ ...sandi, baru: v })}
                    hint="Minimal 8 karakter."
                  />
                  <Field
                    id="konfirmasi"
                    label="Ulangi kata sandi baru"
                    type="password"
                    value={sandi.konfirmasi}
                    onChange={(v) => setSandi({ ...sandi, konfirmasi: v })}
                  />
                </div>
                <button
                  type="submit"
                  disabled={saving}
                  className="inline-flex items-center gap-2 rounded-lg bg-[#0b2138] px-4 py-2.5 text-[0.82rem] font-extrabold text-white hover:bg-[#12304f] disabled:opacity-60"
                >
                  <Icon name="shield" className="size-4" />
                  Perbarui Kata Sandi
                </button>
              </form>
            </Panel>

            <Panel title="Perlu Perhatian">
              <ul className="space-y-2.5">
                {[
                  {
                    icon: 'berita',
                    text: `${data.perhatian.draft} berita masih draf`,
                    href: '/admin/berita',
                    tone: 'amber',
                  },
                  {
                    icon: 'hki',
                    text: `${data.perhatian.hki_tahun} tahun data HKI tersedia`,
                    href: '/admin/hki',
                    tone: 'blue',
                  },
                  {
                    icon: 'publikasi',
                    text: `${data.perhatian.publikasi_tahun} tahun data publikasi tersedia`,
                    href: '/admin/publikasi',
                    tone: 'violet',
                  },
                ].map((item) => (
                  <li key={item.text}>
                    <Link
                      href={item.href}
                      className="flex items-center gap-3 rounded-lg border border-[#f0f3f8] px-3.5 py-2.5 transition-colors hover:border-[#c7dcf7] hover:bg-[#f8fbff]"
                    >
                      <span className={`grid size-8 shrink-0 place-items-center rounded-lg ${TONES[item.tone]}`}>
                        <Icon name={item.icon} className="size-4" />
                      </span>
                      <span className="flex-1 text-[0.85rem] font-semibold text-[#33445c]">
                        {item.text}
                      </span>
                      <Icon name="external" className="size-3.5 text-[#b9c2cf]" />
                    </Link>
                  </li>
                ))}
              </ul>
            </Panel>
          </div>
        </div>
      )}
    </AdminShell>
  );
}
