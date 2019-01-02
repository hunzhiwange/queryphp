<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\App\Middleware;

use Admin\App\Exception\LockException;
use Admin\Infra\Lock;
use Closure;
use Leevel\Auth\AuthException;
use Leevel\Auth\Middleware\Auth as BaseAuth;
use Leevel\Http\IRequest;
use Leevel\Kernel\UnauthorizedHttpException;

/**
 * auth 中间件.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2017.11.14
 *
 * @version 1.0
 */
class Auth extends BaseAuth
{
    /**
     * 请求
     *
     * @param \Closure              $next
     * @param \Leevel\Http\IRequest $request
     */
    public function handle(Closure $next, IRequest $request): void
    {
        // header('Access-Control-Allow-Origin: '.($_SERVER['HTTP_ORIGIN'] ?? ''));
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, token');

        // 跨域校验
        if ($request->isOptions()) {
            echo 'Die because of CORS';
            die;
        }

        if (in_array($pathInfo = $request->getPathInfo(), $this->ignorePathInfo(), true)) {
            $next($request);

            return;
        }

        // 兼容 header，也可以通过 get 或者 post 来设置 token
        if ($token = $request->headers->get('token')) {
            $request->query->set('token', $token);
        }

        try {
            // 后台已锁定
            if (!in_array($pathInfo, $this->ignoreLockPathInfo(), true) &&
                (new Lock())->has($token)) {
                throw new LockException(__('系统已锁定'));
            }

            parent::handle($next, $request);
        } catch (AuthException $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        }
    }

    /**
     * 忽略路由.
     *
     * @return array
     */
    protected function ignorePathInfo(): array
    {
        return [
            '/:admin/login/code',
            '/:admin/login/validate',
        ];
    }

    /**
     * 忽略锁定路由.
     *
     * @return array
     */
    protected function ignoreLockPathInfo(): array
    {
        return [
            '/:admin/user/lock',
            '/:admin/user/unlock',
            '/:admin/login/logout',
        ];
    }
}
