<?php

declare(strict_types=1);

namespace Tests;

use Faker\Generator;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = resolve(Generator::class);
    }

    /**
     * @return Generator
     */
    protected function getFaker(): Generator
    {
        return $this->faker;
    }
}
