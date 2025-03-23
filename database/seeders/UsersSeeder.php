<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\Email;
use App\Models\User\Gender;
use App\Models\User\Status;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => new Email('user@app.com'),
            'username' => 'JDoe',
            'fullname' => 'John Doe',
            'password' => Hash::make('password'),
            'status' => Status::Active,
            'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'location' => 'New York, USA',
            'gender' => Gender::Male,
            'birth_date' => '1990-01-01',
        ]);
    }
}
