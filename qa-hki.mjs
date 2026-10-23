export default async function run(page, ui) {
  await page.waitForTimeout(6000);
  const info = await page.evaluate(() => {
    const h1 = document.querySelector('h1')?.innerText || '';
    const rows = document.querySelectorAll('table tbody tr').length;
    const first = document.querySelector('table tbody tr td:nth-child(2)')?.innerText || '';
    const body = document.body.innerText;
    const loading = body.includes('Memuat data HKI');
    const err = body.includes('tidak dapat dimuat');
    return { h1, rows, first, loading, err, head: body.slice(0,200) };
  });
  return info;
}
