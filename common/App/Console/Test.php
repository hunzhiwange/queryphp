<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace Common\App\Console;

use Leevel\Console\{
    Option,
    Command,
    Argument
};

/**
 * 测试命令
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.28
 * @version 1.0
 */
class Test extends Command
{
    /**
     * 命令名字
     *
     * @var string
     */
    protected $strName = 'common:test';

    /**
     * 命令行描述
     *
     * @var string
     */
    protected $strDescription = 'This is a test command';

    /**
     * 命令帮助
     *
     * @var string
     */
    protected $strHelp = <<<EOF
The <info>%command.name%</info> command to show how to make a command:

  <info>php %command.full_name%</info>
EOF;

    /**
     * 响应命令
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Hello my test command.');
    }

    /**
     * 命令参数
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * 命令配置
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
