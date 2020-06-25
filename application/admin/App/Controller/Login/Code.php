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

namespace Admin\App\Controller\Login;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Login\Code as Service;
use function Common\Infra\Helper\force_close_debug;
use Leevel\Http\Request;
use Leevel\Http\Response;

/**
 * 验证码.
 *
 * @codeCoverageIgnore
 */
class Code
{
    use Controller;

    public function handle(Request $request, Service $service): Response
    {
        $code = $service->handle($this->input($request));
        $this->forceCloseDebug();

        return new Response($code, 200, ['Content-type' => 'image/png']);
    }

    private function input(Request $request): array
    {
        return [
            'id' => $request->query->get('id'),
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
