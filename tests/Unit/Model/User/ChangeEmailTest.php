<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangeEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testChangeEmail(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->changeEmail($email = $this->faker->email());

        $this->assertEquals($user->new_email, $email);
        $this->assertNotEquals($user->email, $email);
        $this->assertNotNull($user->verify_token);
    }
}
