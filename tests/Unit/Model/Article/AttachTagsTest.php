<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticleHasTag;
use App\Models\Tag\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttachTagsTest extends TestCase
{
    use RefreshDatabase;

    public function testAttachTags(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        $tags = Tag::factory(10)->create();

        $article->attachTags($tags);

        $this->assertNotEmpty($article->tags);
        $this->assertEquals($tags->pluck('id'), $article->tags->pluck('id'));
    }

    public function testAttachAlreadyAttachedTag(): void
    {
        $this->expectException(ArticleHasTag::class);

        /** @var Article $article */
        $article = Article::factory()
            ->hasAttached(Tag::factory(10))
            ->create();

        $article->attachTags($article->tags->random(2));
    }
}
