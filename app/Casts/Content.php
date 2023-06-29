<?php

declare(strict_types=1);

namespace App\Casts;

use App\Casts\Exception\AssignTypeException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Content implements CastsAttributes
{
    private string $text;
    private ?string $brief = null;

    /**
     * @param string $text
     * @param string|null $brief
     * @return static
     */
    public static function create(string $text, ?string $brief = null): static
    {
        $content = new static();
        $content->text = $text;
        $content->brief = $brief;

        return $content;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string|null
     */
    public function getBrief(): ?string
    {
        return $this->brief;
    }

    /**
     * Cast the given value.
     *
     * @param null|string[] $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?static
    {
        if (empty($attributes['text'])) {
            return null;
        }

        return Content::create($attributes['text'], $attributes['brief']);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param string[] $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (!$value instanceof Content) {
            throw new AssignTypeException($model, $key, $value);
        }

        return [
            'text' => $value->getText(),
            'brief' => $value->getBrief(),
        ];
    }
}
