import Link from 'next/link';

/**
 * Komponen dasar — tombol.
 *
 * Varian:
 *   primary (biru gradasi)  → aksi utama: "Simpan", "Tambah"
 *   secondary (abu)         → aksi pendamping: "Batal"
 *   ghost (transparan)      → aksi ringan: "Lihat"
 *   danger (merah)          → aksi merusak: "Hapus"
 *
 * Otomatis menjadi <Link> kalau diberi prop `href`, jadi tombol dan tautan
 * memakai gaya yang sama persis.
 */
const VARIANTS = {
  primary:
    'bg-gradient-to-b from-[#1e7be8] to-[#0e5ebf] text-white shadow-[0_8px_18px_rgba(29,122,230,0.28)] hover:-translate-y-px',
  secondary:
    'border border-[#c9d2de] bg-white text-[#3b4757] hover:bg-[#f3f5f8]',
  ghost:
    'border border-transparent text-[#1e6fd9] hover:bg-[#eaf1ff]',
  danger:
    'border border-red-400 bg-white text-red-600 hover:bg-red-50',
};

const SIZES = {
  sm: 'px-2.5 py-1.5 text-[0.7rem]',
  md: 'px-4 py-2.5 text-[0.75rem]',
  lg: 'px-5 py-3 text-[0.78rem]',
};

export default function Button({
  children,
  href,
  variant = 'primary',
  size = 'md',
  className = '',
  type = 'button',
  disabled = false,
  ...rest
}) {
  const classes = [
    'inline-flex shrink-0 items-center justify-center gap-2 rounded font-extrabold tracking-[0.03em] uppercase transition-all',
    'disabled:cursor-not-allowed disabled:opacity-60',
    VARIANTS[variant] ?? VARIANTS.primary,
    SIZES[size] ?? SIZES.md,
    className,
  ]
    .filter(Boolean)
    .join(' ');

  if (href) {
    return (
      <Link href={href} className={classes} {...rest}>
        {children}
      </Link>
    );
  }

  return (
    <button type={type} disabled={disabled} className={classes} {...rest}>
      {children}
    </button>
  );
}