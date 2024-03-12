<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_contact_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
            $table->string('template');
            $table->timestamps();
        });

        Schema::create('user_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('contact_type_id');
            $table->string('value');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->foreign('contact_type_id')
                ->references('id')
                ->on('user_contact_types')
                ->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_contacts');

        Schema::dropIfExists('user_contact_types');
    }
};
