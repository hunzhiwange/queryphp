<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\mvc;

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

use queryyetsimple\exception\exceptions;

/**
 * 基类方法器
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
abstract class action {
    
    /**
     * 父控制器
     *
     * @var queryyetsimple\mvc\controller
     */
    protected $objController = null;
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct() {
    }
    
    /**
     * 返回父控制器
     *
     * @return queryyetsimple\mvc\controller
     */
    public function controller() {
        $this->initController_ ();
        return $this->objController;
    }
    
    /**
     * 返回项目容器
     *
     * @return \queryyetsimple\mvc\project
     */
    public function project() {
        return project::bootstrap ();
    }
    
    /**
     * 实现 isPost,isGet等
     *
     * @param string $sMethod            
     * @param array $arrArgs            
     * @return boolean
     */
    public function __call($sMethod, $arrArgs) {
        if ($sMethod == 'run') {
            exceptions::throwException ( __ ( '方法对象不允许通过 __call 方法执行  run 入口' ), 'queryyetsimple\mvc\exception' );
        }
        
        $this->initController_ ();
        return call_user_func_array ( [ 
                $this->objController,
                $sMethod 
        ], $arrArgs );
    }
    
    /**
     * 初始化控制器
     *
     * @return void
     */
    protected function initController_() {
        if (is_null ( $this->objController )) {
            return;
        }
        
        if (! ($this->objController = $this->project ()->make ( 'app' )->getController ( $this->project ()->controller_name ))) {
            $this->objController = $this->project ()->make ( 'app' )->controllerDefault ();
        }
    }
}
