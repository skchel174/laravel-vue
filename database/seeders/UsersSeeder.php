<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Topic\Topic;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(9)->create();

        User::factory()->create([
            'login' => 'user',
            'email' => 'user@mail.demo',
        ]);

        $users = User::all();

        $topics = Topic::all();

        foreach ($users as $user) {
            /** @var User $user */

            $user->topics()->attach($topics->random(rand(3, 10)));

            $followers = $users
                ->filter(fn($item) => !$user->is($item))
                ->random(rand(0, 9));

            $user->followers()->attach($followers);
        }
    }
}
