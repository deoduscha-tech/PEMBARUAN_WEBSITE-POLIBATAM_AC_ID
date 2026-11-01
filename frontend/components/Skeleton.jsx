/**
 * Komponen dasar — penanda saat data sedang dimuat.
 *
 * Bentuknya menyerupai konten asli, jadi tata letak tidak melompat saat data
 * selesai dimuat.
 */
export function Skeleton({ className = '' }) {
  return <div className={`animate-pulse rounded bg-[#e2e7ee] ${className}`} />;
}

/** Placeholder untuk satu kartu berita. */
export function NewsCardSkeleton() {
  return (
    <div className="border border-[#e2e6ec] bg-white">
      <Skeleton className="h-[180px] w-full rounded-none" />
      <div className="flex flex-col gap-2 p-4">
        <Skeleton className="h-4 w-20" />
        <Skeleton className="h-5 w-full" />
        <Skeleton className="h-5 w-3/4" />
        <Skeleton className="h-3 w-32" />
      </div>
    </div>
  );
}

/** Placeholder untuk daftar berita bentuk baris. */
export function NewsRowSkeleton() {
  return (
    <div className="flex gap-[18px] border border-[#e2e6ec] bg-white p-3">
      <Skeleton className="h-[180px] w-[280px] shrink-0 rounded-none" />
      <div className="flex flex-1 flex-col justify-center gap-2.5 py-2">
        <Skeleton className="h-4 w-24" />
        <Skeleton className="h-6 w-3/4" />
        <Skeleton className="h-3 w-40" />
        <Skeleton className="h-4 w-full" />
        <Skeleton className="h-4 w-2/3" />
      </div>
    </div>
  );
}

/** Placeholder untuk grid beberapa kartu. */
export function NewsGridSkeleton({ count = 6 }) {
  return (
    <div className="flex flex-col gap-[18px]">
      {Array.from({ length: count }).map((_, i) => (
        <NewsRowSkeleton key={i} />
      ))}
    </div>
  );
}