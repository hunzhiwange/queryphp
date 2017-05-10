<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\testing;

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

use Q\mvc\project;
use Q\psr4\psr4;
use Q\option\option;

/**
 * phpunit 应用程序
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.08
 * @version 1.0
 */
class application {
    
    /**
     * 创建一个 phpunit 应用程序
     *
     * @return Q\testing\application
     */
    public function __construct() {
        // 注册所有应用命名空间
        $this->registerAppNamespace_ ();
    }
    
    /**
     * 默认方法
     *
     * @return void
     */
    public function run() {
    }
    
    /**
     * 注册所有应用命名空间
     *
     * @return $this
     */
    private function registerAppNamespace_() {
        foreach ( option::gets ( '~apps~' ) as $strApp ) {
            psr4::import ( $strApp, $this->getQueryPHP_ ()->path_application . '/' . $strApp, [ 
                    'ignore' => [ 
                            'interfaces' 
                    ],
                    'force' => Q_DEVELOPMENT !== 'development' ? false : true 
            ] );
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
}
