<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    // public function render($request, Throwable $e)
    // {
    //     // Handle exceptions and errors here
    //     if ($e instanceof \Exception) {
    //         if ($e instanceof \Illuminate\Auth\AuthenticationException) {
    //             if (in_array('api', $e->guards())) {
    //                 return \App\Http\Controllers\API\ApiController::error('Invalid AUTH Token', 401);
    //             }
    //         }
    //         return parent::render($request, $e);
    //         // Handle exceptions
    //         // For example, you can return a custom error page or response.
    //         return response()->view('errors.custom', [], 500);
    //     } elseif ($e instanceof \Error) {
    //         // Handle errors
    //         // For example, you can return a custom error page or response.
    //         return response()->view('errors.custom', [], 500);
    //     }

    //     return parent::render($request, $e);
    // }
    public function render($request, Throwable $exception)
    {
        // Check if it's an HTTP exception
        if ($this->isHttpException($exception)) {
            // For HTTP exceptions, return the response as JSON
            return response()->json([
                'error' => $exception->getMessage(),
            ], $exception->getStatusCode());
        }

        // For other exceptions, handle them normally
        return parent::render($request, $exception);
    }
}
