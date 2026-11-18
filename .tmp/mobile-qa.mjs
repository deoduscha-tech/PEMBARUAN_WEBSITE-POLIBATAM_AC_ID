import fs from 'fs';

const OUT = 'c:\\laragon\\www\\PEMBARUAN_WEBSITE-POLIBATAM_AC_ID\\.tmp';
const PAGES = ['/', '/berita', '/profil', '/publikasi', '/hki', '/statistik', '/admin/login'];

export default async function run(page, ui) {
  await page.setViewportSize({ width: 390, height: 844 });
  const results = [];

  for (const path of PAGES) {
    await page.goto('http://localhost:3000' + path, { waitUntil: 'domcontentloaded', timeout: 45000 });
    await page.waitForTimeout(1200);

    const info = await page.evaluate(() => {
      const vw = window.innerWidth;
      const docW = document.documentElement.scrollWidth;
      const offenders = [];
      document.querySelectorAll('body *').forEach((el) => {
        const r = el.getBoundingClientRect();
        if (r.width === 0 || r.height === 0) return;
        const cs = getComputedStyle(el);
        if (cs.position === 'fixed') return;
        if (r.right > vw + 2 || r.left < -2) {
          offenders.push({
            tag: el.tagName.toLowerCase(),
            cls: (el.className && String(el.className).slice(0, 70)) || '',
            left: Math.round(r.left),
            right: Math.round(r.right),
            w: Math.round(r.width),
            text: (el.textContent || '').trim().replace(/\s+/g, ' ').slice(0, 45),
          });
        }
      });
      // dedupe per tag+class
      const seen = new Set();
      const uniq = [];
      for (const o of offenders) {
        const k = o.tag + '|' + o.cls;
        if (seen.has(k)) continue;
        seen.add(k);
        uniq.push(o);
      }
      return {
        vw,
        docW,
        overflow: docW > vw + 1,
        overflowPx: docW - vw,
        offenders: uniq.slice(0, 12),
        smallTargets: Array.from(document.querySelectorAll('a,button')).filter((el) => {
          const r = el.getBoundingClientRect();
          return r.width > 0 && r.height > 0 && r.height < 32;
        }).length,
        tapCount: document.querySelectorAll('a,button').length,
      };
    });

    // horizontal scroll test
    await page.evaluate(() => window.scrollTo(9999, 0));
    await page.waitForTimeout(200);
    const scrolled = await page.evaluate(() => ({ x: window.scrollX }));

    const file = `${OUT}\\m-${path.replace(/\//g, '_') || 'home'}.png`;
    await page.screenshot({ path: file, fullPage: true });
    await page.evaluate(() => window.scrollTo(0, 0));

    results.push({ path, ...info, scrolledX: scrolled.x, shot: file });
  }

  fs.writeFileSync(`${OUT}\\mobile-report.json`, JSON.stringify(results, null, 2));
  return results;
}
