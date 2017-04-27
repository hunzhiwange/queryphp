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
 * @date 2017.04.23
 * @since 1.0
 */
namespace Q\support;

/**
 * 注册基础服务提供者
 *
 * @author Xiangmin Liu
 */
class base_provider extends provider {
    
    /**
     * 单一实例
     *
     * @var array
     */
    private $arrSingleton = [
            // cache
            'Q\cache\filecache',
            'Q\cache\memcache',
            
            // cookie
            'Q\cookie\cookie',
            
            // database
            'Q\database\database',
            
            // event
            'Q\event\event',
            
            // i18n
            'Q\i18n\i18n',
            'Q\i18n\tool',
            
            // image
            'Q\image\image',
            
            // log
            'Q\log\log',
            
            // option
            'Q\option\option',
            
            // request
            'Q\request\request',
            'Q\request\response',
            
            // router
            'Q\router\router',
            
            // view
            'Q\view\compilers',
            'Q\view\parsers',
            'Q\view\theme',
            
            // xml
            'Q\xml\xml' 
    ];
    
    /**
     * 其它类型
     *
     * @var array
     */
    private $arrOther = [
            // collection
            'Q\collection\collection',
            
            // queue
            'Q\queue\queue',
            'Q\queue\stack' 
    ];
    
    /**
     * 注册基础工厂数据
     *
     * @return void
     */
    public function register() {
        // 注册 singleton
        $this->registerSingleton_ ();
        
        // 注册 other
        $this->registerOther_ ();
    }
    
    /**
     * 注册单一实例
     *
     * @return void
     */
    private function registerSingleton_() {
        foreach ( $this->arrSingleton as $strCore ) {
            $this->objProject->singleton ( $strCore, function () use($strCore) {
                return \Q::newInstanceArgs ( $strCore, func_get_args () );
            } );
        }
    }
    
    /**
     * 注册非单一实例
     *
     * @return void
     */
    private function registerOther_() {
        foreach ( $this->arrOther as $strOther ) {
            $this->objProject->register ( $strOther, function () use($strOther) {
                return \Q::newInstanceArgs ( $strOther, func_get_args () );
            } );
        }
    }
}
