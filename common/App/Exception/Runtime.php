<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\App\Exception;

use Exception;
use Leevel;
use Leevel\Http\IRequest;
use Leevel\Http\IResponse;
use Leevel\Leevel\Runtime as Runtimes;

/**
 * 异常处理.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.04.24
 *
 * @version 1.0
 */
class Runtime extends Runtimes
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
    public function render(IRequest $request, Exception $e): IResponse
    {
        return parent::render($request, $e);
    }

    /**
     * 获取 HTTP 状态的异常模板
     *
     * @param Exception $e
     *
     * @return string
     */
    public function getHttpExceptionView(Exception $e)
    {
        return Leevel::commonPath('ui/exception/'.$e->getStatusCode().'.php');
    }

    /**
     * 获取 HTTP 状态的默认异常模板
     *
     * @return string
     */
    public function getDefaultHttpExceptionView()
    {
        return Leevel::commonPath('ui/exception/default.php');
    }
}
