'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import AdminShell from '@/components/AdminShell';
import { Alert } from '@/components/AdminUI';
import Icon from '@/components/AdminIcons';
import { adminFetch } from '@/lib/adminSession';

/**
 * VIEW (client) — kelola arsip HKI per tahun.
 *
 * Yang bisa dilakukan:
 *   - melihat semua tahun beserta jumlah judul & pengunjung
 *   - menambah tahun baru
 *   - mengubah/menghapus baris HKI (judul, jenis, pencipta, nomor permohonan)
 *   - mengatur jumlah pengunjung tahun tersebut
 *
 * Data: /api/admin/hki (GET), /api/admin/hki/{tahun} (GET/POST/DELETE).
 */

const JENIS_UMUM = [
  'Hak Cipta – Karya Tulis/ Buku',
  'Hak Cipta – Program Komputer',
  'Hak Cipta – Karya Seni',
  'Paten',
  'Paten Sederhana',
  'Desain Industri',
  'Merek',
  'Desain Tata Letak Sirkuit Terpadu',
];

const KOSONG = { judul: '', jenis: 'Hak Cipta – Karya Tulis/ Buku', pencipta: '', nomor: '' };

export default function AdminHkiPage() {
  const [years, setYears] = useState([]);
  const [loading, setLoading] = useState(true);
  const [status, setStatus] = useState({ type: '', message: '' });
  const [saving, setSaving] = useState(false);

  // Form tahun yang sedang dibuka
  const [editYear, setEditYear] = useState(null);
  const [views, setViews] = useState('0');
  const [daftar, setDaftar] = useState([]);
  const [newYear, setNewYear] = useState('');

  async function load() {
    setLoading(true);
    const response = await adminFetch('/admin/hki');

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      setLoading(false);
      return;
    }

    setYears(response.data.data);
    setLoading(false);
  }

  useEffect(() => {
    load();
  }, []);

  async function openYear(year) {
    const response = await adminFetch(`/admin/hki/${year}`);

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      return;
    }

    setEditYear(year);
    setViews(String(response.data.data.views ?? 0));
    setDaftar(response.data.data.daftar ?? []);
    setStatus({ type: '', message: '' });
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function startNewYear() {
    const value = Number(newYear);

    if (!value || value < 2000 || value > 2100) {
      setStatus({ type: 'error', message: 'Masukkan tahun yang valid (contoh: 2027).' });
      return;
    }

    if (years.some((item) => item.year === value)) {
      setStatus({ type: 'error', message: `Tahun ${value} sudah ada.` });
      return;
    }

    setEditYear(value);
    setViews('0');
    setDaftar([{ ...KOSONG }]);
    setNewYear('');
    setStatus({ type: '', message: '' });
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function updateRow(index, changes) {
    setDaftar((current) =>
      current.map((row, i) => (i === index ? { ...row, ...changes } : row)),
    );
  }

  function addRow() {
    setDaftar((current) => [...current, { ...KOSONG }]);
  }

  function removeRow(index) {
    setDaftar((current) => current.filter((_, i) => i !== index));
  }

  async function save() {
    setSaving(true);
    setStatus({ type: '', message: '' });

    const bersih = daftar.filter((row) => row.judul.trim() !== '');

    const response = await adminFetch(`/admin/hki/${editYear}`, {
      method: 'POST',
      body: {
        views: Number(views) || 0,
        show_summary: true,
        daftar: bersih,
      },
    });

    setSaving(false);

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      return;
    }

    setStatus({ type: 'success', message: `HKI tahun ${editYear} disimpan (${bersih.length} judul).` });
    setEditYear(null);
    await load();
  }

  async function hapusTahun(year) {
    const yakin = window.confirm(
      `Hapus seluruh data HKI tahun ${year}? Tindakan ini tidak bisa dibatalkan.`,
    );
    if (!yakin) return;

    const response = await adminFetch(`/admin/hki/${year}`, { method: 'DELETE' });

    if (!response.ok) {
      setStatus({ type: 'error', message: response.message });
      return;
    }

    setStatus({ type: 'success', message: `Data HKI tahun ${year} dihapus.` });
    if (editYear === year) setEditYear(null);
    await load();
  }

  return (
    <AdminShell>
      {/* Judul halaman */}
      <div className="mb-6 flex flex-wrap items-end justify-between gap-3">
        <div>
          <nav aria-label="Breadcrumb" className="mb-1.5 flex items-center gap-1.5 text-[0.72rem] font-bold text-[#9aa7b8]">
            <span>Admin</span>
            <span aria-hidden="true">/</span>
            <span className="text-[#33445c]">Kelola HKI</span>
          </nav>
          <h1 className="text-[1.65rem] leading-tight font-black tracking-[-0.03em] text-[#0b1d35]">
            Kelola HKI
          </h1>
          <p className="mt-1 max-w-[70ch] text-[0.86rem] text-[#7b8798]">
            Data Hak Kekayaan Intelektual per tahun. Apa yang diisi di sini langsung tampil di
            halaman HKI tahun tersebut.
          </p>
        </div>
      </div>

      {/* Panduan singkat: 3 langkah */}
      <div className="mb-5 grid gap-3 sm:grid-cols-3">
        {[
          { no: '1', title: 'Pilih tahun', desc: 'Klik “Ubah” pada tahun yang ingin diisi.' },
          { no: '2', title: 'Isi data HKI', desc: 'Tulis judul, jenis, pencipta, dan nomor permohonan.' },
          { no: '3', title: 'Simpan', desc: 'Perubahan langsung tampil di website.' },
        ].map((step) => (
          <div
            key={step.no}
            className="flex items-start gap-3 rounded-xl border border-[#e8edf4] bg-white p-4"
          >
            <span className="grid size-7 shrink-0 place-items-center rounded-full bg-[#e8f1ff] text-[0.76rem] font-black text-[#1266d2]">
              {step.no}
            </span>
            <div className="min-w-0">
              <p className="text-[0.84rem] font-extrabold text-[#0b1d35]">{step.title}</p>
              <p className="mt-0.5 text-[0.76rem] leading-snug text-[#8894a6]">{step.desc}</p>
            </div>
          </div>
        ))}
      </div>

      <Alert type={status.type === 'success' ? 'success' : 'error'} message={status.message} />

      {/* Ringkasan angka */}
      {!loading && years.length > 0 && (
        <div className="mb-5 grid gap-3 sm:grid-cols-3">
          {[
            { label: 'Tahun terdata', value: years.length, hint: 'tahun arsip HKI' },
            {
              label: 'Total judul',
              value: years.reduce((total, item) => total + item.total, 0),
              hint: 'seluruh karya terdaftar',
            },
            {
              label: 'Total pengunjung',
              value: years.reduce((total, item) => total + Number(item.views || 0), 0).toLocaleString('en-US'),
              hint: 'akumulasi seluruh tahun',
            },
          ].map((card) => (
            <div key={card.label} className="rounded-xl border border-[#e8edf4] bg-white px-5 py-4">
              <p className="text-[0.72rem] font-bold tracking-[0.05em] text-[#9aa7b8] uppercase">
                {card.label}
              </p>
              <p className="mt-1.5 text-[1.6rem] leading-none font-black text-[#0b1d35]">
                {card.value}
              </p>
              <p className="mt-1.5 text-[0.74rem] text-[#8894a6]">{card.hint}</p>
            </div>
          ))}
        </div>
      )}

      {/* Form satu tahun */}
      {editYear !== null && (
        <section className="mb-6 rounded-2xl border border-[#bcd7f8] bg-white p-6 shadow-[0_10px_30px_-18px_rgba(18,102,210,0.35)]">
          <div className="mb-5 flex flex-wrap items-center justify-between gap-3 border-b border-[#f0f3f8] pb-4">
            <div className="flex items-center gap-3">
              <span className="grid size-10 place-items-center rounded-xl bg-[#e8f1ff] text-[#1266d2]">
                <Icon name="hki" className="size-5" />
              </span>
              <div>
                <h2 className="text-[1.05rem] leading-tight font-extrabold text-[#0b1d35]">
                  HKI Tahun {editYear}
                </h2>
                <p className="text-[0.78rem] text-[#8894a6]">
                  {daftar.length} baris · kolom bertanda * wajib diisi
                </p>
              </div>
            </div>

            <div>
              <label htmlFor="jumlah-pengunjung" className="mb-1 block text-[0.72rem] font-bold text-[#33445c] uppercase">
                Jumlah pengunjung
              </label>
              <input
                id="jumlah-pengunjung"
                type="number"
                min="0"
                value={views}
                onChange={(event) => setViews(event.target.value)}
                className="h-9 w-[140px] rounded-lg border border-[#dbe3ee] px-3 text-[0.88rem] outline-none focus:border-[#1266d2]"
              />
            </div>
          </div>

          <div className="overflow-hidden rounded-xl border border-[#e8edf4]">
            <div className="overflow-x-auto">
              <table className="w-full border-collapse text-[0.86rem]">
                <thead>
                  <tr className="border-b border-[#eef2f7] bg-[#f8fafc] text-left text-[0.72rem] font-extrabold tracking-[0.05em] text-[#7b8798] uppercase">
                    <th className="w-10 px-3 py-2.5">No</th>
                    <th className="px-3 py-2.5">Judul karya *</th>
                    <th className="px-3 py-2.5">Jenis HKI</th>
                    <th className="px-3 py-2.5">Nama pencipta</th>
                    <th className="px-3 py-2.5">No. permohonan</th>
                    <th className="w-12 px-3 py-2.5" />
                  </tr>
                </thead>
                <tbody>
                  {daftar.length === 0 && (
                    <tr>
                      <td colSpan={6} className="px-3 py-8 text-center text-[0.85rem] text-[#8894a6]">
                        Belum ada baris. Klik “Tambah baris” di bawah untuk mulai mengisi.
                      </td>
                    </tr>
                  )}

                  {daftar.map((row, index) => (
                    <tr key={index} className="border-b border-[#f4f6fa] last:border-b-0">
                      <td className="px-3 py-2 text-center text-[0.78rem] font-bold text-[#9aa7b8]">
                        {index + 1}
                      </td>
                      <td className="px-3 py-2">
                        <input
                          type="text"
                          value={row.judul}
                          onChange={(event) => updateRow(index, { judul: event.target.value })}
                          placeholder="Judul karya…"
                          className="h-9 w-full min-w-[220px] rounded-lg border border-[#dbe3ee] px-2.5 text-[0.86rem] outline-none focus:border-[#1266d2]"
                        />
                      </td>
                      <td className="px-3 py-2">
                        <input
                          type="text"
                          list="jenis-hki"
                          value={row.jenis}
                          onChange={(event) => updateRow(index, { jenis: event.target.value })}
                          className="h-9 w-full min-w-[170px] rounded-lg border border-[#dbe3ee] px-2.5 text-[0.86rem] outline-none focus:border-[#1266d2]"
                        />
                      </td>
                      <td className="px-3 py-2">
                        <input
                          type="text"
                          value={row.pencipta}
                          onChange={(event) => updateRow(index, { pencipta: event.target.value })}
                          placeholder="Nama lengkap"
                          className="h-9 w-full min-w-[170px] rounded-lg border border-[#dbe3ee] px-2.5 text-[0.86rem] outline-none focus:border-[#1266d2]"
                        />
                      </td>
                      <td className="px-3 py-2">
                        <input
                          type="text"
                          value={row.nomor}
                          onChange={(event) => updateRow(index, { nomor: event.target.value })}
                          placeholder="Nomor pendaftaran"
                          className="h-9 w-full min-w-[150px] rounded-lg border border-[#dbe3ee] px-2.5 text-[0.86rem] outline-none focus:border-[#1266d2]"
                        />
                      </td>
                      <td className="px-3 py-2 text-center">
                        <button
                          type="button"
                          onClick={() => removeRow(index)}
                          aria-label={`Hapus baris ${index + 1}`}
                          className="grid size-8 place-items-center rounded-lg border border-[#e2e8f0] text-[#5b6675] transition-colors hover:border-[#f6c6c1] hover:bg-[#fef3f2] hover:text-[#d92d20]"
                        >
                          <Icon name="trash" className="size-4" />
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>

          <datalist id="jenis-hki">
            {JENIS_UMUM.map((item) => (
              <option key={item} value={item} />
            ))}
          </datalist>

          <div className="mt-5 flex flex-wrap items-center gap-2 border-t border-[#f0f3f8] pt-4">
            <button
              type="button"
              onClick={addRow}
              className="inline-flex items-center gap-2 rounded-xl border border-[#dbe3ee] bg-white px-4 py-2.5 text-[0.82rem] font-bold text-[#33445c] hover:bg-[#f7fafd]"
            >
              <Icon name="plus" className="size-4" /> Tambah baris
            </button>
            <button
              type="button"
              onClick={save}
              disabled={saving}
              className="inline-flex items-center gap-2 rounded-xl bg-[#1266d2] px-4 py-2.5 text-[0.82rem] font-extrabold text-white shadow-[0_6px_18px_-4px_rgba(18,102,210,0.55)] hover:bg-[#0f56b3] disabled:opacity-60"
            >
              <Icon name="check" className="size-4" strokeWidth={2.4} />
              {saving ? 'Menyimpan…' : 'Simpan HKI'}
            </button>
            <button
              type="button"
              onClick={() => setEditYear(null)}
              className="ml-auto rounded-xl px-4 py-2.5 text-[0.82rem] font-bold text-[#5b6675] hover:bg-[#f3f6fa]"
            >
              Batal
            </button>
          </div>
        </section>
      )}

      {/* Daftar tahun */}
      <section className="rounded-xl border border-[#e8edf4] bg-white">
        <div className="flex flex-wrap items-center justify-between gap-3 border-b border-[#f0f3f8] px-5 py-4">
          <div>
            <h2 className="text-[0.98rem] font-extrabold text-[#0b1d35]">Daftar Tahun</h2>
            <p className="text-[0.78rem] text-[#8894a6]">
              Klik “Ubah” untuk mengisi data tahun tersebut.
            </p>
          </div>

          <div className="flex items-end gap-2">
            <div>
              <label htmlFor="tahun-baru" className="sr-only">Tahun baru</label>
              <input
                id="tahun-baru"
                type="number"
                value={newYear}
                onChange={(event) => setNewYear(event.target.value)}
                placeholder="2027"
                className="h-9 w-[100px] rounded-lg border border-[#dbe3ee] px-3 text-[0.88rem] outline-none focus:border-[#1266d2]"
              />
            </div>
            <button
              type="button"
              onClick={startNewYear}
              className="inline-flex h-9 items-center gap-1.5 rounded-lg bg-[#0b2138] px-3.5 text-[0.8rem] font-bold text-white hover:bg-[#12304f]"
            >
              <Icon name="plus" className="size-3.5" strokeWidth={2.4} /> Tambah tahun
            </button>
          </div>
        </div>

        {loading ? (
          <p className="px-5 py-8 text-center text-[0.88rem] font-bold text-[#8894a6]">
            Memuat data HKI…
          </p>
        ) : years.length === 0 ? (
          <p className="px-5 py-10 text-center text-[0.88rem] text-[#8894a6]">
            Belum ada data HKI. Masukkan tahun lalu klik “Tambah tahun”.
          </p>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full border-collapse text-[0.86rem]">
              <thead>
                <tr className="border-b border-[#eef2f7] bg-[#f8fafc] text-left text-[0.72rem] font-extrabold tracking-[0.05em] text-[#7b8798] uppercase">
                  <th className="px-5 py-3">Tahun</th>
                  <th className="px-3 py-3">Jumlah judul</th>
                  <th className="px-3 py-3">Jenis karya</th>
                  <th className="px-3 py-3 text-right">Pengunjung</th>
                  <th className="px-3 py-3">Halaman publik</th>
                  <th className="px-5 py-3 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody>
                {years.map((item) => (
                  <tr
                    key={item.year}
                    className={`border-b border-[#f4f6fa] transition-colors last:border-b-0 hover:bg-[#fafcff] ${
                      editYear === item.year ? 'bg-[#f5f9ff]' : ''
                    }`}
                  >
                    <td className="px-5 py-3.5">
                      <span className="text-[0.92rem] font-extrabold text-[#0b1d35]">
                        {item.year}
                      </span>
                    </td>
                    <td className="px-3 py-3.5">
                      {item.total > 0 ? (
                        <span className="rounded-md bg-[#e8f1ff] px-2 py-0.5 text-[0.78rem] font-bold text-[#1266d2]">
                          {item.total} judul
                        </span>
                      ) : (
                        <span className="rounded-md bg-[#fef4e3] px-2 py-0.5 text-[0.78rem] font-bold text-[#b7791f]">
                          Belum diisi
                        </span>
                      )}
                    </td>
                    <td className="max-w-[280px] px-3 py-3.5 text-[0.8rem] text-[#7b8798]">
                      {item.jenis.length === 0 ? '—' : item.jenis.join(', ')}
                    </td>
                    <td className="px-3 py-3.5 text-right font-bold text-[#546479]">
                      {Number(item.views).toLocaleString('en-US')}
                    </td>
                    <td className="px-3 py-3.5">
                      <Link
                        href={`/hki/tahun-${item.year}`}
                        target="_blank"
                        className="inline-flex items-center gap-1 text-[0.8rem] font-bold text-[#1266d2] hover:underline"
                      >
                        Lihat <Icon name="external" className="size-3" />
                      </Link>
                    </td>
                    <td className="px-5 py-3.5 text-right whitespace-nowrap">
                      <div className="inline-flex gap-1">
                        <button
                          type="button"
                          onClick={() => openYear(item.year)}
                          className="inline-flex items-center gap-1.5 rounded-lg border border-[#e2e8f0] px-3 py-1.5 text-[0.78rem] font-bold text-[#33445c] transition-colors hover:border-[#bcd7f8] hover:bg-[#f2f8ff] hover:text-[#1266d2]"
                        >
                          <Icon name="edit" className="size-3.5" /> Ubah
                        </button>
                        <button
                          type="button"
                          onClick={() => hapusTahun(item.year)}
                          aria-label={`Hapus tahun ${item.year}`}
                          className="grid size-8 place-items-center rounded-lg border border-[#e2e8f0] text-[#5b6675] transition-colors hover:border-[#f6c6c1] hover:bg-[#fef3f2] hover:text-[#d92d20]"
                        >
                          <Icon name="trash" className="size-3.5" />
                        </button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </section>
    </AdminShell>
  );
}
