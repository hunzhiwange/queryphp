<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.18
 * @since 1.0
 */
namespace Q\view;

use Q, Q\view\parsers, Q\mvc\view;

/**
 * 模板处理类
 *
 * @author Xiangmin Liu
 */
class theme {
    
    /**
     * 变量值
     *
     * @var array
     */
    private $arrVar = [ ];
    
    /**
     * 加载视图文件
     * 
     * @param string $sFile 视图文件地址
     * @param boolean $bDisplay 是否显示
     * @param string $sTargetCache 主模板缓存路径
     * @param string $sMd5 源文件地址 md5 标记
     * @return string
     */
    public function display($sFile, $bDisplay = true, $sTargetCache = '', $sMd5 = '') {
        // 分析模板文件
        if (! is_file ( $sFile )) {
            $sFile = view::parseDefaultFile ( $sFile );
        }
        if (! is_file ( $sFile )) {
            Q::throwException ( Q::i18n ( '模板文件 %s 不存在', $sFile ) );
        }
        
        // 变量赋值
        if (is_array ( $this->arrVar ) and ! empty ( $this->arrVar )) {
            extract ( $this->arrVar, EXTR_PREFIX_SAME, 'q_' );
        }
        
        $sCachePath = $this->getCachePath ( $sFile ); // 编译文件路径
        if ($this->isCacheExpired ( $sFile, $sCachePath )) { // 重新编译
            parsers::run ()->doCombile ( $sFile, $sCachePath );
        }
        
        // 逐步将子模板缓存写入父模板至到最后
        if ($sTargetCache) {
            if (is_file ( $sFile ) && is_file ( $sTargetCache )) {
                // 源码
                $sTargetContent = file_get_contents ( $sTargetCache );
                $sChildCache = file_get_contents ( $sCachePath );
                
                // 替换
                $sTargetContent = preg_replace ( "/<!--<\#\#\#\#incl\*" . $sMd5 . "\*ude\#\#\#\#>-->(.*?)<!--<\/\#\#\#\#incl\*" . $sMd5 . "\*ude\#\#\#\#\/>-->/s", substr ( $sChildCache, strpos ( $sChildCache, Q::osNewline () ) - 1 ), $sTargetContent );
                file_put_contents ( $sTargetCache, $sTargetContent );
                
                unset ( $sChildCache, $sTargetContent );
            } else {
                Q::throwException ( sprintf ( 'source %s and target cache %s is not a valid path', $sFile, $sTargetCache ) );
            }
        }

        // 返回类型
        if ($bDisplay === false) {
            ob_start ();
            include $sCachePath;
            $sReturn = ob_get_contents ();
            ob_end_clean ();
            return $sReturn;
        } else { // 不需要返回
            include $sCachePath;
        }
    }
    
    /**
     * 设置模板变量
     *
     * @param mixed $mixName            
     * @param mixed $mixValue            
     * @return
     *
     */
    public function setVar($mixName, $mixValue = null) {
        if (is_string ( $mixName )) {
            $this->arrVar [$mixName] = $mixValue;
        } elseif (is_array ( $mixName )) {
            $this->arrVar = array_merge ( $this->arrVar, $mixName );
        }
    }
    
    /**
     * 获取变量值
     *
     * @param string $sName            
     * @return mixed
     */
    public function getVar($sName) {
        return isset ( $this->arrVar [$sName] ) ? $this->_arrVar [$sName] : null;
    }
    
    /**
     * 判断缓存是否过期
     *
     * @param string $sFile            
     * @param string $sCachePath            
     * @return boolean
     */
    protected function isCacheExpired($sFile, $sCachePath) {
        // 开启调试
        if (Q_DEBUG === TRUE) {
            return true;
        }
        
        // 缓存文件不存在过期
        if (! is_file ( $sCachePath )) {
            return true;
        }
        
        // 编译过期时间为 -1 表示永不过期
        if ($GLOBALS ['option'] ['theme_cache_lifetime'] === - 1) {
            return false;
        }
        
        // 缓存时间到期
        if (filemtime ( $sCachePath ) + intval ( $GLOBALS ['option'] ['theme_cache_lifetime'] ) < time ()) {
            return true;
        }
        
        // 文件有更新
        if (filemtime ( $sFile ) >= filemtime ( $sCachePath )) {
            return true;
        }
        
        return false;
    }
    
    /**
     * 获取编译路径
     *
     * @param string $sFile            
     * @return string
     */
    public function getCachePath($sFile) {
        // 统一斜线
        $sFile = str_replace ( '\\', '/', $sFile );
        $sFile = str_replace ( '//', '/', $sFile );
        
        // 统一缓存文件
        $sFile = basename ( $sFile, '.' . Q::getExtName ( $sFile ) ) . '.' . md5 ( $sFile ) . '.php';
        
        // 返回真实路径
        return Q::app ()->themecache_path . '/' . $sFile;
    }
}
