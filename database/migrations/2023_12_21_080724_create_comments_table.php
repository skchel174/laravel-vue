<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id');
            $table->foreignId('article_id');
            $table->morphs('commentable');
            $table->text('text');
            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
