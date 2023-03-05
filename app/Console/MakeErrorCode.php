<?php

declare(strict_types=1);

namespace App\Console;

use Leevel\Console\Command;

/**
 * 生成错误码.
 */
class MakeErrorCode extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'make:errorcode';

    /**
     * 命令行描述.
     */
    protected string $description = 'Create error code.';

    /**
     * 命令帮助.
     */
    protected string $help = <<<'EOF'
        The <info>%command.name%</info> command to show how to make a error code:

          <info>php %command.full_name%</info>
        EOF;

    /**
     * 响应命令.
     */
    public function handle(): int
    {
        $time = date('YmdHis');
        $microTime = number_format((float) explode(' ', microtime())[0] * 1000, 0, '.', '');

        $this->info($time.$microTime);

        return 0;
    }
}
