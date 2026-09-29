@php
    /* =========================================================
       Laporan Tahunan P3M

       Standalone editorial page. The controller passes $reportYear and
       $reportFile (a path inside public/); the fallbacks keep the view
       renderable on its own while the PDF is not uploaded yet.
    ========================================================= */
    $page = $page ?? 'home';

    $reportYear = $reportYear ?? '2025';
    $reportFile = $reportFile ?? null;

    $missedCards = $missedCards ?? collect();
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tahunan P3M {{ $reportYear }} — Pusat P2M Polibatam</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/images/cropped-Logo-Polibatam-3-32x32.png">
    <link rel="apple-touch-icon" href="/images/cropped-Logo-Polibatam-3-32x32.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @include('partials.site-header', ['page' => $page])

    <div class="bg-[#efefef] pb-6">
        <div class="wide-inner mb-4 border-line bg-white p-8">
            <h1 class="mb-[18px] text-[clamp(1.9rem,3vw,2.6rem)] font-black tracking-[0.02em] text-[#0b1d35] uppercase">
                LAPORAN TAHUNAN P3M TAHUN {{ $reportYear }}
            </h1>

            <div class="rich-copy text-[1.05rem] leading-[1.9] text-[#1f2937]">
                <p>
                    Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) Politeknik Negeri Batam
                    merupakan unit yang mengelola, memfasilitasi, dan mengembangkan kegiatan
                    penelitian serta pengabdian kepada masyarakat sebagai implementasi Tri Dharma
                    Perguruan Tinggi. Melalui kolaborasi dengan dosen, pusat kajian, pusat unggulan,
                    dunia usaha, dunia industri, pemerintah, dan masyarakat, P3M berkomitmen
                    menghasilkan riset yang inovatif, berkualitas, dan memberikan manfaat nyata bagi
                    pembangunan nasional.
                </p>

                <p>
                    Sepanjang tahun {{ $reportYear }}, P3M berhasil menunjukkan kinerja yang sangat baik
                    dengan penyelesaian 100% terhadap seluruh Indikator Kinerja Utama (IKU). Berbagai
                    capaian strategis berhasil diraih, di antaranya 99 publikasi internasional,
                    163 pendaftaran Hak Kekayaan Intelektual (HKI), 79 luaran penelitian berbasis
                    Project Based Learning (PBL) yang dimanfaatkan oleh industri, serta 29 kegiatan
                    pengabdian kepada masyarakat yang melibatkan 233 dosen. Capaian tersebut
                    mencerminkan komitmen P3M dalam memperkuat ekosistem riset, inovasi, hilirisasi
                    teknologi, dan pengabdian yang berdampak bagi masyarakat serta mendukung
                    peningkatan daya saing Politeknik Negeri Batam di tingkat nasional maupun
                    internasional.
                </p>

                <p>
                    P3M akan terus mendorong peningkatan kualitas penelitian, publikasi ilmiah
                    bereputasi, perlindungan kekayaan intelektual, kemitraan strategis dengan
                    industri, serta pengembangan inovasi yang berorientasi pada kebutuhan masyarakat
                    dan pembangunan berkelanjutan.
                </p>

                {{-- Download entry point. Stays a plain in-sentence link like the live
                     site. While no PDF is wired up it renders as inert text so visitors
                     are not sent to a 404; drop a path into $reportFile to activate it. --}}
                <p>
                    Unduh Laporan Tahunan Penelitian dan Pengabdian kepada Masyarakat Tahun {{ $reportYear }} (PDF):
                    @if ($reportFile)
                        <a href="{{ asset($reportFile) }}" target="_blank" rel="noopener noreferrer"
                           class="font-bold text-[#1e6fd9] underline decoration-[#1e6fd9]/40 underline-offset-2 transition-colors hover:text-[#0d4ca8]">Klik Disini</a>
                    @else
                        <span class="cursor-not-allowed font-bold text-[#1e6fd9]/60"
                              title="Dokumen belum tersedia">Klik Disini</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="wide-inner pb-6 text-[1.12rem] font-bold">Jumlah Pengunjung: 264</div>

        <div class="wide-inner pb-6">
            <div class="mb-[18px] flex items-end border-b-2 border-line"><span class="section-label">You missed</span></div>
            <div class="grid gap-[18px] sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($missedCards as $card)
                <article class="flex min-h-[210px] items-end bg-cover bg-center" style="background-image: url('{{ $card['image'] }}');">
                    <a href="{{ route('berita.detail', $card['slug']) }}" class="card-overlay-sm block" aria-label="{{ $card['title'] }}">
                        <span class="category-chip">{{ strtoupper($card['category']) }}</span>
                        <h4 class="mt-1.5 mb-2 line-clamp-3 text-[0.92rem] leading-snug font-bold text-white">{{ $card['title'] }}</h4>
                        <div class="text-[0.72rem] text-white/90">{{ \Illuminate\Support\Carbon::parse($card['date'])->format('F d, Y') }}</div>
                    </a>
                </article>
                @endforeach
            </div>
        </div>
    </div>

        {{-- =====================================================
             Footer
        ===================================================== --}}
        <footer class="relative overflow-hidden bg-gradient-to-b from-[#0a132a] to-[#080f22] text-white">
            <div class="wide-inner relative pt-10 pb-[18px]">
                <h2 class="mb-[34px] text-[clamp(2.4rem,3.1vw,3.5rem)] leading-[1.1] font-extrabold tracking-[-0.06em] text-white/95">Pusat P2M Polibatam</h2>
                <div class="border-t border-white/15 pt-[18px] text-center text-[0.82rem] leading-normal text-white/75">
                    Proudly powered by WordPress | Theme: Newsup by Themeansar.
                </div>
                <a href="#" data-back-to-top class="absolute right-8 bottom-3.5 grid size-[42px] place-items-center rounded-md bg-gradient-to-b from-[#1b6ee8] to-[#0d4ca8] text-2xl font-bold text-white shadow-[0_8px_18px_rgba(29,108,220,0.45)]" aria-label="Kembali ke atas">&uarr;</a>
            </div>
        </footer>
    </body>
    </html>