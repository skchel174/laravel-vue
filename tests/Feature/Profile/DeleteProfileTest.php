<?php

declare(strict_types=1);

namespace Tests\Feature\Profile;

use App\Models\User\User;
use Database\Factories\User\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanDeleteTheirAccount(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('profile.delete'), [
                'password' => UserFactory::PASSWORD,
            ]);

        $response->assertRedirect(route('main'));
        $response->assertSessionHasNoErrors();

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }
}
