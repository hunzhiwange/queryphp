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

namespace App\App\Controller\Api;

use Leevel\Http\IResponse;
use Leevel\Protocol\Facade\Rpc as Rpcs;

/**
 * rpc tests.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2018.08.31
 *
 * @version 1.0
 */
class Rpc
{
    /**
     * 默认方法.
     *
     * @return \Leevel\Http\IResponse
     */
    public function handle(): IResponse
    {
        return Rpcs::call('api/rpc/rpc-result', ['foo', 'bar'], ['arg1' => 'hello', 'arg2' => 'world']);
    }

    /**
     * RPC 结果.
     *
     * @return array
     */
    public function rpcResult(string $arg1, string $arg2, array $metas): array
    {
        return ['arg1' => $arg1, 'arg2' => $arg2, 'metas' => $metas];
    }
}
