/**
 * VIEW (bersama) — isi halaman statis dari API Laravel.
 *
 * Semua teks berasal dari backend/resources/data/halaman.php lewat
 * /api/halaman/{slug}, jadi halaman profil, informasi, renstra, RIP,
 * penelitian, dan pengabdian tidak lagi menyimpan salinan konten sendiri.
 */

/** "renstra-penelitian" -> "Renstra Penelitian". */
export function slugToTitle(slug) {
  return String(slug ?? '')
    .split('-')
    .filter(Boolean)
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ');
}

export function halamanMetadata(slug) {
  return { title: `${slugToTitle(slug)} — Pusat P2M Polibatam` };
}

/** Paragraf-paragraf pembuka. */
export function Intro({ paragraphs = [] }) {
  return paragraphs.map((text, index) => <p key={`intro-${index}`}>{text}</p>);
}

/** Blok konten: judul + paragraf + daftar + tautan. */
export function HalamanBody({ data }) {
  const sections = data?.sections ?? [];

  return (
    <>
      <Intro paragraphs={data?.intro ?? []} />

      {sections.map((section, index) => (
        <section key={`section-${index}`} className={index === 0 ? '' : 'mt-6'}>
          {section.title && <p className="mb-3">{section.title}</p>}

          {(section.paragraphs ?? []).map((text, i) => (
            <p key={`p-${i}`}>{text}</p>
          ))}

          {(section.list ?? []).length > 0 && (
            <ul className="list-disc pl-7">
              {section.list.map((item, i) => (
                <li key={`li-${i}`}>{item}</li>
              ))}
            </ul>
          )}

          {(section.hrefs ?? []).length > 0 && (
            <ul className="list-disc pl-7">
              {section.hrefs.map((link) => (
                <li key={link.url}>
                  <a href={link.url} target="_blank" rel="noopener noreferrer">
                    {link.label}
                  </a>
                </li>
              ))}
            </ul>
          )}
        </section>
      ))}
    </>
  );
}
