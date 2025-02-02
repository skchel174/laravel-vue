<?php

declare(strict_types=1);

namespace App\Models\User;

class Email
{
    public function __construct(
        private string $email,
        private ?string $new_email = null
    )
    {
    }

    public function getValue(): string
    {
        return $this->email;
    }

    public function getNewValue(): ?string
    {
        return $this->new_email;
    }

    public function change(string $email): void
    {
        $this->new_email = $email;
    }

    public function isChangeRequested(): bool
    {
        return $this->new_email !== null;
    }

    public function confirmChange(): void
    {
        $this->email = $this->new_email;
        $this->new_email = null;
    }
}
