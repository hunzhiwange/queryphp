<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\cache;

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

use queryyetsimple\cache\interfaces\cache as interfaces_cache;
use queryyetsimple\traits\object\option as object_option;

/**
 * 缓存抽象类
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.02.15
 * @version 4.0
 */
abstract class cache implements interfaces_cache {
    
    use object_option;
    
    /**
     * 缓存惯性配置
     *
     * @var array
     */
    protected $arrOption = [ 
            'cache_time' => 86400,
            'cache_prefix' => '~@' 
    ];
    
    /**
     * 修改配置
     *
     * @param mixed $mixName            
     * @param mixed $mixValue            
     * @param boolean $booMerge            
     * @return array
     */
    public function option($mixName = '', $mixValue = null, $booMerge = true) {
        $arrOption = $this->arrOption;
        if (! empty ( $mixName )) {
            if (is_array ( $mixName )) {
                $arrOption = array_merge ( $arrOption, $mixName );
            } else {
                if (is_null ( $mixValue )) {
                    if (isset ( $arrOption [$mixName] )) {
                        unset ( $arrOption [$mixName] );
                    }
                } else {
                    $arrOption [$mixName] = $mixValue;
                }
            }
            
            if ($booMerge === true) {
                $this->arrOption = $arrOption;
            }
        }
        
        return $arrOption;
    }
    
    /**
     * 缓存统一入口
     *
     * @param string $sId            
     * @param string $mixData            
     * @param array $arrOption            
     * @param string $sBackendClass            
     * @return boolean
     */
    public static function run($sId, $mixData = '', $arrOption = null, $sBackendClass = null) {
        static $arrCache;
        
        if (! is_array ( $arrOption )) {
            $arrOption = [ ];
        }
        $arrOption = array_merge ( [ 
                'cache_time' => static::cacheTime_ ( $sId,  ['runtime_cache_time'] ),
                'cache_prefix' => ['runtime_cache_prefix'],
                'cache_backend' => ! is_null ( $sBackendClass ) ? $sBackendClass :  ['runtime_cache_backend'] 
        ], $arrOption );
        
        if (empty ( $arrCache [$arrOption ['cache_backend']] )) {
            $arrObjectOption = [ ];
            foreach ( [ 
                    'runtime_file_path',
                    'runtime_memcache_compressed',
                    'runtime_memcache_persistent',
                    'runtime_memcache_servers',
                    'runtime_memcache_host',
                    'runtime_memcache_port' 
            ] as $sObjectOption ) {
                $arrObjectOption [$sObjectOption] =  [$sObjectOption];
            }
            $arrObjectOption ['path_cache_file'] = static::project ()->path_cache_file;
            $arrCache [$arrOption ['cache_backend']] = static::project ()->make ( $arrOption ['cache_backend'], $arrOption )->setObjectOption ( $arrObjectOption );
        }
        
        if ($mixData === '') {
            // 强制刷新页面数据
            if (static::in ( ['runtime_cache_force_name'] ) == 1) {
                return false;
            }
            return $arrCache [$arrOption ['cache_backend']]->get ( $sId, $arrOption );
        }
        if ($mixData === null) {
            return $arrCache [$arrOption ['cache_backend']]->delele ( $sId, $arrOption );
        }
        return $arrCache [$arrOption ['cache_backend']]->set ( $sId, $mixData, $arrOption );
    }
    

    /**
     * 读取缓存时间配置
     *
     * @param string $sId
     * @param int $intDefaultTime
     * @return number
     */
    private static function cacheTime_($sId, $intDefaultTime = 0) {
        if (isset (  ['runtime_cache_times'] [$sId] )) {
            return  ['runtime_cache_times'] [$sId];
        }
    
        foreach ( ['runtime_cache_times'] as $sKey => $nValue ) {
            $sKeyCache = '/^' . str_replace ( '*', '(\S+)', $sKey ) . '$/';
            if (preg_match ( $sKeyCache, $sId, $arrRes )) {
                return ['runtime_cache_times'] [$sKey];
            }
        }
    
        return $intDefaultTime;
    }
    
    
    /**
     * 获取缓存名字
     *
     * @param string $sCacheName            
     * @param array $arrOption            
     * @return string
     */
    protected function getCacheName_($sCacheName, $arrOption) {
        return $arrOption ['cache_prefix'] . $sCacheName;
    }
}
