<?php

declare(strict_types=1);

namespace Tests\Feature\Article;

use App\Http\Resources\Article\ArticleImageResource;
use App\Models\Article\ArticleMedia;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateArticleMedia(): void
    {
        /** @var User $author */
        $author = User::factory()->create();

        $response = $this
            ->actingAs($author)
            ->post(route('api.article.media'));

        /** @var ArticleMedia $media */
        $media = ArticleMedia::first();

        $response->assertSessionHasNoErrors();

        $response->assertJson(['media' => $media->id]);
    }

    public function testAddImageForArticleMedia(): void
    {
        Storage::fake('public');

        /** @var ArticleMedia $stub */
        $stub = ArticleMedia::factory()->create();

        $response = $this
            ->actingAs($stub->author)
            ->post(route('api.article.media.image', ['media' => $stub->id]), [
                'image' => UploadedFile::fake()->image('image.jpg'),
            ]);

        $response->assertSessionHasNoErrors();

        $response->assertJson([
            'image' => ArticleImageResource::make($stub->getImages()->first())
                ->toArray(new Request()),
        ]);
    }
}
