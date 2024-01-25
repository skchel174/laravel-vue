<?php

declare(strict_types=1);

namespace Tests\Unit\Model\User\Avatar;

use App\Models\User\Avatar;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function testCreateAvatar(): void
    {
        Storage::fake('public');

        $avatar = Avatar::create(UploadedFile::fake()->image('demo.jpg'));

        $this->assertInstanceOf(Avatar::class, $avatar);
        $this->assertFileExists($avatar->getFilePath());
    }
}
