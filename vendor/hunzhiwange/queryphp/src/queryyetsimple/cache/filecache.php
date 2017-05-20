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

use queryyetsimple\filesystem\directory;

/**
 * 文件缓存
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.02.15
 * @version 1.0
 */
class filecache extends cache {
    
    /**
     * 缓存惯性配置
     *
     * @var array
     */
    private $arrDefaultOption = [ 
            'json' => true,
            'cache_path' => '' 
    ];
    
    /**
     * 缓存文件头部
     *
     * @var string
     */
    const HEADER = '<?php die(); ?>';
    
    /**
     * 缓存文件头部长度
     *
     * @var int
     */
    const HEADER_LENGTH = 15;
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrDefaultObjectOption = [ 
            'runtime_file_path' => '',
            'path_cache_file' => '' 
    ];
    
    /**
     * 构造函数
     *
     * @param array $arrOption            
     * @return void
     */
    public function __construct(array $arrOption = []) {
        $this->mergeObjectOption_ ();
        
        // 合并默认配置
        $this->arrOption = array_merge ( $this->arrOption, $this->arrDefaultOption );
        if (! empty ( $arrOption )) {
            $this->arrOption = array_merge ( $this->arrOption, $arrOption );
        }
        if (empty ( $this->_arrOption ['cache_path'] )) {
            if ($this->getExpansionInstanceArgs_ ( 'runtime_file_path' )) {
                $this->arrOption ['cache_path'] = $this->getExpansionInstanceArgs_ ( 'runtime_file_path' );
            } else {
                $this->arrOption ['cache_path'] = $this->getExpansionInstanceArgs_ ( 'path_cache_file' );
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
        $sCachePath = $this->getCachePath_ ( $sCacheName, $arrOption );
        
        // 清理文件状态缓存 http://www.w3school.com.cn/php/func_filesystem_clearstatcache.asp
        clearstatcache ();
        
        if (! is_file ( $sCachePath )) {
            return false;
        }
        
        $hFp = fopen ( $sCachePath, 'rb' );
        if (! $hFp) {
            return false;
        }
        flock ( $hFp, LOCK_SH );
        
        // 头部的16个字节存储了安全代码
        $nLen = filesize ( $sCachePath );
        $sHead = fread ( $hFp, static::HEADER_LENGTH );
        $nLen -= static::HEADER_LENGTH;
        
        do {
            // 检查缓存是否已经过期
            if ($this->isExpired_ ( $sCacheName, $arrOption )) {
                $strData = false;
                break;
            }
            
            if ($nLen > 0) {
                $strData = fread ( $hFp, $nLen );
            } else {
                $strData = false;
            }
        } while ( false );
        
        flock ( $hFp, LOCK_UN );
        fclose ( $hFp );
        
        if ($strData === false) {
            return false;
        }
        
        // 解码
        if ($arrOption ['json']) {
            $strData = json_decode ( $strData, true );
        }
        
        return $strData;
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
        if ($arrOption ['json']) {
            $mixData = json_encode ( $mixData );
        }
        $mixData = static::HEADER . $mixData;
        
        $sCachePath = $this->getCachePath_ ( $sCacheName, $arrOption );
        $this->writeData_ ( $sCachePath, $mixData );
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
        $sCachePath = $this->getCachePath_ ( $sCacheName, $arrOption );
        if ($this->exist_ ( $sCacheName, $arrOption )) {
            @unlink ( $sCachePath );
        }
    }
    
    /**
     * 验证缓存是否过期
     *
     * @param string $sCacheName            
     * @param array $arrOption            
     * @return boolean
     */
    private function isExpired_($sCacheName, $arrOption) {
        $sFilePath = $this->getCachePath_ ( $sCacheName, $arrOption );
        if (! is_file ( $sFilePath )) {
            return true;
        }
        ! isset ( $arrOption ['cache_time'] ) && $arrOption ['cache_time'] = - 1;
        return ( int ) $arrOption ['cache_time'] !== - 1 && filemtime ( $sFilePath ) + ( int ) $arrOption ['cache_time'] < time ();
    }
    
    /**
     * 获取缓存路径
     *
     * @param string $sCacheName            
     * @param array $arrOption            
     * @return string
     */
    private function getCachePath_($sCacheName, $arrOption) {
        if (! is_dir ( $arrOption ['cache_path'] )) {
            directory::create ( $arrOption ['cache_path'] );
        }
        return $arrOption ['cache_path'] . '/' . $this->getCacheName_ ( $sCacheName, $arrOption ) . '.php';
    }
    
    /**
     * 写入缓存数据
     *
     * @param string $sFileName            
     * @param string $sData            
     * @return boolean
     */
    private function writeData_($sFileName, $sData) {
        ! is_dir ( dirname ( $sFileName ) ) && directory::create ( dirname ( $sFileName ) );
        return file_put_contents ( $sFileName, $sData, LOCK_EX );
    }
    
    /**
     * 验证缓存是否存在
     *
     * @param string $sCacheName            
     * @param array $arrOption            
     * @return boolean
     */
    private function exist_($sCacheName, $arrOption) {
        $sCachePath = $this->getCachePath_ ( $sCacheName, $arrOption );
        return is_file ( $sCachePath );
    }
}
