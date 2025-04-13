<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User\User;
use App\Notifications\RegisterVerification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterFormScreenRendered(): void
    {
        $response = $this->get(route('register.form'));

        $response->assertStatus(200);
    }

    public function testUserRegistered(): void
    {
        Notification::fake();

        $response = $this->post(route('register'), [
            'email' => $email = fake()->email(),
            'username' => fake()->word(),
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $user = User::firstWhere("email", $email);

        $this->assertNotNull($user);
        $this->assertAuthenticatedAs($user);

        Notification::assertSentTo(
            $user,
            RegisterVerification::class,
            static function (RegisterVerification $notification, array $channels, User $notifiable) use ($user) {
                $sendToUser = $user->is($notifiable);
                $sendByEmail = in_array('mail', $channels, true);
                $urlHasToken = str_contains(
                    $notification->toMail($user)->actionUrl,
                    route('register.verify', [
                        'token' => $notifiable->verify_token->getValue()
                    ])
                );
                return $sendToUser && $sendByEmail && $urlHasToken;
            }
        );

        $response->assertRedirect(route('register.report'));
    }
}
