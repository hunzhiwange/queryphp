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
 * @date 2017.04.13
 * @since 4.0
 */
namespace Q\factory;

use ArrayAccess;

/**
 * 服务容器
 *
 * @author Xiangmin Liu
 */
abstract class container implements ArrayAccess {
    
    /**
     * 注册工厂
     *
     * @var array
     */
    protected $arrFactorys = [ ];
    
    /**
     * 注册的实例
     *
     * @var object
     */
    protected $arrInstances = [ ];
    
    /**
     * 注册工厂
     *
     * @param string $strFactoryName            
     * @param mixed $mixFactory            
     * @return void
     */
    public function register($strFactoryName, $mixFactory) {
        // 回调
        if (\Q::varType ( $mixFactory, 'callback' )) {
            $this->arrFactorys [$strFactoryName] = $mixFactory;
        }        

        // 实例化
        elseif (is_object ( $mixFactory )) {
            $this->arrInstances [$strFactoryName] = $mixFactory;
        }         

        // 创建一个默认存储的值
        else {
            $mixFactory = function () use($mixFactory) {
                return $mixFactory;
            };
            $this->arrFactorys [$strFactoryName] = $mixFactory;
        }
    }
    
    /**
     * 强制注册为实例，存放数据
     *
     * @param string $strFactoryName
     * @param mixed $mixFactory
     * @return void
     */
    public function instance($strFactoryName, $mixFactory) {
          $this->arrInstances [$strFactoryName] = $mixFactory;
    }
    
    /**
     * 生产产品
     *
     * @param string $strFactoryName            
     * @return object
     */
    public function make($strFactoryName /* args */) {
        // 存在直接返回
        if (isset ( $this->arrInstances [$strFactoryName] )) {
            return $this->arrInstances [$strFactoryName];
        }
        
        // 生产服务
        if (! isset ( $this->arrFactorys [$strFactoryName] )) {
            \Q::throwException ( \Q::i18n ( '生产的工厂 %s 不存在', $strFactoryName ) );
        }
        $arrArgs = func_get_args ();
        array_shift ( $arrArgs );
        array_unshift ( $arrArgs, $this );
        return call_user_func_array ( $this->arrFactorys [$strFactoryName], $arrArgs );
    }
    
    /**
     * 判断工厂是否存在
     *
     * @param string $strFactoryName            
     * @return bool
     */
    public function offsetExists($strFactoryName) {
        return isset ( $this->arrFactorys [$this->normalize_($strFactoryName)] );
    }
    
    /**
     * 获取一个工厂产品
     *
     * @param string $strFactoryName            
     * @return mixed
     */
    public function offsetGet($strFactoryName) {
        return $this->make ( $strFactoryName );
    }
    
    /**
     * 注册一个工厂
     *
     * @param string $strFactoryName            
     * @param mixed $mixFactory            
     * @return void
     */
    public function offsetSet($strFactoryName, $mixFactory) {
        $this->register ( $strFactoryName, $mixFactory );
    }
    
    /**
     * 删除一个注册的工厂
     *
     * @param string $strFactoryName            
     * @return void
     */
    public function offsetUnset($strFactoryName) {
        $strFactoryName = $this->normalize_($strFactoryName);
        if (isset ( $this->arrFactorys [$strFactoryName] ))
            unset ( $this->arrFactorys [$strFactoryName] );
        if (isset ( $this->arrInstances [$strFactoryName] ))
            unset ( $this->arrInstances [$strFactoryName] );
    }
    
    /**
     * 捕捉支持属性参数
     *
     * @param string $sName
     *            支持的项
     * @return 设置项
     */
    public function __get($sName) {
        return $this [$sName];
    }
    
    /**
     * 设置支持属性参数
     *
     * @param string $sName
     *            支持的项
     * @param mixed $mixVal
     *            支持的值
     * @return void
     */
    public function __set($sName, $mixVal) {
        $this [$sName] = $mixVal;
    }
    
    /**
     * 统一去掉前面的斜杠
     *
     * @param  string  $strFactoryName
     * @return mixed
     */
    protected function normalize_($strFactoryName){
        return ltrim($strFactoryName, '\\');
    }
    
}
