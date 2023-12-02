<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class SetAvatarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function testSetAvatar(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->setAvatar(UploadedFile::fake()->image('avatar.jpg'));

        $avatar = $user->getFirstMedia('avatar');

        $this->assertInstanceOf(Media::class, $avatar);
        $this->assertEquals('avatar', $avatar->name);
        Storage::disk('public')->assertExists($avatar->getPathRelativeToRoot());
    }

    public function testChangeAvatar()
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $user->setAvatar(UploadedFile::fake()->image('new-avatar.jpg'));

        $avatar = $user->getFirstMedia('avatar');

        $this->assertEquals('new-avatar', $avatar->name);
    }

    public function testDeleteAvatar(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $user->setAvatar(null);

        $this->assertNull($user->getFirstMedia('avatar'));
    }
}
