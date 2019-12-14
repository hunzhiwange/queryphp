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

use Leevel\Kernel\Exception\UnprocessableEntityHttpException as BaseUnprocessableEntityHttpException;

/**
 * 无法处理的实体.
 *
 * - 请求格式正确，但是由于含有语义错误，无法响应: 422.
 */
class UnprocessableEntityHttpException extends BaseUnprocessableEntityHttpException
{
}
