<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('text');
            $table->text('brief');
            $table->string('link')->nullable();
            $table->text('description')->nullable();
            $table->string('status', 100);
            $table->timestamp('publish_date')->nullable();
            $table->timestamps();

            $table->foreign('channel_id')
                ->references('id')
                ->on('channels')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
