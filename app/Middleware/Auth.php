<?php

declare(strict_types=1);

namespace App\Middleware;

use App as Apps;
use App\Domain\Entity\Base\App;
use App\Exceptions\AuthBusinessException;
use App\Exceptions\AuthErrorCode;
use App\Exceptions\LockException;
use App\Exceptions\UnauthorizedHttpException;
use App\Infra\Helper\CreateSignature;
use App\Infra\Lock;
use App\Infra\Proxy\Permission;
use App\Infra\Repository\Base\App as BaseApp;
use Leevel\Auth\AuthException;
use Leevel\Auth\Manager;
use Leevel\Auth\Middleware\Auth as BaseAuth;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Repository;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Event\Proxy\Event;
use Leevel\Http\Request;
use Leevel\Kernel\IApp;
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
        'user/lock',
        'user/unlock',
        'login/logout',
    ];

    /**
     * 忽略路由.
     */
    private array $ignorePathInfo = [
        'login/logout',
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
     * @throws \App\Exceptions\UnauthorizedHttpException|\Exception
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

            // 注入公司 ID
            $this->setCompanyId();

            return parent::handle($next, $request);
        } catch (AuthException) {
            throw new UnauthorizedHttpException(AuthErrorCode::PERMISSION_AUTHENTICATION_FAILED);
        }
    }

    /**
     * 注入公司 ID.
     */
    private function setCompanyId(): void
    {
        // 先写死公司，后续可以替换
        $companyId = 999;

        // 注册到容器中，其它地方可以调用
        Apps::container()->instance('company_id', $companyId);

        // 拥有 company_id 字段的实体会做一些处理
        Entity::event(Entity::BOOT_EVENT, function (string $event, string $entityClass) use ($companyId): void {
            if (!$entityClass::hasField('company_id')) {
                return;
            }

            // 自动添加全局 company_id 查询过滤
            $entityClass::addGlobalScope('company_id', function (Select $select) use ($companyId): void {
                $select->where('company_id', $companyId);
            });

            // 新增数据时自动添加 company_id
            $entityClass::event(Entity::BEFORE_CREATE_EVENT, function (string $event, Entity $entity) use ($companyId): void {
                $entity->companyId = $companyId;
            });
        });

        // 批量插入数据自动添加 company_id
        Event::register(Repository::INSERT_ALL_EVENT, function (object|string $event, Repository $repository): void {
            if (!$repository->entity()->hasField('company_id')) {
                return;
            }

            $repository->insertAllBoot(function (&$data): void {
                inject_company($data);
            });
        });
    }

    /**
     * 校验格式化.
     *
     * @throws \App\Exceptions\AuthBusinessException|\Exception
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
     * @throws \App\Exceptions\AuthBusinessException|\Exception
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
     *
     * @throws \Exception
     */
    private function findAppSecret(string $appKey): string
    {
        return $this
            ->appRepository()
            ->findAppSecretByKey($appKey)
        ;
    }

    private function appRepository(): BaseApp
    {
        return UnitOfWork::make()->repository(App::class);
    }

    /**
     * 校验是否过期.
     *
     * @throws \App\Exceptions\AuthBusinessException|\Exception
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
     * @throws \App\Exceptions\AuthBusinessException|\Exception
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
            // @phpstan-ignore-next-line
            return $token;
        }

        if ($token = $request->request->get('token', '')) {
            // @phpstan-ignore-next-line
            return $token;
        }

        // @phpstan-ignore-next-line
        return $request->query->get('token', '');
    }

    /**
     * 验证是否锁定.
     *
     * @throws \App\Exceptions\LockException|\Exception
     */
    private function validateLock(Request $request, string $token): void
    {
        if (!\in_array($this->getPathInfo($request), $this->ignoreLockPathInfo, true)
            && $token && (new Lock())->has($token)) {
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
     * @throws \App\Exceptions\AuthBusinessException|\Exception
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
        // @phpstan-ignore-next-line
        return preg_replace('/^api\/v([0-9])+:/', '', trim($request->getPathInfo(), '/'));
    }
}
