<?php

/**
 * Admin workspace credentials.
 *
 * Kept in config rather than the database while the project has no DB wired
 * up. Override via .env once you are ready to move to real users:
 *
 *   ADMIN_USERNAME=admin
 *   ADMIN_PASSWORD=admin123
 */
return [
    'username' => env('ADMIN_USERNAME', 'admin'),
    'password' => env('ADMIN_PASSWORD', 'admin123'),
    'name' => env('ADMIN_NAME', 'Administrator P3M'),

    // Session key used to flag an authenticated admin.
    'session_key' => 'p3m_admin',

    // Remember-me lifetime for the admin session, in minutes.
    'session_lifetime' => 120,
];
