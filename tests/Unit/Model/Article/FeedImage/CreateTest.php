<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article\FeedImage;

use App\Models\Article\FeedImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function testCreateArticleFeedImage(): void
    {
        Storage::fake('public');

        $image = FeedImage::create(UploadedFile::fake()->image('demo.jpg'));

        $this->assertInstanceOf(FeedImage::class, $image);
        $this->assertFileExists($image->getFile());
    }
}
