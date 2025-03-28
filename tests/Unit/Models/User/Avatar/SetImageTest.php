<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User\Avatar;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class SetImageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function testSetNewAvatar(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $image = UploadedFile::fake()->image('avatar.png');

        $user->avatar->setImage($image);

        $avatar = $user->avatar->getImage();

        $this->assertNotNull($avatar);
        $this->assertInstanceOf(Media::class, $avatar);
        $this->assertModelExists($avatar);
        $this->assertFileExists($image->getPath());
    }

    public function testAvatarHasConversations(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $avatar = $user->avatar->getImage();

        $this->assertNotEmpty($avatar->getUrl());
        $this->assertNotEmpty($avatar->getUrl('md'));
        $this->assertNotEmpty($avatar->getUrl('xs'));
    }

    public function testAvatarChanged(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $oldAvatar = $user->avatar->getImage();

        $user->avatar->setImage(UploadedFile::fake()->image('new-avatar.png'));

        $newAvatar = $user->avatar->getImage();

        $this->assertDatabaseCount("media", 1);
        $this->assertEquals('new-avatar.png', $newAvatar->name . '.' . $newAvatar->extension);
        $this->assertFileDoesNotExist($oldAvatar->getPath());
        $this->assertFileExists($newAvatar->getPath());
    }
}
