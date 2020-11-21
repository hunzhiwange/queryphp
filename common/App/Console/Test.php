<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\App\Console;

use Leevel\Console\Command;

/**
 * 测试命令.
 */
class Test extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'common:test';

    /**
     * 命令行描述.
     */
    protected string $description = 'This is a test command';

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
        $this->info('Hello my test command.');

        return 0;
    }
}
