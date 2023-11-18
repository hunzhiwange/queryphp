<?php

declare(strict_types=1);

namespace App\Infra\Console;

use Leevel\Console\Command;

/**
 * 生成错误码.
 */
class MakeErrorCode extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'make:error:code';

    /**
     * 命令行描述.
     */
    protected string $description = 'Create error code.';

    /**
     * 响应命令.
     */
    public function handle(): int
    {
        $this->info(get_date_rand());

        return self::SUCCESS;
    }
}
