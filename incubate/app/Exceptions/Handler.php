<?php

namespace App\Exceptions;

use Exception;
use Auth;
use Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
         return response()->view('errors/404');
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
            switch ($statusCode) {
                case '404':
                return response()->view('errors/404');
                case '500':
                return response()->view('errors/error_ex');
            }

        }
        if($exception instanceof ValidationException) {
            return parent::render($request, $exception);
        }
         Log::debug($exception->getMessage());
         return response()->view('errors/error_ex');
        
         
    }
}
