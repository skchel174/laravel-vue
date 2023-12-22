<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\ArticleRepository;

use App\Models\Article\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetByIdTest extends TestCase
{
    use RefreshDatabase;

    public function testGetArticleById(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        $repository = new ArticleRepository();

        $articleById = $repository->getById($article->id);

        $this->assertInstanceOf(Article::class, $articleById);
        $this->assertTrue($article->is($articleById));
        $this->assertTrue($articleById->status->isPublished());
    }

    public function testGetArticleByInvalidId(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $repository = new ArticleRepository();

        $repository->getById(1);
    }
}
