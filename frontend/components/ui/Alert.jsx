/**
 * Komponen dasar — pesan sistem (sukses / gagal / peringatan).
 *
 * Dipakai di panel admin setelah menyimpan, menghapus, atau saat terjadi galat.
 */
const TONES = {
  success: { border: 'border-emerald-500', bg: 'bg-emerald-50', text: 'text-emerald-900', icon: '✓' },
  error: { border: 'border-red-500', bg: 'bg-red-50', text: 'text-red-800', icon: '✕' },
  warning: { border: 'border-amber-500', bg: 'bg-amber-50', text: 'text-amber-900', icon: '!' },
  info: { border: 'border-[#1e6fd9]', bg: 'bg-[#eaf1ff]', text: 'text-[#0d4ca8]', icon: 'i' },
};

export default function Alert({ tone = 'info', children, title = null, className = '' }) {
  const style = TONES[tone] ?? TONES.info;

  return (
    <div
      role={tone === 'error' ? 'alert' : 'status'}
      className={`flex items-start gap-3 border-l-4 px-4 py-3 text-[0.88rem] ${style.border} ${style.bg} ${style.text} ${className}`}
    >
      <span className="mt-0.5 font-bold" aria-hidden="true">
        {style.icon}
      </span>
      <div className="min-w-0">
        {title && <p className="font-extrabold">{title}</p>}
        <div className={title ? 'mt-0.5' : ''}>{children}</div>
      </div>
    </div>
  );
}