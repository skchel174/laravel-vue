<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User\User;
use App\Notifications\RegisterVerification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    use RefreshDatabase;

    public function testVerificationPageCanBeRendered(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('verification'));

        $response->assertStatus(200);
    }

    public function testResendRegisterVerificationMail(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $response = $this->actingAs($user)
            ->post(route('verification.send'));

        Notification::assertSentTo(
            $user,
            RegisterVerification::class,
            static function (RegisterVerification $notification, array $channels, User $notifiable) use ($user) {
                $sendToUser = $user->is($notifiable);
                $sendByEmail = in_array('mail', $channels, true);
                $urlHasToken = str_contains(
                    $notification->toMail($user)->actionUrl,
                    route('verification.confirm', [
                        'token' => $notifiable->verify_token->getValue()
                    ])
                );
                return $sendToUser && $sendByEmail && $urlHasToken;
            }
        );

        $response->assertRedirect(route('verification'));
    }

    public function testRegistrationCanBeVerified(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->unverified()
            ->create();

        $response = $this->actingAs($user)
            ->get(route('verification.confirm', [
                'token' => $user->verify_token->getValue(),
            ]));

        $response->assertRedirect(route('profile'));
    }
}
