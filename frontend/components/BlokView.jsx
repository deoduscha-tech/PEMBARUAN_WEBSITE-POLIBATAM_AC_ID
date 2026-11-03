/**
 * VIEW (server/client bersama) — menampilkan blok konten terstruktur.
 *
 * Blok disimpan sebagai array objek (lihat components/BlokEditor.jsx) sehingga
 * isi halaman tidak perlu ditulis dalam HTML mentah. Fungsi di bawah mengubah
 * blok tersebut menjadi elemen tampilan.
 */

export function BlokView({ blocks = [] }) {
  if (!Array.isArray(blocks) || blocks.length === 0) return null;

  return (
    <div className="blok-konten space-y-4">
      {blocks.map((blok, index) => {
        const key = blok?.id ?? index;

        switch (blok?.tipe) {
          case 'heading':
            return blok.teks ? (
              <h3 key={key} className="mt-6 mb-1 text-[1.05rem] font-extrabold text-[#0b1d35]">
                {blok.teks}
              </h3>
            ) : null;

          case 'seksi':
            // Judul kategori publikasi (mis. "A. Publikasi Jurnal Internasional").
            return String(blok?.judul ?? '').trim() ? (
              <h4
                key={key}
                className="mt-7 mb-2 border-l-4 border-[#1266d2] bg-[#f5f9ff] px-3 py-2 text-[0.95rem] leading-snug font-extrabold text-[#0b1d35]"
              >
                {blok.judul}
              </h4>
            ) : null;

          case 'daftar':
            return (blok.items ?? []).some((item) => String(item?.teks ?? item).trim()) ? (
              <ul key={key} className="list-decimal space-y-2 pl-6">
                {(blok.items ?? []).map((item, i) => {
                  // Butir bisa berupa teks biasa atau { teks, url }.
                  const teks = typeof item === 'string' ? item : item?.teks ?? '';
                  const url = typeof item === 'object' && item ? item.url : null;

                  if (!String(teks).trim()) return null;

                  return (
                    <li key={i} className="leading-relaxed">
                      {teks}
                      {url && (
                        <>
                          {' '}
                          <a
                            href={url}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="font-bold text-[#1266d2] underline decoration-[#1266d2]/40 underline-offset-2 hover:text-[#0f56b3]"
                          >
                            Lihat ↗
                          </a>
                        </>
                      )}
                    </li>
                  );
                })}
              </ul>
            ) : null;

          case 'tautan':
            return (blok.items ?? []).some((item) => item?.url) ? (
              <ul key={key} className="list-disc space-y-1 pl-6">
                {(blok.items ?? []).map((item, i) =>
                  item?.url ? (
                    <li key={i}>
                      <a href={item.url} target="_blank" rel="noopener noreferrer">
                        {item.label || item.url}
                      </a>
                    </li>
                  ) : null,
                )}
              </ul>
            ) : null;

          case 'tabel':
            return (blok.baris ?? []).length > 0 ? (
              <div key={key} className="overflow-x-auto">
                <table className="w-full border-collapse text-[0.86rem]">
                  <thead>
                    <tr className="bg-[#1d2432] text-left text-white">
                      {(blok.kolom ?? []).map((kolom, i) => (
                        <th key={i} className="border border-line px-3 py-2">
                          {kolom}
                        </th>
                      ))}
                    </tr>
                  </thead>
                  <tbody>
                    {(blok.baris ?? []).map((baris, r) => (
                      <tr key={r} className={r % 2 ? 'bg-[#f7f9fc]' : 'bg-white'}>
                        {(baris ?? []).map((sel, c) => (
                          <td key={c} className="border border-line px-3 py-2">
                            {sel}
                          </td>
                        ))}
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            ) : null;

          case 'gambar':
            return blok.url ? (
              <figure key={key} className="my-4">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src={blok.url} alt={blok.caption || ''} className="w-full rounded" />
                {blok.caption && (
                  <figcaption className="mt-1.5 text-center text-[0.8rem] text-[#8894a6]">
                    {blok.caption}
                  </figcaption>
                )}
              </figure>
            ) : null;

          case 'paragraf':
          default:
            return String(blok?.teks ?? '').trim() ? <p key={key}>{blok.teks}</p> : null;
        }
      })}
    </div>
  );
}

/**
 * Ambil teks polos dari blok — dipakai untuk ringkasan/meta description.
 */
export function blokKeTeks(blocks = []) {
  if (!Array.isArray(blocks)) return '';

  return blocks
    .map((blok) => {
      if (!blok) return '';
      if (blok.teks) return blok.teks;
      if (blok.items) {
        return blok.items
          .map((item) => (typeof item === 'string' ? item : item?.teks ?? item?.label ?? ''))
          .join(' ');
      }
      if (blok.caption) return blok.caption;

      return '';
    })
    .filter(Boolean)
    .join(' ')
    .replace(/\s+/g, ' ')
    .trim();
}
