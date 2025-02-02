<?php

declare(strict_types=1);

use App\Models\User\Gender;
use App\Models\User\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('new_email')->nullable();
            $table->string('password');
            $table->string('username', 25)->unique();
            $table->string('fullname', 60)->nullable();
            $table->string('bio', 150)->nullable();
            $table->string('location', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', array_column(Gender::cases(), 'value'))->nullable();
            $table->enum('status', array_column(Status::cases(), 'value'));
            $table->rememberToken();
            $table->string('verify_token', 100)->nullable();
            $table->timestamp('verify_token_expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
