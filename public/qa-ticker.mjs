export default async function run(page, ui) {
  // Freeze the marquee so the screenshot is deterministic.
  await page.addStyleTag({
    content: `* { animation-play-state: paused !important; }`,
  });

  const metrics = await page.evaluate(() => {
    const sec = document.querySelector('.mg-latest-news-sec');
    const box = document.querySelector('.mg-latest-news');
    const title = document.querySelector('.bn_title');
    const ticker = document.querySelector('.ticker');
    const track = document.querySelector('.ticker-track');
    const groups = document.querySelectorAll('.ticker-group');
    const items = document.querySelectorAll('.ticker-item');
    const first = items[0];
    return {
      sectionH: sec && sec.getBoundingClientRect().height,
      boxH: box && box.getBoundingClientRect().height,
      titleH: title && title.getBoundingClientRect().height,
      titleW: title && title.getBoundingClientRect().width,
      tickerH: ticker && ticker.getBoundingClientRect().height,
      trackH: track && track.getBoundingClientRect().height,
      trackW: track && track.scrollWidth,
      groupCount: groups.length,
      itemCount: items.length,
      firstItemText: first && first.innerText.slice(0, 30),
      firstItemH: first && first.getBoundingClientRect().height,
      firstItemColor: first && getComputedStyle(first).color,
    };
  });

  return metrics;
}
