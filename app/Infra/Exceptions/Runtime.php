<?php

declare(strict_types=1);

namespace App\Infra\Exceptions;

use Leevel\Http\Request;
use Leevel\Kernel\Exceptions\HttpException;
use Leevel\Kernel\Exceptions\Runtime as ExceptionRuntime;
use Symfony\Component\HttpFoundation\Response;

/**
 * 异常运行时.
 */
class Runtime extends ExceptionRuntime
{
    /**
     * {@inheritDoc}
     */
    public function report(\Throwable $e): void
    {
        parent::report($e);
    }

    /**
     * {@inheritDoc}
     */
    public function render(Request $request, \Throwable $e): Response
    {
        return parent::render($request, $e);
    }

    /**
     * 获取 HTTP 状态的异常模板.
     */
    public function getHttpExceptionView(HttpException $e): string
    {
        return \Leevel::path(sprintf('assets/exceptions/%d.php', $e->getStatusCode()));
    }

    /**
     * 获取 HTTP 状态的默认异常模板.
     */
    public function getDefaultHttpExceptionView(): string
    {
        return \Leevel::path('assets/exceptions/default.php');
    }

    /**
     * 获取 JSON 状态的异常模板.
     */
    public function getJsonExceptionView(HttpException $e): string
    {
        return \Leevel::path(sprintf('assets/exceptions/%d.php', $e->getStatusCode()));
    }

    /**
     * 获取 JSON 状态的默认异常结果.
     */
    public function getDefaultJsonExceptionData(\Throwable $e): array
    {
        return [
            'error' => [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ],
        ];
    }
}
