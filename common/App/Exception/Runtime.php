<?php 
// (c) 2018 http://your.domain.com All rights reserved.
namespace Common\App\Exception;

use Exception;
use Throwable;
use Leevel\Http\Request;
use Leevel\Http\Response;
use Leevel\Bootstrap\Runtime\Runtime as Runtimes;

/**
 * 异常处理
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2018.04.24
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
    public function render(Request $request, Exception $e)
    {
        return parent::render($request, $e);
    }

    /**
     * 获取 HTTP 状态的异常模板
     * 
     * @param Exception $e
     * @return string
     */
    public function getHttpExceptionView(Exception $e) {
        return path_common('ui/exception/' . $e->getStatusCode() . '.php');
    }

    /**
     * 获取 HTTP 状态的默认异常模板
     * 
     * @return string
     */
    public function getDefaultHttpExceptionView() {
        return path_common('ui/exception/default.php');
    }
}
