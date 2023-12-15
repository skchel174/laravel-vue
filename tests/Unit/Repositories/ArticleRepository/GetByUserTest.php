<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\ArticleRepository;

use App\Models\Article\Article;
use App\Models\Article\Status;
use App\Models\User\User;
use App\Repositories\ArticleRepository;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetByUserTest extends TestCase
{
    use RefreshDatabase;

    public function testGetPublishedArticlesByUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        Article::factory($cnt = 5)
            ->create(['author_id' => $user]);

        Article::factory(5)
            ->create(['author_id' => User::factory()]);

        $repository = new ArticleRepository();

        $articles = $repository->getByAuthor($user, Status::Published);

        $this->assertInstanceOf(LengthAwarePaginator::class, $articles);
        $this->assertContainsOnlyInstancesOf(Article::class, $articles->items());
        $this->assertCount($cnt, $articles);
        $this->assertEmpty($user->articles->diff($articles->items()));
    }

    public function testGetDeletedArticlesByUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $articles = Article::factory($cnt = 5)
            ->create([
                'author_id' => $user,
                'status' => Status::Deleted,
                'deleted_at' => CarbonImmutable::now(),
            ]);

        Article::factory(6)
            ->create(['author_id' => $user]);

        Article::factory(10)
            ->create(['author_id' => User::factory()]);

        $repository = new ArticleRepository();

        $deletedArticles = $repository->getByAuthor($user, Status::Deleted);

        $this->assertCount($cnt, $deletedArticles);
        $this->assertEmpty($articles->diff($deletedArticles->items()));
    }
}
