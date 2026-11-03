<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Kolom "body_blocks" berisi isi berita sebagai blok terstruktur (JSON),
 * bukan HTML. Admin menyusun isi lewat editor blok di panel, jadi tidak perlu
 * menulis kode. Kolom "body" tetap ada untuk kompatibilitas data lama.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_posts', function (Blueprint $table) {
            $table->json('body_blocks')->nullable()->after('body');
        });
    }

    public function down(): void
    {
        Schema::table('news_posts', function (Blueprint $table) {
            $table->dropColumn('body_blocks');
        });
    }
};
