<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Libraries\ResponseFactory;
use Throwable;

class Handler extends ExceptionHandler {

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
    public function register() {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception) {
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return ResponseFactory::setResponse('You are not authorized to perform this action', FALSE, 200, [
                        'status' => FALSE,
                        'message' => $exception->getMessage()
            ]);
        }
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return ResponseFactory::setResponse('Method not allowed', FALSE, 200, [
                        'status' => FALSE,
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
//                        'trace' => $exception->getTrace()
            ]);
        }
        if ($exception instanceof \InvalidArgumentException) {
            return ResponseFactory::setResponse('Invalid argument passed, check for the Get parameters', FALSE, 200, [
                        'status' => FALSE,
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
//                        'trace' => $exception->getTrace()
            ]);
        }

        if ($exception instanceof \Illuminate\Contracts\Container\BindingResolutionException) {
            return ResponseFactory::setResponse($exception->getMessage(), FALSE, 200, [
                        'status' => FALSE,
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
//                        'trace' => $exception->getTrace()
            ]);
        }
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return ResponseFactory::setResponse('No API/Web route found, Please check the API URL, Spelling etc.', FALSE, 200, [
                        'status' => FALSE,
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine()
            ]);
        }

        if ($exception instanceof \ArgumentCountError) {
            return ResponseFactory::setResponse('Paramters are missing for any function', FALSE, 200, [
                        'status' => FALSE,
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine()
            ]);
        }


        if ($exception instanceof \Illuminate\Database\QueryException) {
            return ResponseFactory::setResponse('There are errors in the DB Query.', FALSE, 200, [
                        'status' => FALSE,
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                        'trace' => $exception->getTrace()
            ]);
        }
        return parent::render($request, $exception);
    }

}
