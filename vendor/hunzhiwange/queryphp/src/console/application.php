<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\console;

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
use Q\traits\dependency\injection as dependency_injection;
use Q\option\option;
use Q\mvc\project;

/**
 * 命令行应用程序
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.28
 * @version 1.0
 */
class application {
    
    use dependency_injection;
    
    /**
     * symfony application
     *
     * @var object
     */
    private $objSymfonyApplication = null;
    
    /**
     * 默认的命令
     *
     * @var array
     */
    private $arrDefaultCommands = [ 
            'Q\console\command\demo',
            'Q\console\command\make\model',
            'Q\console\command\make\controller',
            'Q\console\command\make\action',
            'Q\console\command\migrate\init',
            'Q\console\command\migrate\create',
            'Q\console\command\migrate\breakpoint',
            'Q\console\command\migrate\migrate',
            'Q\console\command\migrate\rollback',
            'Q\console\command\migrate\seedcreate',
            'Q\console\command\migrate\seedrun',
            'Q\console\command\migrate\status',
            'Q\console\command\migrate\test',
    ];
    
    /**
     * 创建一个命令行应用程序
     *
     * @return Q\console\application
     */
    public function __construct() {
        // 创建应用
        $this->objSymfonyApplication = new SymfonyApplication ( $this->getLogo_ (), Q_VER );
        
        // 注册默认命令行
        $this->registerDefaultCommands_ ()->
        
        // 注册用户自定义命令
        registerUserCommands_ ();
        
       // $this->objSymfonyApplication->add ( new \Phinx\Console\Command\Init() );
      // $this->objSymfonyApplication->add ( new \Phinx\Console\Command\Create() );
        
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
        return $this->doRegisterCommands_ ( $this->arrDefaultCommands );
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
            $objCommand = $this->getObjectByClassAndArgs_ ( $strCommand, [ ] );
            // 基于 Phinx 数据库迁移组件无法设置 setQueryPHP
            if(method_exists($objCommand, 'setQueryPHP')){
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
     * @return \Q\mvc\project
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
