<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\support;

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

use ArrayAccess;
use Q\traits\flow\control as flow_control;
use Q\contract\support\container as contract_container;
use Q\exception\exceptions;

/**
 * 工厂容器
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.13
 * @version 4.0
 */
class container implements ArrayAccess, contract_container {
    
    use flow_control;
    
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
        if ($this->flowControlCall_ ( $sMethod, $arrArgs ) !== false) {
            return $this;
        }
        
        exceptions::throws ( \Q::i18n ( 'container 没有实现魔法方法 %s.', $sMethod ), 'Q\support\exception' );
    }
    
    /**
     * 注册工厂
     *
     * @param mixed $mixFactoryName            
     * @param mixed $mixFactory            
     * @return void
     */
    public function register($mixFactoryName, $mixFactory = null) {
        // 回调
        if (is_callable ( $mixFactory )) {
            $this->arrFactorys [$mixFactoryName] = $mixFactory;
        }         

        // 批量注册
        else if (is_array ( $mixFactoryName )) {
            foreach ( $mixFactoryName as $mixName => $mixValue ) {
                $this->register ( $mixName, $mixValue );
            }
            return $this;
        }        

        // 实例
        elseif (is_object ( $mixFactoryName )) {
            $this->arrInstances [get_class ( $mixFactoryName )] = $mixFactoryName;
        }        

        // 实例化
        elseif (is_object ( $mixFactory )) {
            $this->arrInstances [$mixFactoryName] = $mixFactory;
        }         

        // 创建一个默认存储的值
        else {
            if (is_null ( $mixFactory )) {
                $mixFactory = $mixFactoryName;
            }
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
     * @param string $mixFactoryName            
     * @param mixed $mixFactory            
     * @return void
     */
    public function instance($mixFactoryName, $mixFactory = null) {
        if (! \Q::isThese ( $mixFactoryName, [ 
                'scalar',
                'array' 
        ] )) {
            exceptions::throws ( \Q::i18n ( 'instance 第一个参数只能为 scalar 或者 array' ), 'Q\support\exception' );
        }
        
        if (is_array ( $mixFactoryName )) {
            $this->arrInstances = array_merge ( $this->arrInstances, $mixFactoryName );
        } else {
            if (is_null ( $mixFactory )) {
                $mixFactory = $mixFactoryName;
            }
            $this->arrInstances [$mixFactoryName] = $mixFactory;
        }
        return $this;
    }
    
    /**
     * 注册单一实例
     *
     * @param scalar|array $mixFactoryName            
     * @param mixed $mixFactory            
     * @return void
     */
    public function singleton($mixFactoryName, $mixFactory = null) {
        if (! \Q::isThese ( $mixFactoryName, [ 
                'scalar',
                'array' 
        ] )) {
            exceptions::throws ( \Q::i18n ( 'singleton 第一个参数只能为 scalar 或者 array' ), 'Q\support\exception' );
        }
        
        if (is_array ( $mixFactoryName )) {
            $this->arrSingletons = array_merge ( $this->arrSingletons, array_keys ( $mixFactoryName ) );
        } else {
            $this->arrSingletons [] = $mixFactoryName;
        }
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
     * 生产产品 (动态参数)
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
     * 生产产品 (数组参数)
     *
     * @param string $strFactoryName            
     * @param array $arrArgs            
     * @return object
     */
    public function makeWithArgs($strFactoryName, array $arrArgs = []) {
        if (! is_array ( $arrArgs )) {
            exceptions::throws ( \Q::i18n ( 'makeWithArgs 第二个参数只能为 array' ), 'Q\support\exception' );
        }
        array_unshift ( $arrArgs, $strFactoryName );
        return call_user_func_array ( [ 
                $this,
                'make' 
        ], $arrArgs );
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
        foreach ( [ 
                'Factorys',
                'Instances',
                'Singletons' 
        ] as $strType ) {
            $strType = 'arr' . $strType;
            if (isset ( $this->{$strType} [$strFactoryName] ))
                unset ( $this->{$strType} [$strFactoryName] );
        }
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
