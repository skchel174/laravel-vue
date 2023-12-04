<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Article\Exceptions\ArticleNotDeleted;
use App\Models\Article\Status;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecoverTest extends TestCase
{
    use RefreshDatabase;

    public function testRestoreDeletedArticle(): void
    {
        /** @var Article $post */
        $post = Article::factory()->create([
            'status' => Status::Deleted,
            'deleted_at' => Carbon::now(),
        ]);

        $post->recover();

        $this->assertTrue($post->status === Status::Moderated);
        $this->assertNotSoftDeleted($post);
    }

    public function testRestoreNotDeletedArticle(): void
    {
        $this->expectException(ArticleNotDeleted::class);

        /** @var Article $post */
        $post = Article::factory()->create();

        $post->recover();
    }
}
