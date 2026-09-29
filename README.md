# PEMBARUAN WEBSITE P2M POLIBATAM BERBASIS LARAVEL DAN NEXT.JS

Website Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M), Politeknik Negeri Batam.

| | |
|---|---|
| **Mahasiswa** | Farhan Mansyuri |
| **NIM** | 3312511141 |
| **Jurusan / Prodi** | Teknik Informatika |
| **Backend** | Laravel 12 (API JSON) |
| **Frontend** | Next.js 15 App Router + React + Tailwind CSS |
| **Website referensi** | https://p2m.polibatam.ac.id/ |

---

## Arsitektur

Dua aplikasi terpisah yang berkomunikasi lewat HTTP.

```
┌───────────────────────────┐          ┌───────────────────────────┐
│  FRONTEND                 │          │  BACKEND                  │
│  Next.js + React          │  HTTP    │  Laravel                  │
│  frontend/                │ ───────► │  backend/                 │
│  localhost:3000           │  /api/*  │  localhost:8000           │
│                           │  JSON    │                           │
│  • Tampilan & komponen    │          │  • Data & logika bisnis   │
│  • Routing halaman        │          │  • Validasi               │
│  • Form (tampilan saja)   │          │  • CRUD                   │
│  • Loading & error state  │          │  • Login & sesi admin     │
└───────────────────────────┘          └───────────────────────────┘
         yang dilihat user                  pemilik data
```

**Aturan utama:** Next.js **tidak pernah** mengakses data langsung.
Semua data diambil dari API Laravel dalam format JSON.

---

## Struktur Folder

```
PEMBARUAN_WEBSITE-POLIBATAM_AC_ID/
│
├── backend/                     ← LARAVEL (Backend / API)
│   │
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Api/         ← Controller JSON (dipakai Next.js)
│   │   │   │   │   └── NewsApiController.php
│   │   │   │   └── Admin/       ← Panel admin (Blade)
│   │   │   │       ├── AuthController.php
│   │   │   │       └── NewsController.php
│   │   │   └── Middleware/      ← Login admin
│   │   └── Support/
│   │       └── NewsRepository.php   ← Baca/tulis data berita
│   │
│   ├── routes/
│   │   ├── api.php              ← endpoint /api/*  (untuk Next.js)
│   │   └── web.php              ← halaman & panel admin
│   │
│   ├── resources/data/
│   │   └── berita.php           ← Data berita
│   │
│   ├── config/admin.php         ← Kredensial admin
│   ├── public/images/           ← Gambar (dilayani Laravel)
│   ├── database/                ← Migration (untuk MySQL nanti)
│   └── .env                     ← Konfigurasi
│
├── frontend/                    ← NEXT.JS (Frontend / Tampilan)
│   │
│   ├── app/                     ← Halaman (App Router)
│   │   ├── layout.js            Layout akar
│   │   ├── globals.css          Tailwind + token warna Polibatam
│   │   ├── not-found.jsx        Halaman 404
│   │   ├── page.jsx             Beranda
│   │   │
│   │   ├── profil/              Profil P2M
│   │   ├── penelitian/          Penelitian (6 skema)
│   │   ├── pengabdian/          Pengabdian (6 skema)
│   │   ├── publikasi/           Publikasi
│   │   ├── hki/                 HKI
│   │   ├── statistik/           Statistik
│   │   ├── berdampak/           Polibatam University Berdampak
│   │   ├── laporan-tahunan/     Laporan Tahunan P3M
│   │   ├── tahun-2024/2025/2026 Arsip publikasi
│   │   │
│   │   ├── berita/
│   │   │   ├── page.jsx         Daftar + cari + filter + paginasi
│   │   │   └── [slug]/page.jsx  Detail berita
│   │   │
│   │   └── admin/               ← Dashboard admin
│   │       ├── login/
│   │       ├── LogoutButton.jsx
│   │       ├── DeleteButton.jsx
│   │       └── berita/
│   │           ├── page.jsx         Daftar (Read)
│   │           ├── BeritaForm.jsx   Form bersama
│   │           ├── tambah/          (Create)
│   │           └── [id]/edit/       (Update)
│   │
│   ├── components/
│   │   ├── SiteHeader.jsx        Header + navigasi
│   │   ├── SiteFooter.jsx        Footer
│   │   ├── ProfileDropdown.jsx   Menu PROFIL
│   │   ├── SearchToggle.jsx      Tombol cari
│   │   ├── SearchPanel.jsx       Panel cari
│   │   ├── FeaturedSlider.jsx    Slider unggulan
│   │   ├── Pagination.jsx        Navigasi halaman
│   │   ├── EditorialPage.jsx     Layout halaman editorial
│   │   ├── RisetPage.jsx         Layout Penelitian & Pengabdian
│   │   │
│   │   └── ui/                   ← Komponen dasar
│   │       ├── Button.jsx        Tombol (4 varian)
│   │       ├── Card.jsx          Kotak konten
│   │       ├── CategoryChip.jsx  Label kategori
│   │       ├── Form.jsx          Input, Textarea, Select, Checkbox
│   │       ├── EmptyState.jsx    Tampilan data kosong
│   │       ├── Skeleton.jsx      Placeholder saat memuat
│   │       └── Alert.jsx         Pesan sukses/gagal
│   │
│   ├── lib/                      ← Penghubung ke Laravel
│   │   ├── api.js                Fungsi fetch ke API
│   │   ├── format.js             Format tanggal & angka
│   │   └── constants.js          Menu & kategori
│   │
│   ├── public/
│   │   ├── images/               Gambar
│   │   └── documents/            PDF (laporan, panduan)
│   │
│   ├── .env.local                NEXT_PUBLIC_API_URL
│   ├── jsconfig.json             Alias "@/" → root frontend
│   └── next.config.mjs
│
└── README.md
```

