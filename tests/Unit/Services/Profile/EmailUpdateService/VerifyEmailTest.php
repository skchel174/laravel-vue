<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Profile\EmailUpdateService;

use App\Events\User\EmailChanged;
use App\Models\User\User;
use App\Models\User\VerifyToken;
use App\Service\Profile\EmailUpdateService;
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

        $mailer = $this->createMock(Mailer::class);

        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(EmailChanged::class));

        $service = new EmailUpdateService($mailer, $dispatcher);

        $service->verifyEmail($user, $token->getValue());

        $this->assertNull($user->verify_token);
        $this->assertEquals($newEmail, $user->email);
    }
}
