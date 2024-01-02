<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Events\User\PasswordChanged;
use App\Models\User\Password;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testChangePassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => Password::create($oldPassword = 'old_password'),
        ]);

        Event::shouldReceive('dispatch')
            ->once()
            ->with(Mockery::on(function ($arg) use ($user) {
                return $arg instanceof PasswordChanged && $arg->user->is($user);
            }));

        $user->changePassword(Password::create($newPassword = 'new_password'));

        $this->assertTrue(Hash::check($newPassword, $user->password));
        $this->assertFalse(Hash::check($oldPassword, $user->password));
    }
}
