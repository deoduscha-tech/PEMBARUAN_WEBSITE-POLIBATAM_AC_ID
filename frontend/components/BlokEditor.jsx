'use client';

import Icon from '@/components/AdminIcons';

/**
 * VIEW (client) — editor blok konten tanpa HTML.
 *
 * Admin cukup menambah blok lalu memilih jenisnya:
 *   heading     -> judul kecil (h3)
 *   paragraf    -> teks biasa
 *   daftar      -> butir-butir (satu butir per baris)
 *   tautan      -> kumpulan tautan (teks + URL)
 *   tabel       -> baris data sederhana
 *   gambar      -> gambar dengan keterangan
 *
 * Semua blok disimpan sebagai JSON terstruktur, bukan HTML, sehingga admin
 * tidak perlu tahu kode apa pun.
 */

export const BLOK_TIPE = [
  { value: 'paragraf', label: 'Paragraf', icon: 'berita' },
  { value: 'heading', label: 'Sub Judul', icon: 'arrowUp' },
  { value: 'seksi', label: 'Judul Kategori', icon: 'layers' },
  { value: 'daftar', label: 'Daftar Butir', icon: 'layers' },
  { value: 'tautan', label: 'Daftar Tautan', icon: 'external' },
  { value: 'tabel', label: 'Tabel', icon: 'chart' },
  { value: 'gambar', label: 'Gambar', icon: 'eye' },
];

/** Blok baru dengan isi kosong sesuai jenisnya. */
export function blokBaru(tipe = 'paragraf') {
  const id = `b${Date.now()}${Math.floor(Math.random() * 1000)}`;

  switch (tipe) {
    case 'heading':
      return { id, tipe, teks: '' };
    case 'seksi':
      return { id, tipe, judul: '' };
    case 'daftar':
      return { id, tipe, items: [''] };
    case 'tautan':
      return { id, tipe, items: [{ label: '', url: '' }] };
    case 'tabel':
      return { id, tipe, kolom: ['Kolom 1', 'Kolom 2'], baris: [['', '']] };
    case 'gambar':
      return { id, tipe, url: '', caption: '' };
    default:
      return { id, tipe: 'paragraf', teks: '' };
  }
}

const inputCls =
  'w-full rounded-lg border border-[#dbe3ee] px-3 py-2 text-[0.9rem] text-[#12203a] outline-none transition-colors placeholder:text-[#a6b2c2] focus:border-[#1266d2] focus:ring-3 focus:ring-[#1266d2]/12';

function TombolKecil({ onClick, children, tone = 'blue' }) {
  const tones = {
    blue: 'text-[#1266d2] hover:bg-[#eaf2ff]',
    red: 'text-[#d92d20] hover:bg-[#fef3f2]',
  };

  return (
    <button
      type="button"
      onClick={onClick}
      className={`inline-flex items-center gap-1 rounded px-2 py-1 text-[0.76rem] font-bold transition-colors ${tones[tone]}`}
    >
      {children}
    </button>
  );
}

