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

namespace Common\Infra\Exception;

use Leevel\Kernel\Exception\NotFoundHttpException as BaseNotFoundHttpException;

/**
 * 未找到.
 *
 * - 用户发出的请求针对的是不存在的记录: 404.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2018.04.29
 *
 * @version 1.0
 */
class NotFoundHttpException extends BaseNotFoundHttpException
{
}
