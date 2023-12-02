<?php

declare(strict_types=1);

namespace Tests\Feature\Profile;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::disk('public');
    }

    public function testProfilePageIsDisplayed(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('profile'));

        $response->assertOk();
    }

    public function testProfileInformationCanBeUpdated(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->withAvatar()
            ->create();

        $response = $this
            ->actingAs($user)
            ->patch(route('profile.update'), [
                'name' => $name = $this->faker->name(),
                'about' => $about = $this->faker->text(),
                'avatar' => UploadedFile::fake()->image('new-avatar.jpg'),
            ]);

        $response->assertRedirect(route('profile'));
        $response->assertSessionHas('status', 'Profile successfully updated');
        $response->assertSessionHasNoErrors();

        $user->refresh();

        $this->assertEquals($name, $user->name);
        $this->assertEquals($about, $user->about);
        $this->assertEquals('new-avatar', $user->getAvatar()->name);
    }
}
