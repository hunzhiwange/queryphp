<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\console;

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

use Symfony\Component\Console\Application as SymfonyApplication;
use queryyetsimple\option\option;
use queryyetsimple\mvc\project;

/**
 * 命令行应用程序
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.28
 * @version 1.0
 */
class application {
    
    /**
     * symfony application
     *
     * @var object
     */
    private $objSymfonyApplication = null;
    
    /**
     * 创建一个命令行应用程序
     *
     * @return queryyetsimple\console\application
     */
    public function __construct() {
        // 创建应用
        $this->objSymfonyApplication = new SymfonyApplication ( $this->getLogo_ (), Q_VER );
        
        // 注册默认命令行
        $this->registerDefaultCommands_ ()->
        
        // 注册用户自定义命令
        registerUserCommands_ ();
    }
    
    /**
     * 默认方法
     *
     * @return void
     */
    public function run() {
        return $this->objSymfonyApplication->run ();
    }
    
    /**
     * 注册默认命令行
     *
     * @return $this
     */
    private function registerDefaultCommands_() {
        return $this->doRegisterCommands_ ( ( array ) require __DIR__ . '/default.php' );
    }
    
    /**
     * 注册默认命令行
     *
     * @return $this
     */
    private function registerUserCommands_() {
        return $this->doRegisterCommands_ ( ( array ) option::gets ( 'console' ) );
    }
    
    /**
     * 注册用户自定义命令
     *
     * @param array $arrCommands            
     * @return $this
     */
    private function doRegisterCommands_($arrCommands) {
        foreach ( $arrCommands as $strCommand ) {
            $objCommand = $this->getQueryPHP_ ()->make ( $strCommand );
            // 基于 Phinx 数据库迁移组件无法设置 setQueryPHP
            if (method_exists ( $objCommand, 'setQueryPHP' )) {
                $objCommand->setQueryPHP ( $this->getQueryPHP_ () );
            }
            $this->getQueryPHP_ ()->instance ( 'command_' . $objCommand->getName (), $objCommand );
            $this->objSymfonyApplication->add ( $objCommand );
        }
        return $this;
    }
    
    /**
     * 返回 QueryPHP
     *
     * @return \queryyetsimple\mvc\project
     */
    private function getQueryPHP_() {
        return project::bootstrap ();
    }
    
    /**
     * 返回 QueryPHP Logo
     *
     * @return string
     */
    private function getLogo_() {
        return <<<queryphp
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
    }
}
