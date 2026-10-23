'use client';

import { useState } from 'react';
import Link from 'next/link';

const ICONS = {
  latest: <><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" /></>,
  popular: <><path d="M12 22c4.2 0 7-2.8 7-6.7 0-2.2-1.1-4.1-3.2-6.1-.1 2-1.2 3-2 3.3C13.9 8.3 11.8 4.9 8.5 2 9 5.5 7 7.8 5.6 9.5 4.4 11 3 13 3 15.4 3 19.3 6.2 22 12 22Z" /></>,
  trending: <><path d="m13 2-3 8h6l-5 12 1-9H6l7-11Z" /></>,
};

export default function SidebarTabs({ tabs }) {
  const [active, setActive] = useState(tabs[0]?.key ?? 'latest');
  const current = tabs.find((tab) => tab.key === active) ?? tabs[0];

  return (
    <section className="flex min-w-0 flex-col border-line bg-white shadow-card" aria-label="Berita pilihan">
      <div className="grid grid-cols-3 border-b border-line" role="tablist" aria-label="Urutkan berita">
        {tabs.map((tab) => (
          <button key={tab.key} type="button" role="tab" aria-selected={active === tab.key}
            aria-controls="home-post-panel" onClick={() => setActive(tab.key)}
            className={`tab ${active === tab.key ? 'active' : ''}`}>
            <svg className="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.4" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">{ICONS[tab.key]}</svg>
            {tab.label}
          </button>
        ))}
      </div>
      <div id="home-post-panel" role="tabpanel" className="flex flex-1 flex-col gap-3 p-3">
        {current?.posts?.map((post) => (
          <Link key={`${current.key}-${post.slug}`} href={`/berita/${post.slug}`} className="small-post grid border">
            <img src={post.image} alt="" className="h-[104px] w-full border-line object-cover" loading="lazy" />
            <div className="min-w-0">
              <span className="category-chip">INFORMASI</span>
              <p className="title">{post.title}</p>
            </div>
          </Link>
        ))}
      </div>
    </section>
  );
}
