<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\event;

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

use queryyetsimple\mvc\project;

/**
 * 事件
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.17
 * @version 4.0
 */
class event {
    
    /**
     * 项目容器
     *
     * @var \queryyetsimple\mvc\project
     */
    protected $objProject;
    
    /**
     * 注册的监听器
     *
     * @var array
     */
    protected $arrListener = [ ];
    
    /**
     * 排好序的监听器
     *
     * @var array
     */
    protected $arrSorted = [ ];
    
    /**
     * 创建一个事件解析器
     *
     * @param \queryyetsimple\mvc\project $objProject            
     * @return void
     */
    public function __construct($objProject) {
        $this->objProject = $objProject;
    }
    
    /**
     * 执行一个事件
     *
     * @param string|object $mixEvent            
     * @return array|null
     */
    public function run($mixEvent /* args */ ){
        if (is_object ( $mixEvent )) {
            $objEvent = $mixEvent;
            $mixEvent = get_class ( $mixEvent );
        } else {
            $objEvent = $this->objProject->make ( $mixEvent );
        }
        
        $arrArgs = func_get_args ();
        array_shift ( $arrArgs );
        array_unshift ( $arrArgs, $objEvent );
        
        foreach ( $this->getListener ( $mixEvent ) as $calListener ) {
            // 有返回值则中断下一个监听器
            if (! is_null ( $mixResult = call_user_func_array ( $calListener, $arrArgs ) )) {
                return $mixResult;
            }
        }
    }
    
    /**
     * 注册监听器
     *
     * @param string|array $mixEvent            
     * @param mixed $mixListener            
     * @param int $priority            
     * @return void
     */
    public function registerListener($mixEvent, $mixListener, $intPriority = 0) {
        foreach ( ( array ) $mixEvent as $strEvent ) {
            $this->arrListener [$strEvent] [$intPriority] [] = $this->makeListener ( $mixListener );
            if (isset ( $this->arrSorted [$strEvent] )) {
                unset ( $this->arrSorted [$strEvent] );
            }
        }
    }
    
    /**
     * 获取一个监听器
     *
     * @param string $strEvent            
     * @return array
     */
    public function getListener($strEvent) {
        if (! isset ( $this->arrSorted [$strEvent] )) {
            $this->sortListener_ ( $strEvent );
        }
        
        return $this->arrSorted [$strEvent];
    }
    
    /**
     * 判断监听器是否存在
     *
     * @param string $strEvent            
     * @return bool
     */
    public function hasListener($strEvent) {
        return isset ( $this->arrListener [$strEvent] );
    }
    
    /**
     * 创建监听器
     *
     * @param mixed $mixListener            
     * @return mixed
     */
    public function makeListener($mixListener) {
        if (is_string ( $mixListener )) {
            $mixListener = function () use($mixListener) {
                $arrArgs = func_get_args ();
                $mixListener = explode ( '@', $mixListener );
                
                // 注入构造器
                $mixListener [0] = $this->objProject->makeWithArgs ( $mixListener [0], $arrArgs );
                
                // 注入方法
                $mixListener [1] = ! empty ( $mixListener [1] ) ? $mixListener [1] : 'run';
                return $this->objProject->call ( $mixListener, $arrArgs );
            };
        }
        return $mixListener;
    }
    
    /**
     * 删除一个监听器
     *
     * @param string $strEvent            
     * @return void
     */
    public function deleteListener($strEvent) {
        foreach ( [ 
                'Listener',
                'Sorted' 
        ] as $sType ) {
            $sType = 'arr' . $sType;
            if (isset ( $this->{$sType} [$strEvent] )) {
                unset ( $this->{$sType} [$strEvent] );
            }
        }
    }
    
    /**
     * 注册一个事件的订阅
     *
     * @param object|string $mixSubscriber            
     * @return void
     */
    public function registerSubscribe($mixSubscriber) {
        // 注入构造器
        if (is_string ( $mixSubscriber )) {
            $mixSubscriber = $this->getObjectByClassAndArgs_ ( $mixSubscriber, [ 
                    $this->objProject 
            ] );
        }
        $mixSubscriber->subscribe ( $this );
    }
    
    /**
     * 排序监听器
     *
     * @param string $strEvent            
     * @return array
     */
    protected function sortListener_($strEvent) {
        $this->arrSorted [$strEvent] = [ ];
        if (isset ( $this->arrListener [$strEvent] )) {
            krsort ( $this->arrListener [$strEvent] );
            $this->arrSorted [$strEvent] = call_user_func_array ( 'array_merge', $this->arrListener [$strEvent] );
        }
    }
}
