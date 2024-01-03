<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class FollowersSeeder extends Seeder
{
    public function run(): void
    {
        /** @var User $user */
        $user = User::firstWhere('login', 'user');

        /** @var Collection<User> $users */
        $users = User::whereNot('login', 'user')->get();

        $user->followers()->sync($users);
        $user->following()->sync($users);
    }
}
