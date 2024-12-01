<?php

declare(strict_types=1);

namespace App\Infra\Provider;

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
    }

    /**
     * {@inheritDoc}
     */
    public static function providers(): array
    {
        return [
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
}
