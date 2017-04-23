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
namespace Q\mvc;

use Q\factory\factory;

/**
 * 注册基础工厂
 *
 * @author Xiangmin Liu
 */
class base_factory extends factory {
    
    /**
     * 单一实例
     *
     * @var array
     */
    private $arrSingleton = [
            // i18n
            'Q\i18n\i18n',
            'Q\i18n\tool',
            
            // option
            'Q\option\option',
            
            // request
            'Q\request\request',
            'Q\request\response',
            
            // cookie
            'Q\cookie\cookie',
            
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
            // structure
            'Q\structure\collection',
            'Q\structure\queue',
            'Q\structure\stack' 
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
                return new $strCore ();
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
                return new $strOther ( func_get_args () );
            } );
        }
    }
}
