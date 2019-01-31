<?php

namespace App\Exceptions;

use Exception;
use \Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = ['password', 'password_confirmation',];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            if ($request->ajax()) {
                return response()->json(['message' => $exception->getMessage()], 403);
            }
            return response()->view('admin.errors.'.$exception->getStatusCode(), compact('exception'));
        }

        return parent::render($request, $exception);
    }

    /**
     * 重写实现未认证用户跳转至相应登陆页
     *
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $exception->getMessage()], 401);
        } else {
            return in_array('admin', $exception->guards()) ? redirect()->guest(route('admin.login')) : redirect()->guest('login');
        }
    }

    /**
     * 表单验证错误, JSON 返回
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'code' => $exception->status,
            'message' => $exception->validator->errors()->first(),
            'errors' => $exception->errors(),
        ], Response::HTTP_OK);
    }
}
