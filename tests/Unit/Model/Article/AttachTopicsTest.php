<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article;

use App\Models\Article\Article;
use App\Models\Topic\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttachTopicsTest extends TestCase
{
    use RefreshDatabase;

    public function testAttachTopicsToTheArticle(): void
    {
        /** @var Article $article */
        $article = Article::factory()->create();

        $topics = Topic::factory(2)->create();

        $article->attachTopic($topics);

        $this->assertNotEmpty($article->topics);
        $this->assertEquals($topics->pluck('id'), $article->topics->pluck('id'));
    }


}
