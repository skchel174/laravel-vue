<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User\User;
use App\Models\User\VerifyToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPasswordLinkScreenCanBeRendered(): void
    {
        $response = $this->get(route('password.forgot'));

        $response->assertStatus(200);
    }

    public function testResetPasswordLinkCanBeRequested(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => VerifyToken::create(),
        ]);

        $response = $this->post(route('password.forgot.email'), [
            'email' => $user->email,
        ]);

        $response->assertSessionHas('status');
        $response->assertRedirect(route('login'));
    }

    public function testResetPasswordScreenCanBeRendered(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => VerifyToken::create(),
        ]);

        $response = $this->get(route('password.reset.form', [
            'token' => $user->verify_token->getValue(),
        ]));

        $response->assertStatus(200);
    }

    public function testPasswordCanBeResetWithValidToken(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => VerifyToken::create(),
        ]);

        $response = $this->post(route('password.reset'), [
            'token' => $user->verify_token->getValue(),
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertSessionHas('status');
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('login'));
    }
}
