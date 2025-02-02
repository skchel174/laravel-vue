<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User;

use App\Models\User\Email;
use Tests\TestCase;

class EmailTest extends TestCase
{
    public function testCreateNewEmail(): void
    {
        $email = new Email($newEmail = fake()->email());

        $this->assertEquals($newEmail, $email->getValue());
        $this->assertNull($email->getNewValue());
    }

    public function testAssertChangeEmail(): void
    {
        $email = new Email(fake()->email());

        $email->change($newEmail = fake()->email());

        $this->assertNotNull($email->getNewValue());
        $this->assertEquals($newEmail, $email->getNewValue());

        $this->assertTrue($email->isChangeRequested());
    }

    public function testEmailChangeConfirmation(): void
    {
        $email = new Email($oldEmail = fake()->email());

        $email->change($newEmail = fake()->email());

        $email->confirmChange();

        $this->assertNotEquals($oldEmail, $email->getValue());
        $this->assertEquals($newEmail, $email->getValue());
        $this->assertNull($email->getNewValue());

        $this->assertFalse($email->isChangeRequested());
    }
}
