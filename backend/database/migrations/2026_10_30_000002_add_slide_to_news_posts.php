<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Kolom tambahan untuk mengatur urutan tampil di beranda.
 *
 *   show_in_slider : ikut muncul di slider besar beranda
 *   show_in_missed : ikut muncul di blok "You missed"
 *   sort_order     : angka urutan kecil tampil lebih dulu
 *
 * Sebelumnya slider & "You missed" hanya menampilkan 4 berita terbaru tanpa
 * cara mengaturnya dari admin.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_posts', function (Blueprint $table) {
            $table->boolean('show_in_slider')->default(true)->after('featured');
            $table->boolean('show_in_missed')->default(true)->after('show_in_slider');
            $table->integer('sort_order')->default(0)->after('show_in_missed');
        });
    }

    public function down(): void
    {
        Schema::table('news_posts', function (Blueprint $table) {
            $table->dropColumn(['show_in_slider', 'show_in_missed', 'sort_order']);
        });
    }
};
