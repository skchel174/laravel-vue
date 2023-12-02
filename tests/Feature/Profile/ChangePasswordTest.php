<?php

declare(strict_types=1);

namespace Tests\Feature\Profile;

use App\Models\User\User;
use Database\Factories\User\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testChangePassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch(route('profile.password.change'), [
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
                'current_password' => UserFactory::PASSWORD,
            ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status', 'Password successfully changed');
        $response->assertSessionHasNoErrors();
    }
}
