<?php

declare(strict_types=1);

namespace Tests;

use Faker\Generator;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = resolve(Generator::class);
    }
}
