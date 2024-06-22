<?php

declare(strict_types=1);

use App\Models\User\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 25)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', array_column(Status::cases(), 'value'));
            $table->rememberToken();
            $table->string('verify_token', 36)->nullable();
            $table->timestamp('verify_token_timestamp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
