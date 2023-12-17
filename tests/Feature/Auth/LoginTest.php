<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User\User;
use App\Providers\RouteServiceProvider;
use Database\Factories\User\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginScreenCanBeRendered(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function testUsersCanLoginUsingTheLoginScreen(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => UserFactory::PASSWORD,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testUsersVanNotLoginWithInvalidPassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => $this->faker->word(),
        ]);

        $this->assertGuest();
    }

    public function testUsersCanLogout(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('main'));
    }
}
