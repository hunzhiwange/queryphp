<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\LockException;
use App\Infra\Lock;
use App\Domain\Entity\Base\App;
use App\Exceptions\AuthBusinessException;
use App\Exceptions\AuthErrorCode;
use Closure;
use App\Exceptions\UnauthorizedHttpException;
use App\Infra\Proxy\Permission;
use App\Infra\Repository\Base\App as BaseApp;
use Leevel\Auth\AuthException;
use Leevel\Auth\Middleware\Auth as BaseAuth;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Http\Request;
use Leevel\Kernel\IApp;
use Symfony\Component\HttpFoundation\Response;
use function App\Infra\Helper\create_signature;
use Leevel\Auth\Manager;

/**
 * auth 中间件.
 */
class Auth extends BaseAuth
{
    /**
     * 忽略锁定路由.
     */
    private array $ignoreLockPathInfo = [
        'user/lock',
        'user/unlock',
        'login/logout',
    ];

    /**
     * 忽略路由.
     */
    private array $ignorePathInfo = [
        'login/code',
        'login/validate',
    ];

    /**
     * 忽略权限路由.
     */
    private array $ignorePermissionPathInfo = [
        'login/logout',
        'user/update-info',
        'user/lock',
        'user/unlock',
        'user/change-password',
        'user/permission',
        'user/info',
        'search',
    ];

    /**
     * 应用秘钥.
     */
    private string $appSecret;

    /**
     * 构造函数.
     */
    public function __construct(
        protected Manager $manager,
        protected IApp $app
    )
    {
        parent::__construct($manager);
    }

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

            // 校验格式化
            $this->validateFormat($request);

            // 校验应用
            $this->validateAppKey($request);

            // 开发模式不校验过期时间和签名
            if (!$this->app->isDebug()) {
                // 校验过期时间
                $this->validateExpired($request);

                // 校验签名
                $this->validateSignature($request, $this->appSecret);
            }

            return parent::handle($next, $request);
        } catch (AuthException) {
            throw new UnauthorizedHttpException(AuthErrorCode::PERMISSION_AUTHENTICATION_FAILED);
        }
    }

    /**
     * 校验格式化.
     * 
     * @throws \App\Exceptions\AuthBusinessException
     */
    private function validateFormat(Request $request): void
    {
        $format = $request->get('format');
        if (empty($format)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_FORMAT_CANNOT_BE_EMPTY);
        }

        if (!in_array($format, ['json'], true)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_FORMAT_NOT_SUPPORT);
        }
    }

    /**
     * 校验应用 KEY.
     * 
     * @throws \App\Exceptions\AuthBusinessException
     */
    private function validateAppKey(Request $request): void
    {
        $appKey = $request->get('app_key');
        if (empty($appKey)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_APP_KEY_CANNOT_BE_EMPTY);
        }

        $this->appSecret = $this->findAppSecret($appKey);
    }

    /**
     * 查找应用秘钥.
     */
    private function findAppSecret(string $appKey): string
    {
        return $this
            ->appReposity()
            ->findAppSecretByKey($appKey);
    }

    private function appReposity(): BaseApp
    {
        return UnitOfWork::make()->repository(App::class);
    }

    /**
     * 校验是否过期.
     * 
     * @throws \App\Exceptions\AuthBusinessException
     */
    private function validateExpired(Request $request): void
    {
        $timestamp = $request->get('timestamp');
        if (empty($timestamp)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_TIMESTAMP_CANNOT_BE_EMPTY);
        }

        // 接口 5 分钟过期
        if ((int) $timestamp + 300 * 1000 < time() * 1000) {
           throw new AuthBusinessException(AuthErrorCode::AUTH_TIMESTAMP_EXPIRED);
        }
    }

    /**
     * 校验签名.
     * 
     * @throws \App\Exceptions\AuthBusinessException
     */
    private function validateSignature(Request $request, string $appSecret): void
    {
        // 不能包含 attributes，前端生成签名不包含，否则签名无效通过
        $params = $request->request->all() + $request->query->all();
        if (empty($params['signature'])) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_SIGNATURE_CANNOT_BE_EMPTY);
        }
        if (empty($params['signature_method'])) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_SIGNATURE_METHOD_CANNOT_BE_EMPTY);
        }
        if (!in_array($params['signature_method'], ['hmac_sha256'], true)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_SIGNATURE_METHOD_NOT_SUPPORT);
        }

        $signature = $params['signature'];
        unset($params['signature']);
        $currentSignature = func(fn() => create_signature($params['signature_method'], $params, $appSecret));
        if ($currentSignature !== $signature) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_SIGNATURE_VERIFY_FAILD);
        }
    }

    /**
     * 是否为忽略路由.
     */
    private function isIgnoreRouter(Request $request): bool
    {
        return \in_array($this->getPathInfo($request), $this->ignorePathInfo, true);
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
        if (!\in_array($this->getPathInfo($request), $this->ignoreLockPathInfo, true) &&
            $token && (new Lock())->has($token)) {
            throw new LockException(AuthErrorCode::MANAGEMENT_SYSTEM_LOCKED);
        }
    }

    /**
     * 是否为忽略权限.
     */
    private function isIgnorePermission(Request $request): bool
    {
        return \in_array($this->getPathInfo($request), $this->ignorePermissionPathInfo, true);
    }

    /**
     * 权限校验.
     *
     * @throws \App\Exceptions\AuthBusinessException
     */
    private function validatePermission(Request $request): void
    {
        $pathInfo = $this->getPathInfo($request);
        $method = strtolower($request->getMethod());
        if (!Permission::handle($pathInfo, $method)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_NO_PERMISSION);
        }
    }

    private function getPathInfo(Request $request): string
    {
        // 去掉前缀
        return preg_replace('/^api\/v([0-9])+:/', '', trim($request->getPathInfo(), '/'));
    }
}