/** Editor satu blok. */
function BlokItem({ blok, index, total, onChange, onRemove, onMove }) {
  const ubah = (patch) => onChange({ ...blok, ...patch });

  return (
    <div className="rounded-lg border border-[#e8edf4] bg-white">
      {/* Kepala blok */}
      <div className="flex items-center gap-2 border-b border-[#f0f3f8] px-3 py-2">
        <span className="rounded bg-[#eef2f7] px-1.5 py-0.5 text-[0.66rem] font-black text-[#6b7787] uppercase">
          {BLOK_TIPE.find((t) => t.value === blok.tipe)?.label ?? blok.tipe}
        </span>

        <div className="ml-auto flex items-center gap-0.5">
          <TombolKecil onClick={() => onMove(index, -1)} title="Naikkan">
            <span className={index === 0 ? 'opacity-30' : ''}>↑</span>
          </TombolKecil>
          <TombolKecil onClick={() => onMove(index, 1)}>
            <span className={index === total - 1 ? 'opacity-30' : ''}>↓</span>
          </TombolKecil>
          <TombolKecil onClick={() => onRemove(index)} tone="red">
            <Icon name="trash" className="size-3.5" />
          </TombolKecil>
        </div>
      </div>

      <div className="p-3">
        {blok.tipe === 'heading' && (
          <input
            className={inputCls}
            value={blok.teks ?? ''}
            placeholder="Tulis sub judul…"
            onChange={(e) => ubah({ teks: e.target.value })}
          />
        )}

        {blok.tipe === 'seksi' && (
          <input
            className={`${inputCls} font-bold`}
            value={blok.judul ?? ''}
            placeholder="Contoh: A. Publikasi Jurnal Internasional"
            onChange={(e) => ubah({ judul: e.target.value })}
          />
        )}

        {blok.tipe === 'paragraf' && (
          <textarea
            className={`${inputCls} leading-relaxed`}
            rows={4}
            value={blok.teks ?? ''}
            placeholder="Tulis isi paragraf…"
            onChange={(e) => ubah({ teks: e.target.value })}
          />
        )}

        {blok.tipe === 'daftar' && (
          <div className="space-y-3">
            {(blok.items ?? []).map((item, i) => {
              // Butir bisa berupa teks biasa atau { teks, url }.
              const teks = typeof item === 'string' ? item : item?.teks ?? '';
              const url = typeof item === 'object' && item ? item.url ?? '' : '';

              const ubahButir = (patch) => {
                const items = [...blok.items];
                items[i] =
                  typeof items[i] === 'string'
                    ? { teks: items[i], url: '', ...patch }
                    : { ...items[i], ...patch };
                ubah({ items });
              };

              return (
                <div key={i} className="rounded-lg border border-[#eef2f7] bg-[#fbfcfe] p-2.5">
                  <div className="flex items-start gap-2">
                    <span className="mt-2 shrink-0 text-[0.8rem] font-bold text-[#8894a6]">
                      {i + 1}.
                    </span>
                    <div className="min-w-0 flex-1 space-y-1.5">
                      <textarea
                        rows={2}
                        className={`${inputCls} leading-relaxed`}
                        value={teks}
                        placeholder="Tulis isi butir…"
                        onChange={(e) => ubahButir({ teks: e.target.value })}
                      />
                      <div className="flex items-center gap-1.5">
                        <span className="shrink-0 text-[0.72rem] font-bold text-[#8894a6]">
                          Tautan
                        </span>
                        <input
                          className={`${inputCls} h-8 text-[0.82rem]`}
                          value={url}
                          placeholder="https://… (opsional, agar butir bisa diklik)"
                          onChange={(e) => ubahButir({ url: e.target.value })}
                        />
                      </div>
                    </div>
                    <TombolKecil
                      tone="red"
                      onClick={() => ubah({ items: blok.items.filter((_, x) => x !== i) })}
                    >
                      <Icon name="x" className="size-3.5" />
                    </TombolKecil>
                  </div>
                </div>
              );
            })}
            <TombolKecil onClick={() => ubah({ items: [...(blok.items ?? []), ''] })}>
              <Icon name="plus" className="size-3.5" /> Tambah butir
            </TombolKecil>
          </div>
        )}

        {blok.tipe === 'tautan' && (
          <div className="space-y-2">
            {(blok.items ?? []).map((item, i) => (
              <div key={i} className="grid gap-2 sm:grid-cols-[1fr_1fr_auto]">
                <input
                  className={inputCls}
                  value={item.label}
                  placeholder="Teks tautan"
                  onChange={(e) => {
                    const items = [...blok.items];
                    items[i] = { ...items[i], label: e.target.value };
                    ubah({ items });
                  }}
                />
                <input
                  className={inputCls}
                  value={item.url}
                  placeholder="https://…"
                  onChange={(e) => {
                    const items = [...blok.items];
                    items[i] = { ...items[i], url: e.target.value };
                    ubah({ items });
                  }}
                />
                <TombolKecil
                  tone="red"
                  onClick={() => ubah({ items: blok.items.filter((_, x) => x !== i) })}
                >
                  <Icon name="trash" className="size-3.5" />
                </TombolKecil>
              </div>
            ))}
            <TombolKecil
              onClick={() => ubah({ items: [...(blok.items ?? []), { label: '', url: '' }] })}
            >
              <Icon name="plus" className="size-3.5" /> Tambah tautan
            </TombolKecil>
          </div>
        )}

        {blok.tipe === 'tabel' && (
          <div className="space-y-2">
            <div className="grid gap-2" style={{ gridTemplateColumns: `repeat(${blok.kolom?.length ?? 2}, minmax(0,1fr))` }}>
              {(blok.kolom ?? []).map((kolom, i) => (
                <input
                  key={i}
                  className={`${inputCls} font-bold`}
                  value={kolom}
                  placeholder={`Kolom ${i + 1}`}
                  onChange={(e) => {
                    const kolomBaru = [...blok.kolom];
                    kolomBaru[i] = e.target.value;
                    ubah({ kolom: kolomBaru });
                  }}
                />
              ))}
            </div>

            {(blok.baris ?? []).map((baris, r) => (
              <div key={r} className="flex gap-2">
                <div
                  className="grid flex-1 gap-2"
                  style={{ gridTemplateColumns: `repeat(${blok.kolom?.length ?? 2}, minmax(0,1fr))` }}
                >
                  {baris.map((sel, c) => (
                    <input
                      key={c}
                      className={inputCls}
                      value={sel}
                      placeholder="—"
                      onChange={(e) => {
                        const barisBaru = blok.baris.map((row) => [...row]);
                        barisBaru[r][c] = e.target.value;
                        ubah({ baris: barisBaru });
                      }}
                    />
                  ))}
                </div>
                <TombolKecil
                  tone="red"
                  onClick={() => ubah({ baris: blok.baris.filter((_, x) => x !== r) })}
                >
                  <Icon name="trash" className="size-3.5" />
                </TombolKecil>
              </div>
            ))}

            <TombolKecil
              onClick={() => ubah({ baris: [...(blok.baris ?? []), Array(blok.kolom?.length ?? 2).fill('')] })}
            >
              <Icon name="plus" className="size-3.5" /> Tambah baris
            </TombolKecil>
          </div>
        )}

        {blok.tipe === 'gambar' && (
          <div className="space-y-2">
            <input
              className={inputCls}
              value={blok.url ?? ''}
              placeholder="URL gambar (https://…)"
              onChange={(e) => ubah({ url: e.target.value })}
            />
            <input
              className={inputCls}
              value={blok.caption ?? ''}
              placeholder="Keterangan gambar (opsional)"
              onChange={(e) => ubah({ caption: e.target.value })}
            />
            {blok.url && (
              <div
                className="h-28 w-full max-w-sm rounded border border-[#e8edf4] bg-cover bg-center"
                style={{ backgroundImage: `url('${blok.url}')` }}
                role="img"
                aria-label="Pratinjau gambar"
              />
            )}
          </div>
        )}
      </div>
    </div>
  );
}

