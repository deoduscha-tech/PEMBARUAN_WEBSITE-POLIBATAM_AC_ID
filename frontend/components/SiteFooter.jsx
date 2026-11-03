export default function SiteFooter({ settings = {} }) {
  return (
    <footer className="relative overflow-hidden bg-gradient-to-b from-[#0a132a] to-[#080f22] text-white">
      <div className="wide-inner relative pt-10 pb-[18px]">
        <h2 className="mb-6 text-[clamp(1.35rem,1.9vw,1.85rem)] leading-[1.2] font-extrabold tracking-[-0.03em] text-white/95">
          {settings.footer_title ?? 'Pusat P2M Polibatam'}
        </h2>
        <div className="border-t border-white/15 pt-[18px] text-center text-[0.82rem] leading-normal text-white/75">
          {settings.footer_text ?? 'Proudly powered by WordPress | Theme: Newsup by Themeansar.'}
        </div>
        <a
          href="#"
          className="absolute right-8 bottom-3.5 grid size-[42px] place-items-center rounded-md bg-gradient-to-b from-[#1b6ee8] to-[#0d4ca8] text-2xl font-bold text-white shadow-[0_8px_18px_rgba(29,108,220,0.45)]"
          aria-label="Kembali ke atas"
        >
          &uarr;
        </a>
      </div>
    </footer>
  )
}