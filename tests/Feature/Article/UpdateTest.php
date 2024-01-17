<?php

declare(strict_types=1);

namespace Tests\Feature\Article;

use App\Models\Article\Article;
use App\Models\Article\Difficulty;
use App\Models\Tag\Tag;
use App\Models\Topic\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateArticle(): void
    {
        Storage::fake('public');

        /** @var Article $article */
        $article = Article::factory()
            ->withTopics(Topic::factory(1)->create())
            ->withTags(Tag::factory(4)->create())
            ->create();

        /** @var Collection<Topic> $topics */
        $topics = Topic::factory(3)->create();

        /** @var Collection<Tag> $tags */
        $tags = Tag::factory(5)->create();

        $response = $this
            ->from(route('article.editor', ['article' => $article->id]))
            ->actingAs($article->author)
            ->patch(route('article.update', ['article' => $article->id]), [
                'title' => $title = $this->faker->text(100),
                'text' => $text = $this->faker->text(),
                'summary' => $summary = $this->faker->text(),
                'image' => UploadedFile::fake()->image('image.jpg'),
                'topics' => $topics->pluck('id')->toArray(),
                'tags' => $tags->pluck('id')->toArray(),
                'difficulty' => Difficulty::Medium->value,
            ]);

        $article->refresh();

        $response->assertRedirect(route('article.editor', ['article' => $article->id]));

        $response->assertSessionHasNoErrors();

        $this->assertEquals($title, $article->title);
        $this->assertEquals($text, $article->text);
        $this->assertEquals($summary, $article->summary);
        $this->assertNotEmpty($article->feed_image);
        $this->assertEmpty($article->topics->diff($topics));
        $this->assertEmpty($article->tags->diff($tags));
        $this->assertEquals(Difficulty::Medium, $article->difficulty);
    }
}
