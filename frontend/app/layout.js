import './globals.css'

export const metadata = {
  title: 'Pusat P2M Polibatam',
  description:
    'Pusat Penelitian dan Pengabdian kepada Masyarakat — Politeknik Negeri Batam',
}

export default function RootLayout({ children }) {
  return (
    <html lang="id">
      <body>{children}</body>
    </html>
  )
}