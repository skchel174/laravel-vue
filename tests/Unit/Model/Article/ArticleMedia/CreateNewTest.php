<?php

declare(strict_types=1);

namespace Tests\Unit\Model\Article\ArticleMedia;

use App\Models\Article\ArticleMedia;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateNewTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewArticleStub(): void
    {
        /** @var User $author */
        $author = User::factory()->create();

        $stub = ArticleMedia::createNew($author);

        $this->assertInstanceOf(ArticleMedia::class, $stub);
        $this->assertTrue($stub->author->is($author));
    }
}
