<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_category', function (Blueprint $table) {
            $table->primary(['category_id', 'article_id']);
            $table->foreignId('article_id');
            $table->foreignId('category_id');

            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('CASCADE');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_category');
    }
};
