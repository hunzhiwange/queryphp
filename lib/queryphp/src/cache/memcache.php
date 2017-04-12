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
 * @date 2017.02.15
 * @since 1.0
 */
namespace Q\cache;

/**
 * memcache 扩展缓存
 *
 * @author Xiangmin Liu
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
     * 构造函数
     *
     * @param array $arrOption            
     * @return void
     */
    public function __construct(array $arrOption = []) {
        if (! extension_loaded ( 'memcache' )) {
            \Q::throwException ( 'memcache extension must be loaded before use.' );
        }
        
        // 合并默认配置
        $this->arrOption = array_merge ( $this->arrOption, $this->arrDefaultOption );
        $this->arrOption ['compressed'] = $GLOBALS ['_commonConfig_'] ['RUNTIME_MEMCACHE_COMPRESSED'];
        $this->arrOption ['persistent'] = $GLOBALS ['_commonConfig_'] ['RUNTIME_MEMCACHE_PERSISTENT'];
        
        if (is_array ( $arrOption )) {
            $this->arrOption = array_merge ( $this->arrOption, $arrOption );
        }
        
        if (empty ( $this->arrOption ['servers'] )) {
            if (! empty ( $GLOBALS ['_commonConfig_'] ['RUNTIME_MEMCACHE_SERVERS'] )) {
                $this->arrOption ['servers'] = $GLOBALS ['_commonConfig_'] ['RUNTIME_MEMCACHE_SERVERS'];
            } else {
                $this->arrOption ['servers'] [] = array (
                        'host' => $GLOBALS ['_commonConfig_'] ['RUNTIME_MEMCACHE_HOST'],
                        'port' => $GLOBALS ['_commonConfig_'] ['RUNTIME_MEMCACHE_PORT'] 
                );
            }
        }
        
        // 连接缓存服务器
        $this->hHandel = new Memcache ();
        
        foreach ( $this->arrOption ['servers'] as $arrServer ) {
            $bResult = $this->hHandel->addServer ( $arrServer ['host'], $arrServer ['port'], $this->arrOption ['persistent'] );
            if (! $bResult) {
                \Q::throwException ( sprintf ( 'Unable to connect the memcached server [%s:%s] failed.', $arrServer ['host'], $arrServer ['port'] ) );
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
    public function getCache($sCacheName, array $arrOption = []) {
        $arrOption = $this->option ( $arrOption, null, false );
        return $this->hHandel->get ( $this->getCacheName_ ( $sCacheName, $arrOption ) );
    }
    
    /**
     * 设置缓存
     *
     * @param string $sCacheName            
     * @param mixed $mixData            
     * @param array $arrOption            
     * @return void
     */
    public function set($sCacheName, $mixData, array $arrOption = []) {
        $arrOption = $this->option ( $arrOption, null, false );
        $this->hHandel->set ( $this->getCacheName_ ( $sCacheName, $arrOption ), $mixData, $arrOption ['compressed'] ? MEMCACHE_COMPRESSED : 0, $arrOption ['cache_time'] );
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
