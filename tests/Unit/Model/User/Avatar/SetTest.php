<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User\Avatar;

use App\Models\User\Avatar;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SetTest extends TestCase
{
    use RefreshDatabase;

    public function testSetNewAvatar(): void
    {
        Storage::fake('public');

        /** @var User $user */
        $user = User::factory()->create([
            'avatar' => null,
        ]);

        $user->update(['avatar' => Avatar::create(UploadedFile::fake()->image('demo.jpg'))]);
        $user->refresh();

        $this->assertInstanceOf(Avatar::class, $user->avatar);
        $this->assertFileExists($user->avatar->getFilePath());
    }

    public function testChangeAvatar(): void
    {
        Storage::fake(config('filesystem.avatars.disk'));

        /** @var User $user */
        $user = User::factory()->create([
            'avatar' => $oldAvatar = Avatar::create(UploadedFile::fake()->image('demo.jpg')),
        ]);

        $user->update(['avatar' => Avatar::create(UploadedFile::fake()->image('demo.jpg'))]);
        $user->refresh();

        $this->assertNotEquals($oldAvatar->getFilePath(), $user->avatar->getFilePath());
        $this->assertFileExists($user->avatar->getFilePath());
        $this->assertFileDoesNotExist($oldAvatar->getFilePath());
    }

    public function testDeleteAvatar(): void
    {
        Storage::fake('public');

        /** @var User $user */
        $user = User::factory()->create([
            'avatar' => $oldAvatar = Avatar::create(UploadedFile::fake()->image('demo.jpg')),
        ]);

        $user->update(['avatar' => null]);

        $this->assertNull($user->avatar);
        $this->assertFileDoesNotExist($oldAvatar->getFilePath());
    }
}
