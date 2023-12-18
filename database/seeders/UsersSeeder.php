<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $config = config('filesystems.avatar_mask');
        $avatars = Storage::disk($config['disk'])
            ->files($config['directory']);

        User::factory()->create([
            'email' => 'user@mail.demo',
            'avatar_mask' => array_pop($avatars),
        ]);

        foreach ($avatars as $avatar) {
            User::factory()->create([
                'avatar_mask' => $avatar,
            ]);
        }
    }
}
