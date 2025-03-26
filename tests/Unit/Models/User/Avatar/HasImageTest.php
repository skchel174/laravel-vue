<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\Avatar;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HasImageTest extends TestCase
{
    use RefreshDatabase;

    public function testAvatarHasImage(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $this->assertTrue($user->avatar->hasImage());
    }

    public function testAvatarHasNotImage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertFalse($user->avatar->hasImage());
    }
}
