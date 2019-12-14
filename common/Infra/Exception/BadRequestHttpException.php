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

use Leevel\Kernel\Exception\BadRequestHttpException as BaseBadRequestHttpException;

/**
 * 错误请求.
 *
 * - 服务器不理解请求的语法: 400.
 */
class BadRequestHttpException extends BaseBadRequestHttpException
{
}
