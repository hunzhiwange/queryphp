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
 * @date 2017.04.25
 * @since 4.0
 */
namespace Q\traits;

/**
 * 自动注入复用
 *
 * @author Xiangmin Liu
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
            if (is_string ( $mixClassOrCallback [0] )) {
                $objReflection = new \ReflectionClass ( $mixClassOrCallback [0] );
                if (($objConstructor = $objReflection->getConstructor ()) && ($arrParameters = $objConstructor->getParameters ())) {
                    $arrFunctions ['constructor'] = $arrParameters;
                }
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
                    if (($objFunctionMake = $this->objProject->make ( $objFunction )) !== false) {
                        // 接口绑定实现
                        if (\Q::classExists ( $objFunctionMake, false, true )) {
                            $booFindClass [$sType] = true;
                            $arrResult [$sType] [$intIndex] = new $objFunctionMake ( $this->objProject );
                        }                        

                        // 实例对象
                        elseif (is_object ( $objFunctionMake )) {
                            $booFindClass [$sType] = true;
                            $arrResult [$sType] [$intIndex] = $objFunctionMake;
                        }
                    } elseif (\Q::classExists ( $objFunction, false, true )) {
                        $arrResult [$sType] [$intIndex] = new $objFunction ( $this->objProject );
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
