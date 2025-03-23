<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User;

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

    public function testSetNewAvatar(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $image = UploadedFile::fake()->image('avatar.png');

        $user->setAvatar($image);

        $avatar = $user->getAvatar();

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

        $avatar = $user->getAvatar();

        $this->assertNotEmpty($avatar->getUrl());
        $this->assertNotEmpty($avatar->getUrl("md"));
        $this->assertNotEmpty($avatar->getUrl("xs"));
    }

    public function testNewOldAvatarChanged(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $oldAvatar = $user->getAvatar();

        $user->setAvatar(UploadedFile::fake()->image('new-avatar.png'));

        $newAvatar = $user->getAvatar();

        $media = $user->getMedia('avatar');
        $this->assertCount(1, $media);
        $this->assertDatabaseCount("media", 1);
        $this->assertEquals($newAvatar->file_name, $media->first()->file_name);
        $this->assertFileDoesNotExist($oldAvatar->getPath());
        $this->assertFileExists($newAvatar->getPath());
    }
}
