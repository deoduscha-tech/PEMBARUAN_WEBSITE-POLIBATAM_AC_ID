import Link from 'next/link';

/**
 * VIEW — navigasi halaman.
 *
 * Server Component: hanya membuat tautan, tanpa state. Nomor halaman
 * dihitung dari meta yang dikirim Controller.
 */
export default function Pagination({ page, lastPage, basePath = '/' }) {
  if (lastPage <= 1) return null;

  const href = (target) => (target === 1 ? basePath : `${basePath}?page=${target}`);

  // Tampilkan maksimal 5 nomor di sekitar halaman aktif.
  const window = 2;
  const start = Math.max(1, page - window);
  const end = Math.min(lastPage, page + window);

  const numbers = [];
  for (let i = start; i <= end; i++) numbers.push(i);

  const linkClass =
    'page-numbers border inline-flex items-center justify-center min-w-[34px] px-2 py-1.5 text-[0.8rem] font-bold text-[#3b4757] transition-colors hover:bg-[#eaf1ff] hover:text-[#1e6fd9]';

  return (
    <nav className="flex items-center justify-center gap-1.5 py-2" aria-label="Navigasi halaman">
      {page > 1 && (
        <Link className={linkClass} href={href(page - 1)} aria-label="Halaman sebelumnya">
          &#8249;
        </Link>
      )}

      {start > 1 && (
        <>
          <Link className={linkClass} href={href(1)}>
            1
          </Link>
          {start > 2 && <span className="px-2 text-[#8894a6]">&hellip;</span>}
        </>
      )}

      {numbers.map((number) =>
        number === page ? (
          <span
            key={number}
            aria-current="page"
            className="page-numbers current inline-flex min-w-[34px] items-center justify-center px-2 py-1.5 text-[0.8rem] font-bold"
          >
            {number}
          </span>
        ) : (
          <Link key={number} className={linkClass} href={href(number)}>
            {number}
          </Link>
        ),
      )}

      {end < lastPage && (
        <>
          {end < lastPage - 1 && <span className="px-2 text-[#8894a6]">&hellip;</span>}
          <Link className={linkClass} href={href(lastPage)}>
            {lastPage}
          </Link>
        </>
      )}

      {page < lastPage && (
        <Link className={linkClass} href={href(page + 1)} aria-label="Halaman berikutnya">
          &#8250;
        </Link>
      )}
    </nav>
  );
}