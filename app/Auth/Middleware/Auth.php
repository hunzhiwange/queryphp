<?php

declare(strict_types=1);

namespace App\Auth\Middleware;

use App\Auth\Exceptions\AuthBusinessException;
use App\Auth\Exceptions\AuthErrorCode;
use App\Company\Entity\App;
use App\Company\Service\InjectAccount;
use App\Company\Service\InjectCommonData;
use App\Company\Service\InjectPlatformCompany;
use App\Infra\Exceptions\LockException;
use App\Infra\Exceptions\UnauthorizedHttpException;
use App\Infra\Helper\CreateSignature;
use App\Infra\Lock;
use App\Infra\Proxy\Permission;
use Leevel\Auth\AuthException;
use Leevel\Auth\Manager;
use Leevel\Auth\Middleware\Auth as BaseAuth;
use Leevel\Encryption\Proxy\Encryption;
use Leevel\Http\Request;
use Leevel\Kernel\IApp;
use Symfony\Component\HttpFoundation\Response;

/**
 * 认证中间件.
 */
class Auth extends BaseAuth
{
    /**
     * 忽略锁定路由.
     */
    private array $ignoreLockPathInfo = [
        'app:user/user/lock',
        'app:user/user/unlock',
        'app:auth/login/logout',
    ];

    /**
     * 忽略路由.
     */
    private array $ignorePathInfo = [
        'app:auth/login/logout',
        'app:auth/login/code',
        'app:auth/login/validate',
    ];

    /**
     * 忽略权限路由.
     */
    private array $ignorePermissionPathInfo = [
        'app:auth/login/logout',
        'app:user/user/update-info',
        'app:user/user/lock',
        'app:user/user/unlock',
        'app:user/user/change-password',
        'app:user/user/permission',
        'app:user/user/info',
    ];

    /**
     * 应用秘钥.
     */
    private string $appSecret = '';

    /**
     * 构造函数.
     */
    public function __construct(
        protected Manager $manager,
        protected IApp $app
    ) {
        parent::__construct($manager);
    }

    /**
     * 请求.
     *
     * @throws \App\Infra\Exceptions\UnauthorizedHttpException|\Exception
     */
    public function handle(\Closure $next, Request $request): Response
    {
        if ($request::METHOD_OPTIONS === $request->getMethod()) {
            return $next($request);
        }

        $token = $this->normalizeToken($request);
        $this->manager->setTokenName($token);

        if ($this->isIgnoreRouter($request)) {
            return $next($request);
        }

        try {
            if ($isLogin = $this->manager->isLogin()) {
                $this->validateLock($request, $token);
                if (!$this->isIgnorePermission($request)) {
                    static::validatePermission($request);
                }
            }

            if (true !== container()->make('ignore_validate_signature', throw: false)) {
                // 校验格式化
                $this->validateFormat($request);

                // 校验应用
                $this->validateAppKey($request);
            }

            // 开发模式不校验过期时间和签名
            if (true !== container()->make('ignore_validate_signature', throw: false) && !$this->app->isDebug()) {
                // 校验过期时间
                $this->validateExpired($request);

                // 校验签名
                $this->validateSignature($request, $this->appSecret);
            }

            // 注入公司 ID
            $this->setPlatformCompanyId();

            // 注入账号信息
            if ($isLogin) {
                $this->setAccount();
            }

            // 注入公共信息
            $this->injectCommonData();

            return parent::handle($next, $request);
        } catch (AuthException) {
            throw new UnauthorizedHttpException(AuthErrorCode::PERMISSION_AUTHENTICATION_FAILED);
        }
    }

