<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\Avatar;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeleteImageTest extends TestCase
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

        $avatar = $user->avatar->getImage();

        $user->avatar->deleteImage();

        $this->assertNull($user->avatar->getImage());
        $this->assertDatabaseCount("media", 0);
        $this->assertFileDoesNotExist($avatar->getPath());
    }
}
