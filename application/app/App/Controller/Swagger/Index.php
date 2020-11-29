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

namespace App\App\Controller\Swagger;

use function Common\Infra\Helper\force_close_debug;
use Leevel;
use function OpenApi\scan;

/**
 * Api 文档入口.
 *
 * @codeCoverageIgnore
 */
class Index
{
    /**
     * 响应.
     */
    public function handle(): string
    {
        // 扫描路径
        $path = array_merge($this->basePath(), $this->path());
        $openApi = scan($path);

        // 关闭调试模式
        $this->forceCloseDebug();

        return json_encode($openApi) ?: '';
    }

    /**
     * 扫描路径.
     */
    protected function path(): array
    {
        return [
            Leevel::appPath(),
        ];
    }

    /**
     * 基本路径.
     */
    protected function basePath(): array
    {
        return [
            Leevel::path('router'),
        ];
    }

    /**
     * 关闭调试模式.
     */
    private function forceCloseDebug(): void
    {
        func(fn () => force_close_debug());
    }
}
