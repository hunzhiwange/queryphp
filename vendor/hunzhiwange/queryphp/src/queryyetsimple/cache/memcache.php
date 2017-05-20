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

use queryyetsimple\exception\exceptions;

/**
 * memcache 扩展缓存
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.02.15
 * @version 1.0
 */
class memcache extends cache {
    
    /**
     * 默认服务器
     *
     * @var array
     */
    private $arrDefaultServer = [ 
            'host' => '127.0.0.1', // 缓存服务器地址或主机名
            'port' => '11211' 
    ]; // 缓存服务器端口
    
    /**
     * 缓存惯性配置
     *
     * @var array
     */
    private $arrDefaultOption = [ 
            'servers' => [ ],
            'compressed' => false, // 是否压缩缓存数据
            'persistent' => true 
    ]; // 是否使用持久连接
    
    /**
     * 缓存服务句柄
     *
     * @var handle
     */
    private $hHandel;
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrDefaultObjectOption = [ 
            'runtime_memcache_compressed' => false,
            'runtime_memcache_persistent' => true,
            'runtime_memcache_servers' => [ ],
            'runtime_memcache_host' => '127.0.0.1',
            'runtime_memcache_port' => 11211 
    ];
    
    /**
     * 构造函数
     *
     * @param array $arrOption            
     * @return void
     */
    public function __construct(array $arrOption = []) {
        if (! extension_loaded ( 'memcache' )) {
            exceptions::throwException ( 'memcache extension must be loaded before use.', 'queryyetsimple\cache\exception' );
        }
        
        $this->mergeObjectOption_ ();
        
        // 合并默认配置
        $this->arrOption = array_merge ( $this->arrOption, $this->arrDefaultOption );
        $this->arrOption ['compressed'] = $this->getExpansionInstanceArgs_ ( 'runtime_memcache_compressed' );
        $this->arrOption ['persistent'] = $this->getExpansionInstanceArgs_ ( 'runtime_memcache_persistent' );
        
        if (is_array ( $arrOption )) {
            $this->arrOption = array_merge ( $this->arrOption, $arrOption );
        }
        
        if (empty ( $this->arrOption ['servers'] )) {
            if (! empty ( $this->getExpansionInstanceArgs_ ( 'runtime_memcache_servers' ) )) {
                $this->arrOption ['servers'] = $this->getExpansionInstanceArgs_ ( 'runtime_memcache_servers' );
            } else {
                $this->arrOption ['servers'] [] = array (
                        'host' => $this->getExpansionInstanceArgs_ ( 'runtime_memcache_host' ),
                        'port' => $this->getExpansionInstanceArgs_ ( 'runtime_memcache_port' ) 
                );
            }
        }
        
        // 连接缓存服务器
        $this->hHandel = new Memcache ();
        
        foreach ( $this->arrOption ['servers'] as $arrServer ) {
            $bResult = $this->hHandel->addServer ( $arrServer ['host'], $arrServer ['port'], $this->arrOption ['persistent'] );
            if (! $bResult) {
                exceptions::throwException ( sprintf ( 'Unable to connect the memcached server [%s:%s] failed.', $arrServer ['host'], $arrServer ['port'] ), 'queryyetsimple\cache\exception' );
            }
        }
    }
    
    /**
     * 获取缓存
     *
     * @param string $sCacheName            
     * @param array $arrOption            
     * @return mixed
     */
    public function get($sCacheName, array $arrOption = []) {
        $arrOption = $this->option ( $arrOption, null, false );
        return $this->hHandel->get ( $this->getCacheName_ ( $sCacheName, $arrOption ) );
    }
    
    /**
     * 设置缓存
     *
     * memcache 0 表示永不过期
     *
     * @param string $sCacheName            
     * @param mixed $mixData            
     * @param array $arrOption            
     * @return void
     */
    public function set($sCacheName, $mixData, array $arrOption = []) {
        $arrOption = $this->option ( $arrOption, null, false );
        $this->hHandel->set ( $this->getCacheName_ ( $sCacheName, $arrOption ), $mixData, $arrOption ['compressed'] ? MEMCACHE_COMPRESSED : 0, ( int ) $arrOption ['cache_time'] === - 1 ? 0 : ( int ) $arrOption ['cache_time'] );
    }
    
    /**
     * 清除缓存
     *
     * @param string $sCacheName            
     * @param array $arrOption            
     * @return void
     */
    public function delele($sCacheName, array $arrOption = []) {
        $arrOption = $this->option ( $arrOption, null, false );
        return $this->hHandel->delete ( $this->getCacheName_ ( $sCacheName, $arrOption ) );
    }
}
