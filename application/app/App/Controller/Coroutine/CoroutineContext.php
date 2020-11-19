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

namespace App\App\Controller\Coroutine;

use Leevel\Di\IContainer;
use Swoole\Coroutine;

/**
 * 协程：上下文.
 *
 * @codeCoverageIgnore
 */
class CoroutineContext
{
    /**
     * - 请不要在嵌套协程中以当前协程 ID 获取上下文服务.
     * - 可以在根协程获取后或者根据根协程 ID 来获取.
     */
    public function handle(IContainer $container): string
    {
        /** @var \Leevel\Http\Request $request $ */
        $rightRequest = \App::make('request');
        $rootCid = Coroutine::getCid();

        dump('root cid');
        dump(Coroutine::getCid());
        dump('root pcid');
        dump(Coroutine::getPcid());

        go(function () use ($container, $rightRequest, $rootCid) {
            dump('child 1 cid');
            dump(Coroutine::getCid());
            dump('child 1 pcid');
            dump($pid = Coroutine::getPcid());

            $request = $container->make('request', [], 9999999);
            dump($request); // string `request`

            $request = $container->make('request');
            dump($request); // string `request`

            $request = $container->make('request', [], $pid);
            dump($request::class); // string `\Leevel\Http\Request`

            $request = $container->make('request', [], $rootCid);
            dump($request:class); // string `\Leevel\Http\Request`

            dump($rightRequest::class); // string `\Leevel\Http\Request`

            go(function () use ($container, $rightRequest, $rootCid) {
                dump('child 2 cid');
                dump(Coroutine::getCid());
                dump('child 2 pcid');
                dump(Coroutine::getPcid());

                $request = $container->make('request', [], 9999999);
                dump($request); // string `request`

                $request = $container->make('request');
                dump($request); // string `request

                $request = $container->make('request', [], $rootCid);
                dump($request::class); // string `\Leevel\Http\Request`

                dump($rightRequest::class); // string `\Leevel\Http\Request`
            });
        });

        return 'Done';
    }
}
