<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User\Avatar;

use App\Models\User\Avatar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewAvatar(): void
    {
        Config::set(['assets' => [
            'avatar' => [
                'disk' => 'public',
                'path' => '',
            ],
        ]]);

        Storage::fake('public');

        $avatar = Avatar::create(UploadedFile::fake()->image('test.jpg'));

        $cnf = config('assets.avatar');

        $this->assertInstanceOf(Avatar::class, $avatar);
        $this->assertNotEmpty($avatar->getFile());
        $this->assertTrue(Storage::disk($cnf['disk'])->exists($cnf['path'] . '/' . $avatar->getFile()));
    }
}
