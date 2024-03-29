<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Exceptions\Article\ArticleNotDeleted;
use App\Models\Article\Article;
use App\Models\Article\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestoreTest extends TestCase
{
    use RefreshDatabase;

    public function testRestoreDeletedArticle(): void
    {
        /** @var Article $post */
        $post = Article::factory()->create([
            'status' => Status::Deleted,
        ]);

        $post->restore();

        $this->assertTrue($post->status === Status::Moderated);
    }

    public function testRestoreNotDeletedArticle(): void
    {
        $this->expectException(ArticleNotDeleted::class);

        /** @var Article $post */
        $post = Article::factory()->create();

        $post->restore();
    }
}
