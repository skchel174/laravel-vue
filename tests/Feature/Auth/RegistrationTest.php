<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrationScreenCanBeRendered(): void
    {
        $response = $this->get(route('register.form'));

        $response->assertStatus(200);
    }

    public function testNewUserCanRegister(): void
    {
        $response = $this->post(route('register'), [
            'login' => $this->faker->word(),
            'email' => $this->faker->email(),
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(route('register.prompt'));
    }

    public function testRegisterVerificationScreenCanBeRendered(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('register.prompt'));

        $response->assertStatus(200);
    }

    public function testRegisterVerificationNotificationCanBeResend(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('register.email'));

        $response->assertRedirect(route('register.prompt'));
    }

    public function testRegistrationCanBeVerified(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('register.verify', [
                'token' => $user->verify_token->getValue(),
            ]));

        $response->assertRedirect(RouteServiceProvider::HOME . '?verified=1');
    }
}
