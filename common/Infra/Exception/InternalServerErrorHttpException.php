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

use Leevel\Kernel\Exception\InternalServerErrorHttpException as BaseInternalServerErrorHttpException;

/**
 * 服务器内部错误.
 *
 * - 服务器遇到错误，无法完成请求: 500.
 */
class InternalServerErrorHttpException extends BaseInternalServerErrorHttpException
{
}
