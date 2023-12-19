<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Profile\ProfileService;

use App\Events\User\ProfileUpdated;
use App\Models\User\User;
use App\Service\Profile\ProfileUpdateDto;
use App\Service\Profile\ProfileService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class UpdateProfileInfoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function testUpdateProfileInformation(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $dto = new ProfileUpdateDto(
            $this->faker->word(),
            $this->faker->name(),
            $this->faker->text(),
            UploadedFile::fake()->image('avatar.jpg'),
            true,
        );

        $dispatcher = $this->createDispatcher();
        $auth = $this->createAuthService($user);
        $session = $this->createMock(Session::class);

        $service = new ProfileService($dispatcher, $session, $auth);

        $service->updateProfileInfo($dto);

        $this->assertEquals($user->login, $dto->login);
        $this->assertEquals($user->name, $dto->name);
        $this->assertEquals($user->about, $dto->about);
        $this->assertInstanceOf(Media::class, $user->getAvatar());
        $this->assertEquals('avatar', $user->getAvatar()->name);
    }

    public function testDeleteProfileAvatar(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $dto = new ProfileUpdateDto(
            $this->faker->word(),
            $this->faker->name(),
            $this->faker->text(),
            null,
            true,
        );

        $dispatcher = $this->createDispatcher();
        $auth = $this->createAuthService($user);
        $session = $this->createMock(Session::class);

        $service = new ProfileService($dispatcher, $session, $auth);

        $service->updateProfileInfo($dto);

        $this->assertNull($user->getAvatar());
    }

    public function testUpdateProfileWithoutAvatar(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $avatar = $user->getAvatar();

        $dto = new ProfileUpdateDto(
            $this->faker->word(),
            $this->faker->name(),
            $this->faker->text(),
            null,
            false,
        );

        $dispatcher = $this->createDispatcher();
        $auth = $this->createAuthService($user);
        $session = $this->createMock(Session::class);

        $service = new ProfileService($dispatcher, $session, $auth);

        $service->updateProfileInfo($dto);

        $this->assertInstanceOf(Media::class, $user->getAvatar());
        $this->assertTrue($avatar->is($user->getAvatar()));
    }

    private function createAuthService(User $user): StatefulGuard
    {
        $service = $this->createMock(StatefulGuard::class);
        $service->expects($this->once())
            ->method('user')
            ->willReturn($user);

        return $service;
    }

    private function createDispatcher(): Dispatcher
    {
        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(ProfileUpdated::class));

        return $dispatcher;
    }
}
