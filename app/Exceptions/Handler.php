<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e, Request $request) {
            if ($e instanceof NotFoundHttpException) {
                return response()->json(['status' => Response::HTTP_NOT_FOUND, 'message' => Lang::get('message.not_found')], status: Response::HTTP_NOT_FOUND);
            }
            return response()->json(['status' => Response::HTTP_SERVICE_UNAVAILABLE, 'message' => $e->getMessage()], status: Response::HTTP_SERVICE_UNAVAILABLE);
        });
    }
}
