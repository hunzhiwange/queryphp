<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\option;

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

use queryyetsimple\exception\exceptions;
use queryyetsimple\helper\helper;
use queryyetsimple\filesystem\directory;
use queryyetsimple\router\router;

/**
 * 配置工具类
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.18
 * @version 1.0
 */
class tool {
    
    /**
     * 合并配置文件数据
     *
     * @param array $arrOptionDir            
     * @param array $arrOptionType            
     * @param string $sOptionCache            
     * @param array $arrExtendData            
     * @param boolean $booInitApp            
     * @return void
     */
    public static function saveToCache($arrOptionDir, $arrOptionType, $sOptionCache, $arrExtendData = [], $booInitApp = false) {
        $arrOptionData = [ ];
        foreach ( $arrOptionType as $sType ) {
            $arrOptionData [$sType] = [ ];
        }
        
        foreach ( $arrOptionDir as $sDir ) {
            foreach ( $arrOptionType as $sType ) {
                if (! is_file ( $strFile = $sDir . '/' . $sType . '.php' ))
                    continue;
                $arrOptionData [$sType] = array_merge ( $arrOptionData [$sType], ( array ) (include $strFile) );
            }
        }
        
        foreach ( $arrOptionType as $sType ) {
            $arrOptionData [$sType] = helper::arrayMergePlus ( $arrOptionData [$sType] );
        }
        
        $arrOptionTypeAll = $arrOptionType;
        
        if (! empty ( $arrOptionData ['app'] ['option_extend'] )) {
            $arrOptionExtend = array_diff ( helper::arrays ( $arrOptionData ['app'] ['option_extend'] ), $arrOptionType );
            $arrOptionTypeAll = array_merge ( $arrOptionTypeAll, $arrOptionExtend );
            foreach ( $arrOptionExtend as $sType ) {
                $arrOptionData [$sType] = [ ];
            }
            
            foreach ( $arrOptionDir as $sDir ) {
                foreach ( $arrOptionExtend as $sType ) {
                    if (! is_file ( $strFile = $sDir . '/' . $sType . '.php' ))
                        continue;
                    $arrOptionData [$sType] = array_merge ( $arrOptionData [$sType], ( array ) (include $strFile) );
                }
            }
            
            foreach ( $arrOptionExtend as $sType ) {
                $arrOptionData [$sType] = helper::arrayMergePlus ( $arrOptionData [$sType] );
            }
        }
        
        if ($arrExtendData) {
            foreach ( $arrExtendData as $sType => $arrTemp ) {
                if (isset ( $arrOptionData [$sType] )) {
                    $arrOptionData [$sType] = helper::arrayMergePlus ( array_merge ( $arrOptionData [$sType], $arrTemp ) );
                } else {
                    $arrOptionData [sType] = $arrTemp;
                }
            }
        }
        
        $arrOptionData ['app'] ['~routers~'] = [ 
                'router' 
        ];
        
        if ($booInitApp) {
            self::router_ ( $arrOptionData, $arrOptionDir, $arrOptionTypeAll );
        }
        
        if (! is_dir ( dirname ( $sOptionCache ) )) {
            directory::create ( dirname ( $sOptionCache ) );
        }
        
        if (! file_put_contents ( $sOptionCache, "<?php\n /* option cache */ \n return " . var_export ( $arrOptionData, true ) . "\n?>" )) {
            exceptions::throwException ( sprintf ( 'dir %s Do not have permission.', $this->optioncache_path ) );
        }
        
        option::resets ( $arrOptionData );
        unset ( $arrOptionData );
    }
    
    /**
     * 路由配置
     *
     * @param array $arrOptionData            
     * @param array $arrOptionDir            
     * @param array $arrOptionTypeAll            
     * @return void
     */
    private static function router_(&$arrOptionData, $arrOptionDir, $arrOptionTypeAll) {
        if (! empty ( $arrOptionData ['app'] ['router_extend'] )) {
            $arrRouterExtend = array_diff ( array_map ( function ($strItem) {
                return 'router_' . $strItem;
            }, helper::arrays ( $arrOptionData ['app'] ['router_extend'] ) ), $arrOptionTypeAll );
            
            $arrOptionData ['app'] ['~routers~'] = array_merge ( $arrOptionData ['app'] ['~routers~'], $arrRouterExtend );
            
            foreach ( $arrOptionDir as $sDir ) {
                foreach ( $arrRouterExtend as $sType ) {
                    if (! is_file ( $strFile = $sDir . '/' . $sType . '.php' ))
                        continue;
                    $arrOptionData ['router'] = array_merge ( $arrOptionData ['router'], ( array ) (include $strFile) );
                }
            }
        }
        if ($arrOptionData ['router']) {
            $arrOptionData ['router'] = helper::arrayMergePlus ( $arrOptionData ['router'] );
            router::importCaches ( $arrOptionData ['router'] );
        }
    }
}
