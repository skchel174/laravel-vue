<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('CASCADE');
        });

        Schema::create('article_topic', function (Blueprint $table) {
            $table->foreignId('article_id');
            $table->foreignId('topic_id');

            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('CASCADE');

            $table->foreign('topic_id')
                ->references('id')
                ->on('topics')
                ->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_topic');
        Schema::dropIfExists('topics');
    }
};
