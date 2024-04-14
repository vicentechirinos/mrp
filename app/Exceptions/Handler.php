<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Routing\Exceptions\BackedEnumCaseNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        // dd(get_class($e));
        // dd($e instanceof InvalidArgumentException);

        $e = $this->prepareException($this->mapException($e), $request);

        return match (true) {
            $e instanceof HttpResponseException => $e->getResponse(),
            $e instanceof AuthenticationException => $this->responseFormat(null, $e->getMessage(), 401),
            $e instanceof ValidationException => $this->convertValidationExceptionToResponse($e, $request),
            $e instanceof InvalidArgumentException => $this->responseFormat(null, $e->getMessage(), 422),
            $e instanceof ModelNotFoundException => $this->responseFormat(null, $e->getMessage(), 404),
            default => $this->renderExceptionResponse($request, $e),
        };
    }

    /**
     * Prepare exception for rendering.
     *
     * @param  \Throwable  $e
     * @return \Throwable
     */
    protected function prepareException(Throwable $e, $request = null)
    {
        return match (true) {
            $e instanceof BackedEnumCaseNotFoundException => new NotFoundHttpException($e->getMessage(), $e),
            // $e instanceof ModelNotFoundException => new NotFoundHttpException($e->getMessage(), $e),
            $e instanceof AuthorizationException && $e->hasStatus() => new HttpException(
                $e->status(),
                $e->response()?->message() ?: (Response::$statusTexts[$e->status()] ?? 'Whoops, looks like something went wrong.'),
                $e
            ),
            $e instanceof AuthorizationException && !$e->hasStatus() => new AccessDeniedHttpException($e->getMessage(), $e),
            $e instanceof TokenMismatchException => new HttpException(419, $e->getMessage(), $e),
            $e instanceof SuspiciousOperationException => new NotFoundHttpException('Bad hostname provided.', $e),
            $e instanceof RecordsNotFoundException => new NotFoundHttpException('Not found.', $e),
            default => $e,
        };
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return $this->responseFormat(null, $e->getMessage(), $e->status);
    }

    /**
     * Render a default exception response if any.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderExceptionResponse($request, Throwable $e)
    {
        return $this->responseFormat(
            null,
            $e->getMessage(),
            $this->isHttpException($e) ? $e->getStatusCode() : 500
        );
    }
}
