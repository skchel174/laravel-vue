<?php

declare(strict_types=1);

namespace App\Events\Article;

use App\Models\Article\Article;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticleModerated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Article $article)
    {
    }
}
