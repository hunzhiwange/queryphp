<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\traits;

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

/**
 * 自动注入复用
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.25
 * @version 4.0
 */
trait auto_injection {
    
    /**
     * 注入参数分析
     *
     * @param array $arrArgs            
     * @param array $arrExtends            
     * @return array
     */
    protected function getAutoInjectionArgs_(array $arrArgs, array $arrExtends = []) {
        foreach ( $arrExtends as $mixExtend ) {
            $arrArgs [] = $mixExtend;
        }
        return $arrArgs;
    }
    
    /**
     * 根据 class 名字创建实例
     *
     * @param string $strClassName            
     * @param array $arrArgs            
     * @return object
     */
    protected function getObjectByClassAndArgs_($strClassName, $arrArgs = []) {
        // 注入构造器
        if (($arrAutoInjection = $this->parseAutoInjection_ ( $strClassName )) && ! empty ( $arrAutoInjection ['constructor'] )) {
            return \Q::newInstanceArgs ( $strClassName, $this->getAutoInjectionArgs_ ( $arrAutoInjection ['constructor'], $arrArgs ) );
        } else {
            return \Q::newInstanceArgs ( $strClassName, $arrArgs );
        }
    }
    
    /**
     * 实例回调自动注入并返回结果
     *
     * @param callable $calClass            
     * @param string $arrArgs            
     * @return mixed
     */
    protected function getObjectCallbackResultWithMethodArgs_($calClass, $arrArgs = []) {
        if (($arrAutoInjection = $this->parseAutoInjection_ ( $calClass )) && ! empty ( $arrAutoInjection ['method'] )) {
            $arrArgs = $this->getAutoInjectionArgs_ ( $arrAutoInjection ['method'], $arrArgs );
            unset ( $arrAutoInjection );
        }
        return call_user_func_array ( $calClass, $arrArgs );
    }
    
    /**
     * 分析自动注入
     *
     * @param mixed $mixClassOrCallback            
     * @return array
     */
    protected function parseAutoInjection_($mixClassOrCallback) {
        $arrResult = [ ];
        
        $arrFunctions = [ 
                'constructor' => [ ],
                'method' => [ ] 
        ];
        
        $booFindClass = [ 
                'constructor' => false,
                'method' => false 
        ];
        
        if ($mixClassOrCallback instanceof \Closure) {
            $objReflection = new \ReflectionFunction ( $mixClassOrCallback );
            if (($arrParameters = $objReflection->getParameters ())) {
                $arrFunctions ['method'] = $arrParameters;
            }
        } elseif (is_callable ( $mixClassOrCallback )) {
            $objReflection = new \ReflectionMethod ( $mixClassOrCallback [0], $mixClassOrCallback [1] );
            if (($arrParameters = $objReflection->getParameters ())) {
                $arrFunctions ['method'] = $arrParameters;
            }
        } elseif (is_string ( $mixClassOrCallback )) {
            $objReflection = new \ReflectionClass ( $mixClassOrCallback );
            if (($objConstructor = $objReflection->getConstructor ()) && ($arrParameters = $objConstructor->getParameters ())) {
                $arrFunctions ['constructor'] = $arrParameters;
            }
        }
        
        foreach ( $arrFunctions as $sType => $arrFunction ) {
            foreach ( $arrFunction as $intIndex => $objFunction ) {
                if ($objFunction instanceof \ReflectionParameter && ($objFunction = $objFunction->getClass ()) && $objFunction instanceof \ReflectionClass && ($objFunction = $objFunction->getName ())) {
                    // 接口绑定实现
                    if (($objFunctionMake = \Q::project ()->make ( $objFunction )) !== false) {
                        // 实例对象
                        if (is_object ( $objFunctionMake )) {
                            $booFindClass [$sType] = true;
                            $arrResult [$sType] [$intIndex] = $objFunctionMake;
                        }                        

                        // 接口绑定实现
                        elseif (\Q::classExists ( $objFunctionMake, false, true )) {
                            $booFindClass [$sType] = true;
                            $arrResult [$sType] [$intIndex] = new $objFunctionMake ( \Q::project () );
                        }
                    } elseif (\Q::classExists ( $objFunction, false, true )) {
                        $arrResult [$sType] [$intIndex] = new $objFunction ( \Q::project () );
                        $booFindClass [$sType] = true;
                    } else {
                        $arrResult [$sType] [$intIndex] = '';
                    }
                } else {
                    $arrResult [$sType] [$intIndex] = '';
                }
            }
        }
        
        foreach ( $booFindClass as $sType => $booFind ) {
            if ($booFind === false && isset ( $arrResult [$sType] )) {
                unset ( $arrResult [$sType] );
            }
        }
        
        return $arrResult;
    }
}
