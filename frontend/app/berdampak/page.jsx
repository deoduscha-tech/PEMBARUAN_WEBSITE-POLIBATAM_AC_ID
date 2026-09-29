import Link from 'next/link';
import EditorialPage from '@/components/EditorialPage';

export const metadata = { title: 'Polibatam University Berdampak — Pusat P2M Polibatam' };

export default function BerdampakPage() {
  return (
    <EditorialPage slug="berdampak" heading="Polibatam University Berdampak" visitors={null}>
      <h3>Membangun dampak nyata untuk masyarakat dan industri</h3>
      <p>
        Polibatam University Berdampak merupakan komitmen untuk membawa kontribusi nyata
        melalui riset, inovasi, pengabdian, dan penerapan teknologi yang berdampak pada
        kualitas hidup, daya saing industri, serta kesejahteraan masyarakat.
      </p>
      <p>
        Melalui pendekatan kolaboratif, Polibatam mendorong terciptanya solusi yang bermanfaat
        secara luas, terukur, dan berkelanjutan.
      </p>
      <p>
        <Link
          href="/berita"
          className="font-bold text-[#1e6fd9] underline decoration-[#1e6fd9]/40 underline-offset-2 transition-colors hover:text-[#0d4ca8]"
        >
          Pelajari lebih lanjut &rarr;
        </Link>

      </p>
    </EditorialPage>
  );
}