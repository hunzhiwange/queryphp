<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace common\console;

use Q\console\command;

/**
 * 测试命令
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.28
 * @version 1.0
 */
class controller extends command
{

    /**
     * 命令名字
     *
     * @var string
     */
    protected $strName = 'controller';

    /**
     * 命令行描述
     *
     * @var string
     */
    protected $strDescription = 'Only2222 test for a command';

    /**
     * 注册命令
     *
     * @var string
     */
    protected $strSignature = '';

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

    /**
     * 响应命令
     *
     * @return void
     */
    public function handle()
    {
    }
}
