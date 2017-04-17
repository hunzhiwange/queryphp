<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * ##########################################################
 * #   ____                          ______  _   _ ______   #
 * #  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
 * # |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
 * #  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
 * #       \__   | \___ |_|    \__  || |    | | | || |      #
 * #     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
 * #                          |___ /  Since 2010.10.03      #
 * ##########################################################
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.04.17
 * @since 4.0
 */
namespace Q\event;

use Exception;
use Q\factory\factory;
use Q\factory\reuse;

/**
 * 事件工厂
 *
 * @author Xiangmin Liu
 */
abstract class event extends factory {
    
    use reuse;
    
    /**
     * 事件监听器
     *
     * @var array
     */
    protected $arrListener = [ ];
    
    /**
     * 抛出异常是否继续传递事件
     *
     * @var bool
     */
    protected $booContinue = false;
    
    /**
     * 执行结果
     *
     * @var array
     */
    protected $arrResult = [ ];
    
    /**
     * 创建一个对象
     *
     * @return void
     */
    public function __construct() {
        $this->arrArgs = func_get_args ();
    }
    
    /**
     * 注册一个监听器
     *
     * @return void
     */
    public function listener(listener $objListener) {
        if (! method_exists ( $objListener, 'run' )) {
            \Q::throwException ( \Q::i18n ( '监视器 %s 必须包含 run 响应方法', get_class ( $objListener ) ) );
        }
        $this->arrListener [get_class ( $objListener )] = $objListener;
        return $this;
    }
    
    /**
     * 执行事件
     *
     * @return array
     */
    public function run() {
        if (! $this->getListener ()) {
            return;
        }
        
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, $this );
        
        foreach ( $this->getListener () as $strListenerName => $objListener ) {
            if ($objListener instanceof listener) {
                try {
                    $objListener->run ( $this );
                    $this->arrResult [$strListenerName] = call_user_func_array ( [ 
                            $objListener,
                            'run' 
                    ], $arrArgs );
                } catch ( Exception $oE ) {
                    if ($this->booContinue !== true) {
                        \Q::throwException ( $oE->getMessage () );
                        break;
                    }
                }
            }
        }
        
        return $this->arrResult;
    }
    
    /**
     * 抛出异常是否继续传递事件
     *
     * @param boolean $booContinue            
     * @return void
     */
    public function setContinue($booContinue = true) {
        $this->booContinue = $booContinue;
    }
    
    /**
     * 返回事件执行结果
     *
     * @param string|null $strListenerName            
     * @return array|mixed
     */
    public function getResult($strListenerName = null) {
        if (is_null ( $strListenerName )) {
            return $this->arrResult;
        } else {
            return isset ( $this->arrResult [$strListenerName] ) ? $this->arrResult [$strListenerName] : null;
        }
    }
    
    /**
     * 返回监视器
     *
     * @param string|null $strListenerName            
     * @return array|object
     */
    public function getListener($strListenerName = null) {
        if (is_null ( $strListenerName )) {
            return $this->arrListener;
        } else {
            return isset ( $this->arrListener [$strListenerName] ) ? $this->arrListener [$strListenerName] : null;
        }
    }
}
