<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.19
 * @since 1.0
 */
namespace Q\base;

use Q;

/**
 * 基类控制器
 *
 * @author Xiangmin Liu
 */
abstract class action {
    
    /**
     * 父控制器
     *
     * @var Q\base\controller
     */
    protected $objController = null;
    
    /**
     * 构造函数
     *
     * @param Q\base\app $oApp            
     * @param 过滤后参数 $in            
     */
    public function __construct($oApp = null, $in = []) {
        ! $oApp && $oApp = Q::app ();
        if (! ($this->objController = $oApp->getController ( $oApp->controller_name ))) {
            $this->objController = new controller ( $oApp, $in );
        }
    }
    
    /**
     * 赋值
     *
     * @param mixed $mixName            
     * @param mixed $Value            
     */
    public function __set($mixName, $mixValue) {
        $this->objController->assign ( $mixName, $mixValue );
    }
    
    /**
     * 获取值
     *
     * @param string $sName            
     * @return mixed
     */
    public function &__get($sName) {
        $mixValue = $this->objController->getAssign ( $sName );
        return $mixValue;
    }
    
    /**
     * 返回父控制器
     *
     * @return Q\base\controller
     */
    public function controller() {
        return $this->objController;
    }
    
    /**
     * 方法执行抽象函数
     *
     * @param object $that
     *            Q\base\action
     * @param array $in            
     * @return void
     */
    abstract public function run($that = null, $in = []);
    
    /**
     * 实现 isPost,isGet等
     *
     * @param string $sMethod            
     * @param array $arrArgs            
     * @return boolean
     */
    public function __call($sMethod, $arrArgs) {
        return call_user_func_array ( [ 
                $this->objController,
                $sMethod 
        ], $arrArgs );
    }
}
