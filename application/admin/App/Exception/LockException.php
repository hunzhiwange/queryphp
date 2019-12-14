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

namespace Admin\App\Exception;

use Exception;
use Leevel\Kernel\Exception\HttpException;

/**
 * 锁定异常.
 */
class LockException extends HttpException
{
    /**
     * 构造函数.
     *
     * @param null|string $message
     * @param int         $code
     * @param \Exception  $previous
     */
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        parent::__construct(424, $message, $code, $previous);
    }
}
