<?php

declare(strict_types=1);

namespace App\Infra\Console;

use Leevel\Console\Command;
use Leevel\Support\Str;

/**
 * 生成应用秘钥.
 */
class MakeAppSecret extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'make:app:secret';

    /**
     * 命令行描述.
     */
    protected string $description = 'Create app secret.';

    /**
     * 响应命令.
     */
    public function handle(): int
    {
        $this->info('APP_KEY');
        $this->info(Str::randNum(6));

        $this->info('APP_SECRET');
        $this->info($appSecret = Str::randAlphaNum(10));

        return self::SUCCESS;
    }
}
