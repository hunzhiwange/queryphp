<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\console\command;

<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

use queryyetsimple\console\command;

/**
 * 测试命令
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.28
 * @version 1.0
 */
class demo extends command {
    
    /**
     * 命令名字
     *
     * @var string
     */
    protected $strName = 'demo';
    
    /**
     * 命令描述
     *
     * @var string
     */
    protected $strDescription = 'Only test for a command';
    
    /**
     * 命令帮助
     *
     * @var string
     */
    protected $strHelp = <<<EOF
The <info>%command.name%</info> only for test.
EOF;
    
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
    protected function getArguments() {
        return [ ];
    }
    
    /**
     * 命令配置
     *
     * @return array
     */
    protected function getOptions() {
        return [ ];
    }
    
    /**
     * 响应命令
     *
     * @return void
     */
    public function handle() {
        $this->info ( 'Demo is ok' );
    }
}  