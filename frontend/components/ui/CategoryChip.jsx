/**
 * Komponen dasar — label kategori berita.
 *
 * Dipakai di kartu berita, halaman detail, dan tabel admin supaya warna
 * kategori konsisten di seluruh situs.
 */
const COLORS = {
  informasi: 'bg-[#1e6fd9] text-white',
  kegiatan: 'bg-[#0e9f6e] text-white',
  pengumuman: 'bg-[#d97706] text-white',
  prestasi: 'bg-[#7c3aed] text-white',
  hki: 'bg-[#0891b2] text-white',
  default: 'bg-[#1e6fd9] text-white',
};

export default function CategoryChip({ category, className = '' }) {
  const key = String(category ?? '').toLowerCase().trim();
  const color = COLORS[key] ?? COLORS.default;

  return (
    <span
      className={`inline-block px-2 py-1 text-[0.62rem] font-extrabold tracking-[0.05em] uppercase ${color} ${className}`}
    >
      {String(category ?? '').toUpperCase()}
    </span>
  );
}