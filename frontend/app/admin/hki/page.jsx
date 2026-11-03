'use client';

import { useEffect, useState } from 'react';
import Link from 'next/link';
import AdminShell from '@/components/AdminShell';
import { Alert, Button, Empty, Loading, PageHead } from '@/components/AdminUI';
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
      <PageHead
        title="Kelola HKI"
        description="Arsip Hak Kekayaan Intelektual per tahun. Isi tabel di sini langsung tampil di halaman HKI tahun yang bersangkutan."
      >
        <div className="flex items-end gap-2">
          <div>
            <label htmlFor="tahun-baru" className="sr-only">
              Tahun baru
            </label>
            <input
              id="tahun-baru"
              type="number"
              value={newYear}
              onChange={(event) => setNewYear(event.target.value)}
              placeholder="2027"
              className="w-[110px] rounded border border-[#cfd8e3] px-3 py-2.5 text-[0.9rem]"
            />
          </div>
          <Button onClick={startNewYear}>+ Tambah Tahun</Button>
        </div>
      </PageHead>

      <Alert type={status.type === 'success' ? 'success' : 'error'} message={status.message} />

      {/* Form satu tahun */}
      {editYear !== null && (
        <section className="mb-6 rounded-lg border border-[#e8edf4] bg-white p-5">
          <div className="mb-4 flex flex-wrap items-end justify-between gap-3">
            <h2 className="text-[1.05rem] font-extrabold text-[#0b1d35]">
              HKI Tahun {editYear}
            </h2>

            <div>
              <label htmlFor="jumlah-pengunjung" className="mb-1 block text-[0.74rem] font-bold text-[#33445c] uppercase">
                Jumlah pengunjung
              </label>
              <input
                id="jumlah-pengunjung"
                type="number"
                min="0"
                value={views}
                onChange={(event) => setViews(event.target.value)}
                className="w-[140px] rounded border border-[#cfd8e3] px-3 py-2 text-[0.9rem]"
              />
            </div>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full border-collapse text-[0.86rem]">
              <thead>
                <tr className="bg-[#0b2138] text-left text-white">
                  <th className="w-8 px-2 py-2">No</th>
                  <th className="px-2 py-2">Judul *</th>
                  <th className="px-2 py-2">Jenis HKI</th>
                  <th className="px-2 py-2">Nama Pencipta</th>
                  <th className="px-2 py-2">Nomor Permohonan</th>
                  <th className="w-16 px-2 py-2" />
                </tr>
              </thead>
              <tbody>
                {daftar.length === 0 && (
                  <tr>
                    <td colSpan={6} className="px-2 py-4 text-center text-[#8894a6]">
                      Belum ada baris. Klik &quot;Tambah Baris&quot; di bawah.
                    </td>
                  </tr>
                )}

                {daftar.map((row, index) => (
                  <tr key={index} className={index % 2 ? 'bg-[#f7f9fc]' : 'bg-white'}>
                    <td className="px-2 py-2 text-center text-[#8894a6]">{index + 1}</td>
                    <td className="px-2 py-2">
                      <input
                        type="text"
                        value={row.judul}
                        onChange={(event) => updateRow(index, { judul: event.target.value })}
                        className="w-full min-w-[220px] rounded border border-[#cfd8e3] px-2 py-1.5"
                      />
                    </td>
                    <td className="px-2 py-2">
                      <input
                        type="text"
                        list="jenis-hki"
                        value={row.jenis}
                        onChange={(event) => updateRow(index, { jenis: event.target.value })}
                        className="w-full min-w-[170px] rounded border border-[#cfd8e3] px-2 py-1.5"
                      />
                    </td>
                    <td className="px-2 py-2">
                      <input
                        type="text"
                        value={row.pencipta}
                        onChange={(event) => updateRow(index, { pencipta: event.target.value })}
                        className="w-full min-w-[170px] rounded border border-[#cfd8e3] px-2 py-1.5"
                      />
                    </td>
                    <td className="px-2 py-2">
                      <input
                        type="text"
                        value={row.nomor}
                        onChange={(event) => updateRow(index, { nomor: event.target.value })}
                        className="w-full min-w-[150px] rounded border border-[#cfd8e3] px-2 py-1.5"
                      />
                    </td>
                    <td className="px-2 py-2 text-center">
                      <button
                        type="button"
                        onClick={() => removeRow(index)}
                        className="rounded px-2 py-1 text-[0.78rem] font-bold text-red-600 hover:bg-red-50"
                        title="Hapus baris"
                      >
                        Hapus
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>

          <datalist id="jenis-hki">
            {JENIS_UMUM.map((item) => (
              <option key={item} value={item} />
            ))}
          </datalist>

          <div className="mt-4 flex flex-wrap gap-2 border-t border-[#eef1f5] pt-4">
            <Button variant="outline" onClick={addRow}>
              + Tambah Baris
            </Button>
            <Button onClick={save} disabled={saving}>
              {saving ? 'Menyimpan…' : 'Simpan'}
            </Button>
            <Button variant="ghost" onClick={() => setEditYear(null)}>
              Batal
            </Button>
          </div>
        </section>
      )}

      {/* Daftar tahun */}
      {loading ? (
        <Loading text="Memuat data HKI…" />
      ) : years.length === 0 ? (
        <Empty title="Belum ada data HKI" hint="Tambahkan tahun terlebih dahulu." />
      ) : (
        <div className="overflow-x-auto rounded-lg border border-[#e8edf4] bg-white">
          <table className="w-full border-collapse text-[0.86rem]">
            <thead>
              <tr className="bg-[#0b2138] text-left text-white">
                <th className="px-3 py-2.5">Tahun</th>
                <th className="px-3 py-2.5">Jumlah Judul</th>
                <th className="px-3 py-2.5">Jenis</th>
                <th className="px-3 py-2.5">Pengunjung</th>
                <th className="px-3 py-2.5">Halaman Publik</th>
                <th className="px-3 py-2.5 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              {years.map((item, index) => (
                <tr key={item.year} className={index % 2 ? 'bg-[#f7f9fc]' : 'bg-white'}>
                  <td className="px-3 py-2.5 font-bold text-[#0b1d35]">HKI {item.year}</td>
                  <td className="px-3 py-2.5">
                    {item.total} judul
                    {item.total === 0 && (
                      <span className="ml-1 rounded bg-amber-100 px-1.5 py-0.5 text-[0.7rem] font-bold text-amber-800">
                        kosong
                      </span>
                    )}
                  </td>
                  <td className="px-3 py-2.5 text-[#6b7787]">
                    {item.jenis.length === 0 ? '—' : item.jenis.join(', ')}
                  </td>
                  <td className="px-3 py-2.5">{Number(item.views).toLocaleString('en-US')}</td>
                  <td className="px-3 py-2.5">
                    <Link
                      href={`/hki/tahun-${item.year}`}
                      target="_blank"
                      className="font-bold text-[#1266d2] hover:underline"
                    >
                      Lihat ↗
                    </Link>
                  </td>
                  <td className="px-3 py-2.5 text-right whitespace-nowrap">
                    <button
                      type="button"
                      onClick={() => openYear(item.year)}
                      className="rounded px-2.5 py-1 text-[0.78rem] font-bold text-[#1266d2] hover:bg-[#e7f0ff]"
                    >
                      Ubah
                    </button>
                    <button
                      type="button"
                      onClick={() => hapusTahun(item.year)}
                      className="rounded px-2.5 py-1 text-[0.78rem] font-bold text-red-600 hover:bg-red-50"
                    >
                      Hapus
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </AdminShell>
  );
}
