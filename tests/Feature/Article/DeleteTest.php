<?php

declare(strict_types=1);

namespace Tests\Feature\Article;

use App\Models\Article\Article;
use App\Models\Article\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    public function testDeletePublishedArticle(): void
    {
        /** @var Article $article */
        $article = Article::factory()
            ->create();

        $response = $this->actingAs($article->author)
            ->from(route('user.articles', ['user' => $article->author->id]))
            ->delete(route('article.delete', ['article' => $article->id]));

        $response->assertRedirect(route('user.articles', ['user' => $article->author->id]));
        $response->assertSessionHas('notice', trans('article.deleted'));

        $article->refresh();

        $this->assertModelExists($article);
        $this->assertEquals(Status::Deleted, $article->status);
    }

    public function testDeleteAlreadyDeletedArticle(): void
    {
        /** @var Article $article */
        $article = Article::factory()
            ->create(['status' => Status::Deleted]);

        $response = $this->actingAs($article->author)
            ->from(route('user.articles', ['user' => $article->author->id]))
            ->delete(route('article.delete', ['article' => $article->id]));

        $response->assertRedirect(route('user.articles', ['user' => $article->author->id]));
        $response->assertSessionHas('notice', trans('article.deleted'));

        $this->assertModelMissing($article);
    }
}
