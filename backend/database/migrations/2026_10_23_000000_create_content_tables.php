<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category', 60)->index();
            $table->string('author', 80)->default('P3M');
            $table->date('published_on')->index();
            $table->string('image', 500)->nullable();
            $table->string('excerpt', 600)->nullable();
            $table->boolean('featured')->default(false)->index();
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('published')->default(true)->index();
            $table->longText('body');
            $table->timestamps();
        });

        Schema::create('hki_years', function (Blueprint $table) {
            $table->unsignedSmallInteger('year')->primary();
            $table->unsignedBigInteger('views')->default(0);
            $table->json('records');
            $table->timestamps();
        });

        Schema::create('site_contents', function (Blueprint $table) {
            $table->string('key', 80)->primary();
            $table->json('value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_contents');
        Schema::dropIfExists('hki_years');
        Schema::dropIfExists('news_posts');
    }
};
