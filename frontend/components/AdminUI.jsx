'use client';

/**
 * Komponen kecil yang dipakai bersama oleh halaman-halaman panel admin:
 * kotak pesan, tombol, dan judul halaman.
 */

export function Alert({ type = 'error', message }) {
  if (!message) return null;

  const styles =
    type === 'error'
      ? 'border-red-500 bg-red-50 text-red-700'
      : 'border-green-600 bg-green-50 text-green-800';

  return (
    <div
      role={type === 'error' ? 'alert' : 'status'}
      className={`mb-4 rounded border-l-4 px-4 py-3 text-[0.88rem] ${styles}`}
    >
      {message}
    </div>
  );
}

export function PageHead({ title, description, children }) {
  return (
    <div className="mb-5 flex flex-wrap items-end justify-between gap-3">
      <div className="min-w-0">
        <h1 className="text-[1.5rem] font-black tracking-[-0.02em] text-[#0b1d35]">{title}</h1>
        {description && (
          <p className="mt-1 max-w-[70ch] text-[0.88rem] text-[#5b6675]">{description}</p>
        )}
      </div>
      {children}
    </div>
  );
}

export function Button({ variant = 'primary', className = '', ...props }) {
  const variants = {
    primary: 'bg-[#1e6fd9] text-white hover:bg-[#1558b0]',
    outline: 'border border-[#cfd8e3] text-[#3b4757] hover:bg-[#f3f6fa]',
    danger: 'bg-red-600 text-white hover:bg-red-700',
    ghost: 'text-[#1e6fd9] hover:bg-[#e7f0ff]',
  };

  return (
    <button
      {...props}
      className={`rounded px-4 py-2.5 text-[0.82rem] font-extrabold transition-colors disabled:cursor-not-allowed disabled:opacity-60 ${variants[variant]} ${className}`}
    />
  );
}

export function Empty({ title, hint }) {
  return (
    <div className="rounded-lg border border-dashed border-[#cfd8e3] bg-white p-8 text-center">
      <p className="font-bold text-[#33445c]">{title}</p>
      {hint && <p className="mt-1 text-[0.86rem] text-[#8894a6]">{hint}</p>}
    </div>
  );
}

export function Loading({ text = 'Memuat data…' }) {
  return <p className="text-[0.9rem] font-bold text-[#5b6675]">{text}</p>;
}