export default function BlokEditor({ blocks = [], onChange }) {
  const ubahBlok = (index, blok) => {
    const next = blocks.map((item, i) => (i === index ? blok : item));
    onChange(next);
  };

  const hapusBlok = (index) => onChange(blocks.filter((_, i) => i !== index));

  const geser = (index, arah) => {
    const target = index + arah;
    if (target < 0 || target >= blocks.length) return;

    const next = [...blocks];
    [next[index], next[target]] = [next[target], next[index]];
    onChange(next);
  };

  const tambah = (tipe) => onChange([...blocks, blokBaru(tipe)]);

  return (
    <div>
      <div className="space-y-2.5">
        {blocks.length === 0 && (
          <p className="rounded-lg border border-dashed border-[#cfd8e3] bg-[#fafcfe] px-4 py-5 text-center text-[0.85rem] text-[#8894a6]">
            Belum ada isi. Tambahkan blok di bawah — tidak perlu menulis kode.
          </p>
        )}

        {blocks.map((blok, index) => (
          <BlokItem
            key={blok.id ?? index}
            blok={blok}
            index={index}
            total={blocks.length}
            onChange={(next) => ubahBlok(index, next)}
            onRemove={hapusBlok}
            onMove={geser}
          />
        ))}
      </div>

      {/* Tambah blok */}
      <div className="mt-3 flex flex-wrap items-center gap-1.5 rounded-lg border border-[#e8edf4] bg-[#fafcfe] px-3 py-2.5">
        <span className="mr-1 text-[0.74rem] font-extrabold tracking-[0.04em] text-[#8894a6] uppercase">
          Tambah blok:
        </span>
        {BLOK_TIPE.map((tipe) => (
          <button
            key={tipe.value}
            type="button"
            onClick={() => tambah(tipe.value)}
            className="inline-flex items-center gap-1.5 rounded-md border border-[#dbe3ee] bg-white px-2.5 py-1.5 text-[0.76rem] font-bold text-[#33445c] transition-colors hover:border-[#1266d2] hover:text-[#1266d2]"
          >
            <Icon name={tipe.icon} className="size-3.5" />
            {tipe.label}
          </button>
        ))}
      </div>
    </div>
  );
}
