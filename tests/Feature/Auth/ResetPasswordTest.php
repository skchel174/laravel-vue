<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User\User;
use App\Models\User\VerifyToken;
use App\Notifications\User\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPasswordLinkCanBeRequested(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => VerifyToken::create(),
        ]);

        $response = $this->fromRoute('password.forgot')
            ->post(route('password.notify'), [
                'email' => $user->email,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirectToRoute('password.forgot');
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function testResetPasswordScreenCanBeRendered(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => VerifyToken::create(),
        ]);

        $response = $this->get(route('password', [
            'user' => $user->id,
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

        $response = $this->post(route('password.reset', [
            'user' => $user->id,
            'token' => $user->verify_token->getValue(),
        ]), [
            'password' => $newPassword = 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $user->refresh();

        $response->assertSessionHasNoErrors();
        $response->assertRedirectToRoute('login');
        $this->assertTrue($user->checkPassword($newPassword));
    }
}
