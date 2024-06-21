<?php

declare(strict_types=1);

use App\Http\Middleware\Auth\UnverifiedAccountsMiddleware;
use App\Http\Middleware\Auth\VerifiedAccountsMiddleware;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\ResolveLocaleMiddleware;
use App\Services\FlashNotifier;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            ResolveLocaleMiddleware::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->priority([
            StartSession::class,
            ResolveLocaleMiddleware::class,
        ]);

        $middleware->alias([
            'verified' => VerifiedAccountsMiddleware::class,
            'unverified' => UnverifiedAccountsMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (DomainException $exception) {
            app(FlashNotifier::class)->danger(trans($exception->getMessage()));

            return back();
        });
    })->create();
