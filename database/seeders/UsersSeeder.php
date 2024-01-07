<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'login' => 'user',
            'email' => 'user@mail.demo',
        ]);

        User::factory(9)->create();
    }
}
