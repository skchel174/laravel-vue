<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Locale;
use App\Services\FlashNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    public function __construct(private readonly FlashNotifier $notifier)
    {
    }

    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            'auth' => [
                'user' => $request->user(),
            ],

            'localization' => [
                'locale' => App::getLocale(),
                'langs' => Locale::langsMap(),
                'dictionary' => $this->getDictionary(),
            ],

            'alert' => $this->notifier->getAlert(),
        ];
    }

    private function getDictionary(): array
    {
        $file = base_path(sprintf('lang/%s.json', App::getLocale()));

        return file_exists($file)
            ? json_decode(file_get_contents($file), true)
            : [];
    }
}
