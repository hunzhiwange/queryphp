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
use Q\traits\flow_condition;

/**
 * 工厂容器
 *
 * @author Xiangmin Liu
 */
abstract class container implements ArrayAccess {
    
    use flow_condition;
    
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
     * 单一实例
     *
     * @var array
     */
    protected $arrSingletons = [ ];
    
    /**
     * 别名支持
     *
     * @var array
     */
    protected $arrAlias = [ ];
    
    /**
     * 分组
     *
     * @var array
     */
    protected $arrGroups = [ ];
    
    /**
     * 拦截一些别名和快捷方式
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return boolean
     */
    public function __call($sMethod, $arrArgs) {
        // 条件控制语句支持
        if ($this->flowConditionCall_ ( $sMethod, $arrArgs ) !== false) {
            return $this;
        }
        
        \Q::throwException ( \Q::i18n ( 'container 没有实现魔法方法 %s.', $sMethod ), 'Q\factory\exception' );
    }
    
    /**
     * 注册工厂
     *
     * @param mixed $mixFactoryName            
     * @param mixed $mixFactory            
     * @return void
     */
    public function register($mixFactoryName, $mixFactory = null) {
        // 实例
        if (is_object ( $mixFactoryName )) {
            $this->arrInstances [get_class ( $mixFactoryName )] = $mixFactoryName;
        }        

        // 回调
        elseif (\Q::varType ( $mixFactory, 'callback' )) {
            $this->arrFactorys [$mixFactoryName] = $mixFactory;
        }        

        // 实例化
        elseif (is_object ( $mixFactory )) {
            $this->arrInstances [$mixFactoryName] = $mixFactory;
        }         

        // 创建一个默认存储的值
        else {
            $mixFactory = function () use($mixFactory) {
                return $mixFactory;
            };
            $this->arrFactorys [$mixFactoryName] = $mixFactory;
        }
        return $this;
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
        return $this;
    }
    
    /**
     * 注册单一实例
     *
     * @param string $strFactoryName            
     * @param mixed $mixFactory            
     * @return void
     */
    public function singleton($mixFactoryName, $mixFactory = null) {
        $this->arrSingletons [] = $mixFactoryName;
        return $this->register ( $mixFactoryName, $mixFactory );
    }
    
    /**
     * 设置别名
     *
     * @param array|string $mixAlias            
     * @param string $strValue            
     * @return void
     */
    public function alias($mixAlias, $strValue = null) {
        if (is_array ( $mixAlias )) {
            $this->arrAlias = array_merge ( $this->arrAlias, $mixAlias );
        } else {
            $this->arrAlias [$mixAlias] = $strValue;
        }
        return $this;
    }
    
    /**
     * 分组注册
     *
     * @param string $strGroupName            
     * @param mixed $mixGroupData            
     * @return void
     */
    public function group($strGroupName, $mixGroupData) {
        if (! isset ( $this->arrGroups [$strGroupName] )) {
            $this->arrGroups [$strGroupName] = [ ];
        }
        $this->arrGroups [$strGroupName] = $mixGroupData;
        return $this;
    }
    
    /**
     * 分组制造
     *
     * @param string $strGroupName            
     * @return array
     */
    public function groupMake($strGroupName) {
        if (! isset ( $this->arrGroups [$strGroupName] )) {
            return [ ];
        }
        
        $arrResult = [ ];
        $arrArgs = func_get_args ();
        array_shift ( $arrArgs );
        foreach ( $this->arrGroups [$strGroupName] as $strGroupInstance ) {
            $arrResult [$strGroupInstance] = call_user_func_array ( [ 
                    $this,
                    'make' 
            ], $arrArgs );
        }
        return $arrResult;
    }
    
    /**
     * 生产产品
     *
     * @param string $strFactoryName            
     * @return object
     */
    public function make($strFactoryName /* args */) {
        // 别名
        if (isset ( $this->arrAlias [$strFactoryName] )) {
            $strFactoryName = $this->arrAlias [$strFactoryName];
        }
        
        // 存在直接返回
        if (isset ( $this->arrInstances [$strFactoryName] )) {
            return $this->arrInstances [$strFactoryName];
        }
        
        // 生成实例
        if (! isset ( $this->arrFactorys [$strFactoryName] )) {
            return false;
        }
        $arrArgs = func_get_args ();
        array_shift ( $arrArgs );
        array_unshift ( $arrArgs, $this );
        $mixInstances = call_user_func_array ( $this->arrFactorys [$strFactoryName], $arrArgs );
        
        // 单一实例
        if (in_array ( $strFactoryName, $this->arrSingletons )) {
            return $this->arrInstances [$strFactoryName] = $mixInstances;
        }         

        // 多个实例
        else {
            return $mixInstances;
        }
    }
    
    /**
     * 判断工厂是否存在
     *
     * @param string $strFactoryName            
     * @return bool
     */
    public function offsetExists($strFactoryName) {
        return isset ( $this->arrFactorys [$this->normalize_ ( $strFactoryName )] );
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
        return $this->register ( $strFactoryName, $mixFactory );
    }
    
    /**
     * 删除一个注册的工厂
     *
     * @param string $strFactoryName            
     * @return void
     */
    public function offsetUnset($strFactoryName) {
        $strFactoryName = $this->normalize_ ( $strFactoryName );
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
        return $this;
    }
    
    /**
     * 统一去掉前面的斜杠
     *
     * @param string $strFactoryName            
     * @return mixed
     */
    protected function normalize_($strFactoryName) {
        return ltrim ( $strFactoryName, '\\' );
    }
}
