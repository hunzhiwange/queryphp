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

namespace Admin\App\Middleware;

use Closure;
use Leevel\Http\IRequest;
use Leevel\Http\IResponse;

/**
 * Cors 中间件.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2019.08.07
 *
 * @version 1.0
 */
class Cors
{
    /**
     * 响应.
     */
    public function terminate(Closure $next, IRequest $request, IResponse $response): void
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers'     => 'Origin, X-Requested-With, Content-Type, Accept, token',
            'Access-Control-Allow-Credentials' => 'true',
        ];
        $response->withHeaders($headers);

        $next($request, $response);
    }
}
