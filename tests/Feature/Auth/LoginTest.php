<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User\User;
use Database\Factories\User\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanLogin(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => UserFactory::PASSWORD,
        ]);

        $this->assertAuthenticated();

        $response->assertSessionHasNoErrors();

        $response->assertRedirect('/');
    }

    public function testUserNotLoginWithInvalidEmail(): void
    {
        $response = $this->post(route('login'), [
            'email' => fake()->email(),
            'password' => UserFactory::PASSWORD,
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    public function testUserNotLoginWithInvalidPassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => fake()->word(),
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors('password');
    }

    public function testUsersCanLogout(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('logout'));

        $this->assertGuest();

        $response->assertRedirect('/');
    }
}
