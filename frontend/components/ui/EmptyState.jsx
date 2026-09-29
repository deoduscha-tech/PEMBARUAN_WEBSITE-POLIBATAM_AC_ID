/**
 * Komponen dasar — tampilan saat daftar kosong.
 *
 * Dipakai di semua daftar (berita, publikasi, HKI, …) supaya pengunjung tidak
 * melihat halaman putih kosong tanpa penjelasan.
 */
export default function EmptyState({
  title = 'Belum ada data',
  description = 'Data akan muncul di sini setelah ditambahkan.',
  action = null,
  icon = '📭',
}) {
  return (
    <div className="flex flex-col items-center justify-center border border-dashed border-[#c9d2de] bg-white px-6 py-14 text-center">
      <span className="mb-3 text-[2.5rem] leading-none" aria-hidden="true">
        {icon}
      </span>
      <h3 className="text-[1.05rem] font-extrabold text-[#0b1d35]">{title}</h3>
      <p className="mt-1.5 max-w-[340px] text-[0.88rem] leading-relaxed text-[#6b7787]">
        {description}
      </p>
      {action && <div className="mt-5">{action}</div>}
    </div>
  );
}