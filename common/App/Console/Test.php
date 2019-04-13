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
 *
 * @author Xiangmin Liu<635750556@qq.com>
 *
 * @since 2017.04.28
 *
 * @version 1.0
 */
class Test extends Command
{
    /**
     * 命令名字.
     *
     * @var string
     */
    protected $name = 'common:test';

    /**
     * 命令行描述.
     *
     * @var string
     */
    protected $description = 'This is a test command';

    /**
     * 命令帮助.
     *
     * @var string
     */
    protected $help = <<<'EOF'
        The <info>%command.name%</info> command to show how to make a command:
        
          <info>php %command.full_name%</info>
        EOF;

    /**
     * 响应命令.
     */
    public function handle(): void
    {
        $this->info('Hello my test command.');
    }

    /**
     * 命令参数.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [];
    }

    /**
     * 命令配置.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [];
    }
}
