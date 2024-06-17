<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User\User;
use App\Notifications\User\VerifyRegistration;
use Database\Factories\User\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notification;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testNewUserCanRegister(): void
    {
        Notification::fake();

        $response = $this->post(route('register'), [
            'username' => fake()->word(),
            'email' => $email = fake()->email(),
            'password' => UserFactory::PASSWORD,
            'password_confirmation' => UserFactory::PASSWORD,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirectToRoute('register.notice');

        /** @var User $user */
        $user = User::firstWhere('email', $email);

        $this->assertNotNull($user);
        $this->assertAuthenticated();
        $this->assertTrue($user->status->isWait());

        Notification::assertSentTo($user, VerifyRegistration::class);
    }

    public function testRegisterVerificationNotificationCanBeResend(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $response = $this->actingAs($user)
            ->fromRoute('register.notice')
            ->get(route('register.notify'));

        $response->assertSessionHasNoErrors();
        $response->assertRedirectToRoute('register.notice');

        Notification::assertSentTo($user, VerifyRegistration::class);
    }

    public function testRegistrationCanBeVerified(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('register.verify', [
                'token' => $user->verifyToken->token,
            ]));

        $user->refresh();

        $this->assertTrue($user->status->isActive());
        $this->assertNull($user->verifyToken);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/');
    }
}
