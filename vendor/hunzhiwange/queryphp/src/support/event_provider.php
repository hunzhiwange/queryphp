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
 * @date 2017.04.26
 * @since 4.0
 */
namespace Q\support;

use Q\event\event;

/**
 * 事件服务提供者
 *
 * @author Xiangmin Liu
 */
class event_provider extends provider {
    
    /**
     * 监听器列表
     *
     * @var array
     */
    protected $arrListener = [ ];
    
    /**
     * 注册的订阅
     *
     * @var array
     */
    protected $arrSubscribe = [ ];
    
    /**
     * 注册时间监听器
     *
     * @param \Q\event\event $objEvent            
     * @return void
     */
    public function bootstrap(event $objEvent) {
        foreach ( $this->getListener () as $strEvent => $arrListeners ) {
            foreach ( $arrListeners as $strListener ) {
                $objEvent->registerListener ( $strEvent, $strListener );
            }
        }
        
        foreach ( $this->getSubscribe () as $strSubscribe ) {
            $objEvent->registerSubscribe ( $strSubscribe );
        }
    }
    
    /**
     * 注册一个提供者
     *
     * @return void
     */
    public function register() {
    }
    
    /**
     * 取得监听器
     *
     * @return array
     */
    public function getListener() {
        return $this->arrListener;
    }
    
    /**
     * 取得订阅
     *
     * @return array
     */
    public function getSubscribe() {
        return $this->arrSubscribe;
    }
}
