<?php

declare(strict_types=1);

namespace App\Casts;

use App\Casts\Exception\AssignTypeException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Title implements CastsAttributes
{
    private string $value;
    private string $slug;

    /**
     * @param string $value
     * @param string|null $slug
     * @return static
     */
    public static function create(string $value, ?string $slug = null): static
    {
        $title = new Title();
        $title->value = $value;
        $title->slug = $slug ?: Str::slug($value);

        return $title;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Cast the given value.
     *
     * @param null|string[] $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?static
    {
        if (empty($attributes['title']) || empty($attributes['slug'])) {
            return null;
        }

        return Title::create($attributes['title'], $attributes['slug']);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param string[] $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (!$value instanceof Title) {
            throw new AssignTypeException($model, $key, $value);
        }

        return [
            'title' => $value->getValue(),
            'slug' => $value->getSlug(),
        ];
    }
}
