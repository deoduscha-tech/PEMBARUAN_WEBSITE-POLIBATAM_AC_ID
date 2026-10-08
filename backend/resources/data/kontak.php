<?php

/**
 * Data kontak Pusat P2M Polibatam.
 *
 * Dipakai KontakApiController untuk dilayani sebagai JSON ke front end Next.js.
 * Semua teks halaman Kontak ada di sini supaya front end murni menampilkan.
 *
 * Susunan mengikuti situs asli:
 *   Judul -> Kontak -> Alamat -> Peta lokasi -> Jumlah pengunjung
 */

return [
    'heading' => 'KONTAK P3M',

    // Judul kecil di atas isi kontak.
    'section_title' => 'Kontak',

    'contact_person' => [
        'role' => 'Kepala P3M Polibatam',
        'name' => 'Dr. Iman Fahruzi, S.T., M.T.',
        'emails' => [
            'ka-p3m@polibatam.ac.id',
            'p3m@polibatam.ac.id',
        ],
    ],

    'address' => [
        'label' => 'Alamat',
        'lines' => 'Jl. Ahmad Yani, Tlk. Tering, Kec. Batam Kota, Kota Batam, Kepulauan Riau 29461',
    ],

    // Peta lokasi Politeknik Negeri Batam.
    'map' => [
        'embed' => 'https://www.google.com/maps?q=Politeknik+Negeri+Batam&output=embed',
        'link' => 'https://maps.google.com/?q=Politeknik+Negeri+Batam',
        'height' => 520,
        'title' => 'Politeknik Negeri Batam',
    ],

    'visitors' => 3103,
];