---

## Menjalankan

Butuh **dua terminal**.

**Terminal 1 — Backend Laravel:**

```bash
cd backend
php artisan serve
# → http://127.0.0.1:8000
```

**Terminal 2 — Frontend Next.js:**

```bash
cd frontend
npm run dev
# → http://localhost:3000
```

Buka **http://localhost:3000**. Laravel berjalan di belakang sebagai penyedia data.

> Kedua terminal harus tetap terbuka. Kalau salah satu ditutup, bagian itu mati.

---

## API Laravel

| Method | Endpoint | Fungsi | Status |
|---|---|---|---|
| GET | `/api/beranda` | Data beranda (slider, ticker, sidebar) | ✅ |
| GET | `/api/berita` | Daftar berita (`?limit=`, `?category=`) | ✅ |
| GET | `/api/berita/{slug}` | Detail berita + terkait | ✅ |
| GET | `/api/laporan-tahunan` | Konten laporan tahunan | ✅ |
| POST | `/api/auth/login` | Login admin | ⏳ |
| POST | `/api/berita` | Tambah berita | ⏳ |
| PUT | `/api/berita/{id}` | Ubah berita | ⏳ |
| DELETE | `/api/berita/{id}` | Hapus berita | ⏳ |

Contoh pemakaian dari Next.js:

```js
const response = await fetch('http://127.0.0.1:8000/api/berita');
const { data } = await response.json();
```

---

## Panel Admin

| | |
|---|---|
| **Laravel (Blade)** | http://127.0.0.1:8000/admin/login |
| **Next.js** | http://localhost:3000/admin/login |

Kredensial diatur di `backend/config/admin.php`:

```
ADMIN_USERNAME=admin
ADMIN_PASSWORD=admin123
```

> Ganti password sebelum dipasang di server publik.

---

## Halaman

### Selesai

| Halaman | URL |
|---|---|
| Beranda | `/` |
| Profil P2M | `/profil` |
| Penelitian | `/penelitian` |
| Pengabdian | `/pengabdian` |
| Publikasi | `/publikasi` |
| HKI | `/hki` |
| Statistik | `/statistik` |
| Polibatam University Berdampak | `/berdampak` |
| Laporan Tahunan | `/laporan-tahunan` |
| Arsip publikasi | `/tahun-2024`, `/tahun-2025`, `/tahun-2026` |
| Daftar berita | `/berita` |
| Detail berita | `/berita/[slug]` |
| Login admin | `/admin/login` |
| Kelola berita | `/admin/berita` |

### Belum dibuat

| Halaman | Keterangan |
|---|---|
| Pengumuman | Daftar & detail pengumuman |
| Kontak | Alamat, telepon, peta |

### Tautan eksternal (website terpisah)

| Menu | Tujuan |
|---|---|
| Jurnal | https://jurnal.polibatam.ac.id/ |
| Sinta | https://sinta.kemdiktisaintek.go.id/ |

---

## Warna (Identitas Polibatam)

| Peran | Hex |
|---|---|
| Primary | `#1e6fd9` |
| Primary dark | `#0e5ebf` |
| Navy (gelap) | `#0a1428` |
| Gold (aksen) | `#f0c869` |
| Surface | `#efefef` |
| Text | `#1f2937` |
| Muted | `#6b7787` |

---

## Catatan

- **Data berita** tersimpan di `backend/resources/data/berita.php` (belum pakai MySQL).
- **Gambar** dilayani dari `backend/public/images/`.
- **PDF** panduan/laporan belum tersedia; tombol unduh masih nonaktif.