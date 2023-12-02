<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Profile\EmailUpdateService;

use App\Mail\VerifyEmail;
use App\Models\User\User;
use App\Service\Profile\EmailUpdateService;
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

        $mailer = $this->createMock(Mailer::class);
        $mailer->expects($this->once())
            ->method('to')
            ->with($newEmail)
            ->willReturn($mailer);
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(VerifyEmail::class));

        $dispatcher = $this->createMock(Dispatcher::class);

        $service = new EmailUpdateService($mailer, $dispatcher);

        $service->changeEmail($user, $newEmail);

        $this->assertNotNull($user->verify_token);
        $this->assertEquals($newEmail, $user->new_email);
    }
}