    /**
     * 权限校验.
     *
     * @throws \App\Auth\Exceptions\AuthBusinessException|\Exception
     */
    public static function validatePermission(Request $request): void
    {
        $pathInfo = static::getPathInfo($request);
        $method = strtolower($request->getMethod());
        if (!Permission::handle($pathInfo, $method)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_NO_PERMISSION);
        }
    }

    public static function getPathInfo(Request $request): string
    {
        // @phpstan-ignore-next-line
        return preg_replace('/\/apiQL\/v([0-9])+:/', '/', trim($request->getPathInfo(), '/'));
    }

    private function injectCommonData(): void
    {
        (new InjectCommonData())->handle();
    }

    /**
     * 注入平台和公司 ID.
     */
    private function setPlatformCompanyId(): void
    {
        // 先写死平台和公司，后续可以替换
        $platformId = 100000;
        $companyId = 100100;
        (new InjectPlatformCompany())->handle($platformId, $companyId);
    }

    /**
     * 注入账号信息.
     */
    private function setAccount(): void
    {
        $user = $this->manager->getLogin();
        (new InjectAccount())->handle($user['id'], $user['name']);
    }

    /**
     * 校验格式化.
     *
     * @throws \App\Auth\Exceptions\AuthBusinessException|\Exception
     */
    private function validateFormat(Request $request): void
    {
        $format = $request->get('format');
        if (empty($format)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_FORMAT_CANNOT_BE_EMPTY);
        }

        if (!\in_array($format, ['json'], true)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_FORMAT_NOT_SUPPORT);
        }
    }

    /**
     * 校验应用 KEY.
     *
     * @throws \App\Auth\Exceptions\AuthBusinessException|\Exception
     */
    private function validateAppKey(Request $request): void
    {
        $appKey = $request->get('app_key');
        if (empty($appKey)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_APP_KEY_CANNOT_BE_EMPTY);
        }

        // 如果 app_key 很长，表示这是为客户端生成的临时 app_key 需要解密
        if (\strlen($appKey) > 32) {
            $appKey = Encryption::decrypt($appKey);
            if (false === $appKey) {
                throw new AuthBusinessException(AuthErrorCode::AUTH_APP_KEY_INVALID);
            }
        }

        // 如果未传递了 app_secret，表示这是为服务端调用接口，只需要传递 app_key 和签名即可，无需传递秘钥
        $appSecret = $request->get('app_secret');
        if (empty($appSecret)) {
            $this->appSecret = $this->findAppSecret($appKey);

            return;
        }

        // 如果传递了 app_secret，表示这是为客户端生成的临时 app_secret 需要解密
        $this->appSecret = (string) $appSecret;
        $appSecret = Encryption::decrypt($appSecret);
        if (false === $appSecret) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_APP_SECRET_INVALID);
        }
    }

    /**
     * 查找应用秘钥.
     *
     * @throws \Exception
     */
    private function findAppSecret(string $appKey): string
    {
        return App::repository()->findAppSecretByKey($appKey);
    }

    /**
     * 校验是否过期.
     *
     * @throws \App\Auth\Exceptions\AuthBusinessException|\Exception
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
     * @throws \App\Auth\Exceptions\AuthBusinessException|\Exception
     */
    private function validateSignature(Request $request, string $appSecret): void
    {
        // 不能包含 attributes，前端生成签名不包含，否则签名无效
        $params = $request->request->all() + $request->query->all();
        if (empty($params['signature'])) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_SIGNATURE_CANNOT_BE_EMPTY);
        }
        if (empty($params['signature_method'])) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_SIGNATURE_METHOD_CANNOT_BE_EMPTY);
        }
        if (!\in_array($params['signature_method'], ['hmac_sha256'], true)) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_SIGNATURE_METHOD_NOT_SUPPORT);
        }

        $signature = $params['signature'];
        unset($params['signature']);
        $currentSignature = CreateSignature::handle($params['signature_method'], $params, $appSecret);
        if ($currentSignature !== $signature) {
            throw new AuthBusinessException(AuthErrorCode::AUTH_SIGNATURE_VERIFY_FAILED);
        }
    }

    /**
     * 是否为忽略路由.
     */
    private function isIgnoreRouter(Request $request): bool
    {
        return \in_array(static::getPathInfo($request), $this->ignorePathInfo, true);
    }

    /**
     * 整理 token 数据.
     */
    private function normalizeToken(Request $request): string
    {
        // 兼容 header，也可以通过 get 或者 post 来设置 token
        if ($token = $request->headers->get('token')) {
            $request->query->set('token', $token);
            // @phpstan-ignore-next-line
            return $token;
        }

        if ($token = $request->request->get('token', '')) {
            // @phpstan-ignore-next-line
            return $token;
        }

        // @phpstan-ignore-next-line
        return $request->query->get('token', '') ?? '';
    }

    /**
     * 验证是否锁定.
     *
     * @throws \App\Infra\Exceptions\LockException|\Exception
     */
    private function validateLock(Request $request, string $token): void
    {
        if (!\in_array(static::getPathInfo($request), $this->ignoreLockPathInfo, true)
            && $token && (new Lock())->has($token)) {
            throw new LockException(AuthErrorCode::MANAGEMENT_SYSTEM_LOCKED);
        }
    }

    /**
     * 是否为忽略权限.
     */
    private function isIgnorePermission(Request $request): bool
    {
        return \in_array(static::getPathInfo($request), $this->ignorePermissionPathInfo, true);
    }
}
