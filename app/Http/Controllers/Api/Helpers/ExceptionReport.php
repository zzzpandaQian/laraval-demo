<?php

namespace App\Http\Controllers\Api\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ExceptionReport
{
    use ApiResponse;

    /**
     * @var Exception
     */
    public $exception;
    /**
     * @var Request
     */
    public $request;

    /**
     * @var
     */
    protected $report;

    /**
     * @var array
     */
    public $doReport = [
        AuthenticationException::class => ['请先登录', 401],
        UnauthorizedHttpException::class => ['请先登录', 401],
        AuthorizationException::class => ['此行为未经授权', 403],
        ModelNotFoundException::class => ['模型未找到', 404],
    ];

    /**
     * ExceptionReport constructor.
     * @param Request $request
     * @param Exception $exception
     */
    public function __construct(Request $request, Exception $exception)
    {
        $this->request = $request;
        $this->exception = $exception;

        if ($exception instanceof ValidationException) {
            // 表单验证错误
            $error = array_first($this->exception->errors());
            $this->doReport[ValidationException::class] = [array_first($error), 400];
        }
    }

    /**
     * @return bool
     */
    public function shouldReturn()
    {
        if (! ($this->request->wantsJson() || $this->request->ajax())) {
            return false;
        }

        foreach (array_keys($this->doReport) as $report) {
            if ($this->exception instanceof $report) {
                $this->report = $report;
                return true;
            }
        }

        return false;
    }

    /**
     * @param Exception $e
     * @return static
     */
    public static function make(Exception $e)
    {
        return new static(\request(), $e);
    }

    /**
     * @return mixed
     */
    public function report()
    {
        $message = $this->doReport[$this->report];

        return $this->failed($message[0], $message[1]);
    }
}
