<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Profile\EmailUpdateService;

use App\Events\User\EmailChanged;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use App\Service\Profile\EmailUpdateService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifyEmailChange(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'verify_token' => $token = VerifyToken::create(),
            'new_email' => $newEmail = $this->faker->email()
        ]);

        $dispatcher = $this->createDispatcher();
        $auth = $this->createAuthService($user);
        $mailer = $this->createMock(Mailer::class);

        $service = new EmailUpdateService($mailer, $dispatcher, $auth);

        $service->verifyEmail($token->getValue());

        $this->assertNull($user->verify_token);
        $this->assertEquals($newEmail, $user->email);
    }

    private function createDispatcher(): Dispatcher
    {
        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(EmailChanged::class));

        return $dispatcher;
    }

    private function createAuthService(User $user): StatefulGuard
    {
        $service = $this->createMock(StatefulGuard::class);
        $service->expects($this->once())
            ->method('user')
            ->willReturn($user);

        return $service;
    }
}
