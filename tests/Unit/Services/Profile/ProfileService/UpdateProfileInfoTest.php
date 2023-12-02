<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Profile\ProfileService;

use App\Events\User\ProfileUpdated;
use App\Models\User\User;
use App\Service\Profile\ProfileInfoDto;
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

        $dto = new ProfileInfoDto(
            $this->faker->name(),
            $this->faker->text(),
            UploadedFile::fake()->image('avatar.jpg'),
            true,
        );

        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(ProfileUpdated::class));

        $session = $this->createMock(Session::class);
        $auth = $this->createMock(StatefulGuard::class);

        $service = new ProfileService($dispatcher, $session, $auth);

        $service->updateProfileInfo($user, $dto);

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

        $dto = new ProfileInfoDto(
            $this->faker->name(),
            $this->faker->text(),
            null,
            true,
        );

        $dispatcher = $this->createMock(Dispatcher::class);
        $session = $this->createMock(Session::class);
        $auth = $this->createMock(StatefulGuard::class);

        $service = new ProfileService($dispatcher, $session, $auth);

        $service->updateProfileInfo($user, $dto);

        $this->assertNull($user->getAvatar());
    }

    public function testUpdateProfileWithoutAvatar(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $avatar = $user->getAvatar();

        $dto = new ProfileInfoDto(
            $this->faker->name(),
            $this->faker->text(),
            null,
            false,
        );

        $dispatcher = $this->createMock(Dispatcher::class);
        $session = $this->createMock(Session::class);
        $auth = $this->createMock(StatefulGuard::class);

        $service = new ProfileService($dispatcher, $session, $auth);

        $service->updateProfileInfo($user, $dto);

        $this->assertInstanceOf(Media::class, $user->getAvatar());
        $this->assertTrue($avatar->is($user->getAvatar()));
    }
}
