<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\App;

use Exception;
use Leevel;
use Leevel\Http\Request;
use Leevel\Kernel\ExceptionRuntime as BaseExceptionRuntime;
use Symfony\Component\HttpFoundation\Response;

/**
 * 异常处理.
 */
class ExceptionRuntime extends BaseExceptionRuntime
{
    /**
     * {@inheritdoc}
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * {@inheritdoc}
     */
    public function render(Request $request, Exception $e): Response
    {
        return parent::render($request, $e);
    }

    /**
     * 获取 HTTP 状态的异常模板.
     */
    public function getHttpExceptionView(Exception $e): string
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
