<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\support\interfaces;

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
 * container 接口
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.13
 * @version 4.0
 */
interface container {
    
    /**
     * 注册工厂
     *
     * @param mixed $mixFactoryName            
     * @param mixed $mixFactory            
     * @return void
     */
    public function register($mixFactoryName, $mixFactory = null);
    
    /**
     * 强制注册为实例，存放数据
     *
     * @param string $strFactoryName            
     * @param mixed $mixFactory            
     * @return void
     */
    public function instance($strFactoryName, $mixFactory);
    
    /**
     * 注册单一实例
     *
     * @param string $strFactoryName            
     * @param mixed $mixFactory            
     * @return void
     */
    public function singleton($mixFactoryName, $mixFactory = null);
    
    /**
     * 设置别名
     *
     * @param array|string $mixAlias            
     * @param string $strValue            
     * @return void
     */
    public function alias($mixAlias, $strValue = null);
    
    /**
     * 分组注册
     *
     * @param string $strGroupName            
     * @param mixed $mixGroupData            
     * @return void
     */
    public function group($strGroupName, $mixGroupData);
    
    /**
     * 分组制造
     *
     * @param string $strGroupName            
     * @return array
     */
    public function groupMake($strGroupName);
    
    /**
     * 生产产品 (动态参数)
     *
     * @param string $strFactoryName            
     * @return object
     */
    public function make($strFactoryName /* args */);
    
    /**
     * 生产产品 (数组参数)
     *
     * @param string $strFactoryName            
     * @param array $arrArgs            
     * @return object
     */
    public function makeWithArgs($strFactoryName, array $arrArgs = []);
}
