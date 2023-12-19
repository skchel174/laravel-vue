<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Profile\EmailUpdateService;

use App\Mail\VerifyEmail;
use App\Models\User\User;
use App\Service\Profile\EmailUpdateService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangeEmailTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfullyChangeEmail(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $newEmail = $this->faker->email();

        $mailer = $this->createMailer($newEmail);
        $auth = $this->createAuthService($user);
        $dispatcher = $this->createMock(Dispatcher::class);

        $service = new EmailUpdateService($mailer, $dispatcher, $auth);

        $service->changeEmail($newEmail);

        $this->assertNotNull($user->verify_token);
        $this->assertEquals($newEmail, $user->new_email);
    }

    private function createMailer(string $newEmail): Mailer
    {
        $mailer = $this->createMock(Mailer::class);
        $mailer->expects($this->once())
            ->method('to')
            ->with($newEmail)
            ->willReturn($mailer);
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(VerifyEmail::class));

        return $mailer;
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
