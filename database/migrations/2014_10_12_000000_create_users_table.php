<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('about')->nullable();
            $table->string('email')->unique();
            $table->string('new_email')->nullable();
            $table->string('password');
            $table->string('status', 30);
            $table->rememberToken();
            $table->string('verify_token', 100)->unique()->nullable();
            $table->timestamp('verify_token_created_at')->nullable();
            $table->timestamp('login_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
