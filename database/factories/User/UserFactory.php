<?php

declare(strict_types=1);

namespace Database\Factories\User;
use App\Models\User\Email;
use App\Models\User\Gender;
use App\Models\User\Status;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class UserFactory extends Factory
{
    public const PASSWORD = 'password';

    public function definition(): array
    {
        return [
            'email' => new Email(fake()->unique()->safeEmail()),
            'username' => fake()->unique()->word(),
            'password' => static::PASSWORD,
            'status' => Status::Active,
            'fullname' => fake()->name(),
            'bio' => fake()->text(150),
            'location' => fake()->country(),
            'gender' => Arr::random([null, Gender::Male, Gender::Female]),
            'birth_date' => fake()->date(),
        ];
    }

    public function withAvatar(?UploadedFile $avatar = null): static
    {
        if (!$avatar) {
            $avatar = UploadedFile::fake()->image('avatar.png');
        }

        return $this->afterCreating(function (User $user) use ($avatar) {
            $user->avatar->setImage($avatar);
        });
    }
}
