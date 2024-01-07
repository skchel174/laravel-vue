<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User;

use App\Models\User\Avatar;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SetAvatarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set(['assets' => [
            'avatar' => [
                'disk' => $disk = 'public',
                'path' => '',
            ],
        ]]);

        Storage::fake($disk);
    }

    public function testNewAvatar(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'avatar' => null,
        ]);

        $user->setAvatar(UploadedFile::fake()->image('test.jpg'));

        $this->assertInstanceOf(Avatar::class, $user->avatar);
        $this->assertFileExists($user->avatar->getFilePath());
    }

    public function testChangeAvatar(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'avatar' => $oldAvatar = Avatar::create(UploadedFile::fake()->image('test01.jpg')),
        ]);

        $user->setAvatar(UploadedFile::fake()->image('test.jpg'));

        $this->assertNotEquals($user->avatar->getFile(), $oldAvatar->getFilePath());
        $this->assertFileExists($user->avatar->getFilePath());
        $this->assertFileDoesNotExist($oldAvatar->getFilePath());
    }

    public function testDeleteAvatar(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'avatar' => $oldAvatar = Avatar::create(UploadedFile::fake()->image('test01.jpg')),
        ]);

        $user->setAvatar(null);

        $this->assertNull($user->avatar);
        $this->assertFileDoesNotExist($oldAvatar->getFilePath());
    }
}
