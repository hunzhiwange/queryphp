<?php

declare(strict_types=1);

namespace App\Infra\Provider;

use App\Infra\Permission;
use App\Infra\PermissionCache;
use Godruoyi\Snowflake\RedisSequenceResolver;
use Godruoyi\Snowflake\Snowflake;
use Leevel\Cache\Manager;
use Leevel\Cache\Redis;
use Leevel\Di\IContainer;
use Leevel\Di\Provider;

/**
 * 应用服务提供者.
 */
class App extends Provider
{
    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->permission();
        $this->redisSequence();
        $this->snowflake();
    }

    /**
     * {@inheritDoc}
     */
    public static function providers(): array
    {
        return [
            'permission',
            'redis_sequence',
            'snowflake',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function isDeferred(): bool
    {
        return true;
    }

    /**
     * bootstrap.
     */
    public function bootstrap(): void
    {
    }

    /**
     * 注册 permission 服务.
     */
    private function permission(): void
    {
        $this->container->bind('permission', function (IContainer $container): Permission {
            /** @var \Leevel\Http\Request $request */
            $request = $container->make('request');
            $token = $request->query->get('token', $request->request->get('token', ''));

            // @phpstan-ignore-next-line
            return new Permission($container->make(PermissionCache::class), $token);
        });
    }

    private function redisSequence(): void
    {
        $this->container->singleton('redis_sequence', function (IContainer $container): RedisSequenceResolver {
            $redis = redis_cache();

            return (new RedisSequenceResolver($redis))->setCachePrefix('redis_sequence:');
        });
    }

    private function snowflake(): void
    {
        $this->container->singleton('snowflake', function (IContainer $container): Snowflake {
            $redis = redis_cache();
            $redisSequence = (new RedisSequenceResolver($redis))->setCachePrefix('snowflake_redis_sequence:');

            return (new Snowflake(1, 1))
                // 1678032000000 = 2023-03-06
                ->setStartTimeStamp(1678032000000)
                ->setSequenceResolver($redisSequence)
            ;
        });
    }
}
