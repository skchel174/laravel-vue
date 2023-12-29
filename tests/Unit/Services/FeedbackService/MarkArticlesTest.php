<?php

declare(strict_types=1);

namespace Tests\Unit\Services\FeedbackService;

use App\Models\Article\Article;
use App\Models\User\User;
use App\Service\FeedbackService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarkArticlesTest extends TestCase
{
    use RefreshDatabase;

    public function testMarkArticles(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Article $article01 */
        $article01 = Article::factory()
            ->likedBy($user)
            ->create();

        /** @var Article $article02 */
        $article02 = Article::factory()
            ->bookmarkedBy($user)
            ->create();

        $service = new FeedbackService();

        $service->markArticles($user, [$article01, $article02]);

        $this->assertTrue($article01->is_liked);
        $this->assertFalse($article01->is_bookmarked);

        $this->assertFalse($article02->is_liked);
        $this->assertTrue($article02->is_bookmarked);
    }
}
