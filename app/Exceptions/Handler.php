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
        $this->renderable(function (DomainException $e, Request $request) {
            if ($request->is('api/*')) {
                $data = ['notification' => Notification::error($e->getMessage())];
                return response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });
    }

    public function render($request, Throwable $e): Response
    {
        $response = parent::render($request, $e);

        if (app()->hasDebugModeEnabled()) {
            return $response;
        }

        if ($e instanceof DomainException) {
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message = $e->getMessage();
        } else {
            $status = $response->status();
            $message = Response::$statusTexts[$status] ?? Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR];
        }

        $back = url()->previous() !== url()->current()
            ? url()->previous()
            : route('main');

        return Inertia::render(
            'Error/ErrorPage',
            compact('status', 'message', 'back'),
        )
            ->toResponse($request)
            ->setStatusCode($status);
    }


}
