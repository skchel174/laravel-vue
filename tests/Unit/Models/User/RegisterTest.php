<?php

declare(strict_types=1);

namespace Tests\Unit\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Carbon\CarbonImmutable;
use App\Models\User\Status;
use App\Models\User\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterUser(): void
    {
        config(['auth.verification_timeout' => $seconds = 3600]); // 1 час

        $user = User::register(
            $email = 'user@test.com',
            $username = 'user',
            $password = 'secret'
        );

        $this->assertModelExists($user);
        $this->assertEquals($email, $user->email->getValue());
        $this->assertEquals($username, $user->username);
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertEquals(Status::Wait, $user->status);
        $this->assertNotNull($user->verify_token);
        $this->assertEquals(
            $user->verify_token->getExpirationDate()->format('Y-m-d H:i'),
            CarbonImmutable::now()->addSeconds($seconds)->format('Y-m-d H:i')
        );
    }
}
