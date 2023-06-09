<?php

namespace App\Exceptions;

use App\Exceptions\CustomException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if (request()->is('api/*')) {
                return $this->resolveApiException($e);
            }
        });
    }

    private function resolveApiException(Throwable &$e): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], $e instanceof CustomException ? $e->getStatusCode() : 500);
    }
}
