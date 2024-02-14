<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->index();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->morphs('taggable');
            $table->foreignId('tag_id');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taggables');
        Schema::dropIfExists('tags');
    }
};
