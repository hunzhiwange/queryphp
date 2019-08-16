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

use Leevel\Kernel\Exception\UnauthorizedHttpException as BaseUnauthorizedHttpException;

/**
 * 未授权.
 *
 * - 对于需要登录的网页，服务器可能返回此响应: 401.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2018.04.29
 *
 * @version 1.0
 */
class UnauthorizedHttpException extends BaseUnauthorizedHttpException
{
}
