<?php

declare(strict_types=1);

namespace App\Infra\Console;

use Leevel\Console\Command;

/**
 * 生成雪花算法唯一编码.
 */
class MakeSnowflake extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'make:snowflake';

    /**
     * 命令行描述.
     */
    protected string $description = 'Create snowflake.';

    /**
     * 响应命令.
     */
    public function handle(): int
    {
        $this->info((string) snowflake());

        return self::SUCCESS;
    }
}
