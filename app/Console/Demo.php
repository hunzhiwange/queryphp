<?php

declare(strict_types=1);

namespace App\Console;

use Leevel\Console\Command;

/**
 * 测试命令.
 */
class Demo extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'demo';

    /**
     * 命令行描述.
     */
    protected string $description = 'This is a demo command';

    /**
     * 命令帮助.
     */
    protected string $help = <<<'EOF'
        The <info>%command.name%</info> command to show how to make a command:

          <info>php %command.full_name%</info>
        EOF;

    /**
     * 响应命令.
     */
    public function handle(): int
    {
        $this->info('Hello my demo command.');

        return 0;
    }
}
