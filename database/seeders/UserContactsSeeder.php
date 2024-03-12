<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\ContactType;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class UserContactsSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getContactTypes() as $attributes) {
            ContactType::create($attributes);
        }

        $contactTypes = ContactType::all();

        foreach (User::all() as $user) {
            /** @var User $user */

            $contactTypes->random(rand(1, 5))
                ->each(function (ContactType $contactType) use ($user) {
                    $value = match ($contactType->name) {
                        'Email' => $user->email,
                        'Website' => 'https://example.com/',
                        default => fake()->word(),
                    };

                    $user->contacts()->create([
                        'value' => $value,
                        'contact_type_id' => $contactType->id,
                    ]);
                });
        }
    }

    private function getContactTypes(): array
    {
        return [
            ['name' => 'Website', 'template' => '{placeholder}', 'icon' => 'web.png'],
            ['name' => 'Email', 'template' => 'mailto:{placeholder}', 'icon' => 'email.png'],
            ['name' => 'Github', 'template' => 'https://github.com/{placeholder}', 'icon' => 'github.png'],
            ['name' => 'Telegram', 'template' => 'https://telegram.me/{placeholder}', 'icon' => 'telegram.png'],
            ['name' => 'Habr', 'template' => 'https://habr.com/en/users/{placeholder}', 'icon' => 'habr.png'],
        ];
    }
}
