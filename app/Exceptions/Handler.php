<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        if (!$request->expectsJson()) {
            return parent::render($request, $e);
        }
        return response()->json([
            'success' => false,
            'message' => $this->getResponseString($response),
            'realError' => $response->getContent()
        ], $response->status());

    }

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

    private function getResponseString(Response|JsonResponse|\Symfony\Component\HttpFoundation\Response $response): string
    {
        return match ($response->status()) {
            403 => 'ليس لديك صلاحية للوصول لهذه الصفحة',
            401 => 'لا يمكنك الدخول لهذه الصفحة',
            419 => 'خطأ 419 ، يرجى الرجوع للإدارة',
            404 => 'الصفحة المطلوبة غير موجودة',
            500 => 'حدث خطأ ما ، يرجى مراجعة الإدارة إذا تكرر الأمر',
            default => "{$response->status()} خطأ"
        };
    }
}
