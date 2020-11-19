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

use Admin\App\Exception\LockException;
use Admin\Infra\Lock;
use Closure;
use Common\Infra\Exception\BusinessException;
use Common\Infra\Exception\UnauthorizedHttpException;
use Common\Infra\Proxy\Permission;
use Leevel\Auth\AuthException;
use Leevel\Auth\Middleware\Auth as BaseAuth;
use Leevel\Http\Request;

/**
 * auth 中间件.
 */
class Auth extends BaseAuth
{
    /**
     * 忽略锁定路由.
     *
     * @return array
     */
    private array $ignoreLockPathInfo = [
        '/:admin/user/lock',
        '/:admin/user/unlock',
        '/:admin/login/logout',
    ];

    /**
     * 忽略路由.
     *
     * @return array
     */
    private array $ignorePathInfo = [
        '/:admin/login/code',
        '/:admin/login/validate',
    ];

    /**
     * 忽略权限路由.
     *
     * @return array
     */
    private array $ignorePermissionPathInfo = [
        '/:admin/login/logout',
        '/:admin/user/update-info',
        '/:admin/user/lock',
        '/:admin/user/unlock',
        '/:admin/user/change-password',
        '/:admin/user/permission',
        '/:admin/user/info',
        '/:admin/search',
    ];

    /**
     * 请求.
     *
     * @throws \Common\Infra\Exception\UnauthorizedHttpException
     */
    public function handle(Closure $next, Request $request): void
    {
        if ($request::METHOD_OPTIONS === $request->getMethod() || $this->isIgnoreRouter($request)) {
            $next($request);

            return;
        }

        try {
            $token = $this->normalizeToken($request);
            if ($this->manager->isLogin()) {
                $this->validateLock($request, $token);
                if (!$this->isIgnorePermission($request)) {
                    $this->validatePermission($request);
                }
            }

            parent::handle($next, $request);
        } catch (AuthException) {
            throw new UnauthorizedHttpException(__('权限认证失败'));
        }
    }

    /**
     * 是否为忽略路由.
     */
    private function isIgnoreRouter(Request $request): bool
    {
        return \in_array($request->getPathInfo(), $this->ignorePathInfo, true);
    }

    /**
     * 整理 token 数据.
     */
    private function normalizeToken(Request $request): string
    {
        // 兼容 header，也可以通过 get 或者 post 来设置 token
        if ($token = $request->headers->get('token')) {
            $request->query->set('token', $token);
        } else {
            $token = $request->query->get('token', '');
        }

        return $token;
    }

    /**
     * 验证是否锁定.
     *
     * @throws \Admin\App\Exception\LockException
     */
    private function validateLock(Request $request, string $token): void
    {
        if (!\in_array($request->getPathInfo(), $this->ignoreLockPathInfo, true) &&
            $token && (new Lock())->has($token)) {
            throw new LockException(__('系统已锁定'));
        }
    }

    /**
     * 是否为忽略权限.
     */
    private function isIgnorePermission(Request $request): bool
    {
        return \in_array($request->getPathInfo(), $this->ignorePermissionPathInfo, true);
    }

    /**
     * 权限校验.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    private function validatePermission(Request $request): void
    {
        $pathInfo = str_replace('/:admin/', '', $request->getPathInfo());
        $method = strtolower($request->getMethod());

        if (!Permission::handle($pathInfo, $method)) {
            throw new BusinessException(__('你没有权限执行操作'));
        }
    }
}
