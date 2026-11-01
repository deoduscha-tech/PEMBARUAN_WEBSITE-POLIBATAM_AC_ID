export const metadata = {
  title: 'Panel Admin — Pusat P2M Polibatam',
};

/**
 * Layout panel admin.
 *
 * Sengaja hanya meneruskan children: /admin/login tidak boleh memakai sidebar,
 * sedangkan halaman admin lain membungkus dirinya dengan <AdminShell>.
 */
export default function AdminLayout({ children }) {
  return children;
}
