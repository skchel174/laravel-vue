<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeleteAvatarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function testAvatarHasBeenDeleted(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $avatar = $user->getAvatar();

        $user->deleteAvatar();

        $this->assertNull($user->getAvatar());
        $this->assertEmpty($user->media()->get());
        $this->assertFileDoesNotExist($avatar->getPath());
    }
}
