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

use Common\Infra\Helper\force_close_debug;
use Leevel;

/**
 * api 文档入口.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.12
 *
 * @version 1.0
 */
class Index
{
    /**
     * 响应.
     *
     * @return string
     */
    public function handle(): string
    {
        error_reporting(E_ERROR | E_PARSE | E_STRICT);

        $path = [
            Leevel::path('router'),
            Leevel::appPath(),
        ];

        $openApi = \OpenApi\scan($path);

        $this->forceCloseDebug();

        return json_encode($openApi);
    }

    /**
     * 关闭 debug.
     */
    private function forceCloseDebug(): void
    {
        f(force_close_debug::class);
    }
}
