<?php

namespace App\Exceptions;

use App\Enums\ErrorMessages;
use App\Support\Helpers\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    public static function handle(Request $request, Throwable $exception)
    {
        return match (true) {
            $exception instanceof AuthenticationException => ApiResponse::error(ErrorMessages::Unauthenticated->message(), 401),

            $exception instanceof AuthorizationException => ApiResponse::error(ErrorMessages::Unauthorized->message(), 403),

            $exception instanceof BaseException => ApiResponse::error($exception->getMessage(), $exception->getCode()),

            $exception instanceof MethodNotAllowedHttpException => ApiResponse::error(ErrorMessages::MethodNotAllowed->message(), 405),

            $exception instanceof ModelNotFoundException => ApiResponse::error(ErrorMessages::ModelNotFound->message(), 404),

            $exception instanceof NotFoundHttpException => ApiResponse::error(ErrorMessages::NotFound->message(), 404),

            $exception instanceof ValidationException => ApiResponse::error($exception->getMessage(), 422, $exception->errors()),

            default => ApiResponse::error(
                config('app.debug') ? $exception->getMessage() : ErrorMessages::InternalServerError->message(),
                500,
                config('app.debug') ? $exception->getTrace() : null
            ),
        };
    }
}
