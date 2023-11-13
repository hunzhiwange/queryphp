<?php

declare(strict_types=1);

namespace App\Infra\Console;

use Leevel\Console\Command;

/**
 * 生成当前时间码.
 */
class MakeTimeCode extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'make:time:code';

    /**
     * 命令行描述.
     */
    protected string $description = 'Create time code.';

    /**
     * 响应命令.
     */
    public function handle(): int
    {
        $this->info(date('YmdHis'));

        return self::SUCCESS;
    }
}
