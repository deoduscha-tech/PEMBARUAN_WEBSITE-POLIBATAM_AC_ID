/**
 * Komponen dasar — kotak konten.
 *
 * Serbaguna: dipakai untuk kartu berita, panel form, kotak statistik, dll.
 * `padding` diatur agar tidak perlu kelas tambahan di tiap pemakaian.
 */
export default function Card({ children, className = '', padding = 'md', as: Tag = 'div' }) {
  const pad = {
    none: '',
    sm: 'p-3',
    md: 'p-6',
    lg: 'p-8',
  }[padding] ?? 'p-6';

  return (
    <Tag className={`border border-[#d7dce4] bg-white ${pad} ${className}`}>{children}</Tag>
  );
}

/** Judul di dalam Card, opsional dengan garis pemisah. */
export function CardHeader({ title, action = null, className = '' }) {
  return (
    <div
      className={`mb-4 flex items-center justify-between gap-3 border-b border-[#e6eaf0] pb-3 ${className}`}
    >
      <h3 className="text-[1rem] font-extrabold tracking-[-0.02em] text-[#0b1d35]">{title}</h3>
      {action}
    </div>
  );
}