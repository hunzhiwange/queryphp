<?php

declare(strict_types=1);

namespace Admin\Middleware;

use App\Exceptions\LockException;
use Admin\Infra\Lock;
use App\Exceptions\AuthBusinessException;
use App\Exceptions\AuthErrorCode;
use Closure;
use App\Exceptions\UnauthorizedHttpException;
use App\Infra\Proxy\Permission;
use Leevel\Auth\AuthException;
use Leevel\Auth\Middleware\Auth as BaseAuth;
use Leevel\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * auth 中间件.
 */
class Auth extends BaseAuth
{
    /**
     * 忽略锁定路由.
     */
    private array $ignoreLockPathInfo = [
        '/:admin/user/lock',
        '/:admin/user/unlock',
        '/:admin/login/logout',
    ];

    /**
     * 忽略路由.
     */
    private array $ignorePathInfo = [
        '/:admin/login/code',
        '/:admin/login/validate',
    ];

    /**
     * 忽略权限路由.
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
     * @throws \App\Exceptions\UnauthorizedHttpException
     */
    public function handle(Closure $next, Request $request): Response 
    {
        if ($request::METHOD_OPTIONS === $request->getMethod() || 
            $this->isIgnoreRouter($request)) {
            return $next($request);
        }

        try {
            $token = $this->normalizeToken($request);
            if ($this->manager->isLogin()) {
                $this->validateLock($request, $token);
                if (!$this->isIgnorePermission($request)) {
                    $this->validatePermission($request);
                }
            }

            return parent::handle($next, $request);
        } catch (AuthException) {
            throw new UnauthorizedHttpException(AuthErrorCode::PERMISSION_AUTHENTICATION_FAILED);
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
     * @throws \App\Exceptions\LockException
     */
    private function validateLock(Request $request, string $token): void
    {
        if (!\in_array($request->getPathInfo(), $this->ignoreLockPathInfo, true) &&
            $token && (new Lock())->has($token)) {
            throw new LockException(AuthErrorCode::MANAGEMENT_SYSTEM_LOCKED);
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
     * @throws \App\Exceptions\AuthBusinessException
     */
    private function validatePermission(Request $request): void
    {
        $pathInfo = str_replace('/:admin/', '', $request->getPathInfo());
        $method = strtolower($request->getMethod());
        if (!Permission::handle($pathInfo, $method)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_NO_PERMISSION);
        }
    }
}
