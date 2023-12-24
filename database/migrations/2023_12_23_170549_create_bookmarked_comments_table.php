<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarked_comments', function (Blueprint $table) {
            $table->primary(['user_id', 'comment_id']);
            $table->foreignId('user_id');
            $table->foreignId('comment_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('comment_id')
                ->references('id')
                ->on('comments')
                ->onDelete('CASCADE');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('bookmarked_comments');
    }
};
