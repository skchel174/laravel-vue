<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Session\Session;

readonly class FlashNotifier
{
    public function __construct(private Session $session)
    {
    }

    public function getAlert(): ?array
    {
        return $this->session->get('alert');
    }

    public function info(string $message): void
    {
        $this->notify('info', $message);
    }

    public function success(string $message): void
    {
        $this->notify('success', $message);
    }

    public function error(string $message): void
    {
        $this->notify('error', $message);
    }

    private function notify(string $type, string $message): void
    {
        $this->session->flash('alert', compact('type', 'message'));
    }
}
