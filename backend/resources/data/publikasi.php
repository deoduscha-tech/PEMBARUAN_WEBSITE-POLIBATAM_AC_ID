<?php

/**
 * Data publikasi ilmiah P3M Polibatam.
 *
 * Disusun berkelompok per kategori luaran (mengikuti tampilan situs asli),
 * bukan sebagai daftar datar. Setiap tahun berisi beberapa kelompok, dan tiap
 * kelompok berisi daftar publikasi bernomor.
 *
 * Dipakai PublikasiApiController untuk dilayani sebagai JSON ke front end.
 * Kalau nanti pindah ke MySQL, file ini digantikan Model Publikasi —
 * controller dan tampilan tidak perlu diubah.
 */

return [
    '2026' => [
        'label' => 'Tahun 2026',
        'visitors' => 269,
        'groups' => [
            [
                'key' => 'A',
                'title' => 'Jurnal Internasional Bereputasi',
                'items' => [
                    [
                        'title' => 'IoT-Based Air Quality Monitoring System for Industrial Estates in Batam',
                        'authors' => 'F. Mansyuri, R. Saputra, D. Lestari',
                        'type' => 'Jurnal Internasional',
                        'venue' => 'IEEE Access',
                        'volume' => 'Vol. 14, No. 2',
                        'year' => 2026,
                    ],
                    [
                        'title' => 'Machine Learning Approach for Production Demand Forecasting in SMEs',
                        'authors' => 'A. Rahman, S. Nurhaliza',
                        'type' => 'Jurnal Internasional',
                        'venue' => 'International Journal of Production Research',
                        'volume' => 'Vol. 64, No. 1',
                        'year' => 2026,
                    ],
                ],
            ],
            [
                'key' => 'B',
                'title' => 'Jurnal Nasional Terakreditasi',
                'items' => [
                    [
                        'title' => 'Penerapan Machine Learning untuk Prediksi Permintaan Produksi pada UMKM',
                        'authors' => 'A. Rahman, S. Nurhaliza, F. Mansyuri',
                        'type' => 'Jurnal Nasional Terakreditasi',
                        'venue' => 'Jurnal Teknologi Informasi',
                        'volume' => 'Vol. 18, No. 1',
                        'year' => 2026,
                    ],
                    [
                        'title' => 'Analisis Keamanan Jaringan pada Sistem Informasi Akademik Kampus',
                        'authors' => 'N. Anwar, L. Fitriani',
                        'type' => 'Jurnal Nasional Terakreditasi',
                        'venue' => 'Jurnal Sistem Informasi',
                        'volume' => 'Vol. 12, No. 3',
                        'year' => 2026,
                    ],
                ],
            ],
            [
                'key' => 'C',
                'title' => 'Prosiding Seminar Internasional',
                'items' => [
                    [
                        'title' => 'Development of Automatic Fish Dryer Based on Microcontroller',
                        'authors' => 'H. Pratama, Y. Sari, M. Ikhsan',
                        'type' => 'Prosiding Internasional',
                        'venue' => 'International Conference on Applied Technology',
                        'volume' => 'pp. 120-127',
                        'year' => 2026,
                    ],
                ],
            ],
            [
                'key' => 'D',
                'title' => 'Prosiding Seminar Nasional',
                'items' => [
                    [
                        'title' => 'Rancang Bangun Alat Pengering Ikan Otomatis Berbasis Mikrokontroler',
                        'authors' => 'H. Pratama, Y. Sari, M. Ikhsan',
                        'type' => 'Prosiding Nasional',
                        'venue' => 'Seminar Nasional Teknologi Terapan',
                        'volume' => 'pp. 88-95',
                        'year' => 2026,
                    ],
                    [
                        'title' => 'Pengembangan Media Pembelajaran Interaktif untuk SMK Bidang Teknik',
                        'authors' => 'S. Hidayat, R. Amelia',
                        'type' => 'Prosiding Nasional',
                        'venue' => 'Konferensi Pendidikan Vokasi',
                        'volume' => 'pp. 201-208',
                        'year' => 2026,
                    ],
                ],
            ],
        ],
    ],

    '2025' => [
        'label' => 'Tahun 2025',
        'visitors' => 1240,
        'groups' => [
            [
                'key' => 'A',
                'title' => 'Jurnal Internasional Bereputasi',
                'items' => [
                    [
                        'title' => 'Route Optimization for Goods Distribution Using Genetic Algorithm',
                        'authors' => 'F. Mansyuri, T. Wijaya',
                        'type' => 'Jurnal Internasional',
                        'venue' => 'International Journal of Logistics',
                        'volume' => 'Vol. 31, No. 4',
                        'year' => 2025,
                    ],
                ],
            ],
            [
                'key' => 'B',
                'title' => 'Jurnal Nasional Terakreditasi',
                'items' => [
                    [
                        'title' => 'Sistem Deteksi Dini Kebocoran Pipa Air Berbasis Sensor Getar',
                        'authors' => 'D. Kurniawan, M. Fadli',
                        'type' => 'Jurnal Nasional Terakreditasi',
                        'venue' => 'Jurnal Teknik Elektro',
                        'volume' => 'Vol. 9, No. 2',
                        'year' => 2025,
                    ],
                    [
                        'title' => 'Pemanfaatan Limbah Kulit Kerang sebagai Material Bangunan Ramah Lingkungan',
                        'authors' => 'R. Saputra, N. Hasanah, A. Yusuf',
                        'type' => 'Jurnal Nasional Terakreditasi',
                        'venue' => 'Jurnal Teknik Sipil',
                        'volume' => 'Vol. 11, No. 1',
                        'year' => 2025,
                    ],
                ],
            ],
            [
                'key' => 'C',
                'title' => 'Prosiding Seminar Nasional',
                'items' => [
                    [
                        'title' => 'Aplikasi Pencatatan Keuangan Sederhana untuk Pedagang Pasar Tradisional',
                        'authors' => 'S. Nurhaliza, H. Pratama',
                        'type' => 'Prosiding Nasional',
                        'venue' => 'Seminar Nasional Pengabdian Masyarakat',
                        'volume' => 'pp. 54-61',
                        'year' => 2025,
                    ],
                ],
            ],
        ],
    ],

    '2024' => [
        'label' => 'Tahun 2024',
        'visitors' => 980,
        'groups' => [
            [
                'key' => 'A',
                'title' => 'Jurnal Internasional Bereputasi',
                'items' => [
                    [
                        'title' => 'Plant Leaf Disease Classification Using Convolutional Neural Network',
                        'authors' => 'A. Rahman, F. Mansyuri',
                        'type' => 'Jurnal Internasional',
                        'venue' => 'Journal of Agricultural Informatics',
                        'volume' => 'Vol. 15, No. 3',
                        'year' => 2024,
                    ],
                ],
            ],
            [
                'key' => 'B',
                'title' => 'Jurnal Nasional Terakreditasi',
                'items' => [
                    [
                        'title' => 'Sistem Informasi Geografis Pemetaan Potensi Wisata Batam',
                        'authors' => 'Y. Sari, M. Ikhsan',
                        'type' => 'Jurnal Nasional Terakreditasi',
                        'venue' => 'Jurnal Geografi Terapan',
                        'volume' => 'Vol. 7, No. 2',
                        'year' => 2024,
                    ],
                ],
            ],
            [
                'key' => 'C',
                'title' => 'Prosiding Seminar Nasional',
                'items' => [
                    [
                        'title' => 'Purwarupa Kendali Perangkat Listrik Rumah Berbasis Suara',
                        'authors' => 'L. Fitriani, N. Anwar',
                        'type' => 'Prosiding Nasional',
                        'venue' => 'Konferensi Nasional Rekayasa Elektro',
                        'volume' => 'pp. 33-40',
                        'year' => 2024,
                    ],
                ],
            ],
        ],
    ],
];
