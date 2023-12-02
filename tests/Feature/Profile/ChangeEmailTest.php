<?php

declare(strict_types=1);

namespace Tests\Feature\Profile;

use App\Models\User\User;
use App\Models\User\VerifyToken;
use Database\Factories\User\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangeEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testRequestEmailChanging(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch(route('profile.email.change'), [
                'email' => $this->faker->email(),
                'password' => UserFactory::PASSWORD,
            ]);

        $response->assertRedirect(route('profile'));
        $response->assertSessionHas('status', 'verification-link-sent');
    }

    public function testVerifyNewEmail(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'new_email' => $this->faker->email(),
            'verify_token' => $token = VerifyToken::create(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('profile.email.verify', [
                'token' => $token->getValue(),
            ]));

        $response->assertRedirect(route('profile'));
        $response->assertSessionHas('status', 'Email successfully changed');
        $response->assertSessionHasNoErrors();
    }
}
