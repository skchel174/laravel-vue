<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id');
            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('article_media_id')
                ->nullable()
                ->after('feed_image');

            $table->foreign('article_media_id')
                ->references('id')
                ->on('article_media')
                ->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('article_media_id');
        });

        Schema::dropIfExists('article_media');
    }
};
