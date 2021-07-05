<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ResultType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
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
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException)
            return (new ApiController)->apiResponse(ResultType::Error, null, 'Kayıt bulunamadı', JsonResponse::HTTP_NOT_FOUND);
        //özel bir hata mesajı oluştrdk.
        if ($exception instanceof NotFoundHttpException)
            return (new ApiController)->apiResponse(ResultType::Error, null, 'sayfa bulunamadı', JsonResponse::HTTP_NOT_FOUND);

        return parent::render($request, $exception);
    }
}
