<?php

declare(strict_types=1);

namespace Common\App;

use Leevel;
use Leevel\Http\Request;
use Leevel\Kernel\Exception\HttpException;
use Leevel\Kernel\ExceptionRuntime as BaseExceptionRuntime;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * 异常运行时.
 */
class ExceptionRuntime extends BaseExceptionRuntime
{
    /**
     * {@inheritDoc}
     */
    public function report(Throwable $e): void
    {
        parent::report($e);
    }

    /**
     * {@inheritDoc}
     */
    public function render(Request $request, Throwable $e): Response
    {
        return parent::render($request, $e);
    }

    /**
     * 获取 HTTP 状态的异常模板.
     */
    public function getHttpExceptionView(HttpException $e): string
    {
        return Leevel::commonPath('ui/exception/'.$e->getStatusCode().'.php');
    }

    /**
     * 获取 HTTP 状态的默认异常模板.
     */
    public function getDefaultHttpExceptionView(): string
    {
        return Leevel::commonPath('ui/exception/default.php');
    }
}
