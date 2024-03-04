<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Models\Notification;
use DomainException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $dontReport = [
        DomainException::class,
    ];

    public function register(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            //
        });
    }

    public function render($request, Throwable $e): Response
    {
        if ($request->is('api/*')) {
            $data = ['notification' => Notification::error($e->getMessage())];
            return response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response = parent::render($request, $e);

        if (app()->hasDebugModeEnabled()) {
            return $response;
        }

        return Inertia::render('Error/ErrorPage', [
            'status' => $response->status(),
            'message' => Response::$statusTexts[$response->status()] ?? Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
            'back' => (url()->previous() !== url()->current()) ? url()->previous() : route('main'),
        ])
            ->toResponse($request)
            ->setStatusCode($response->status());
    }
}
