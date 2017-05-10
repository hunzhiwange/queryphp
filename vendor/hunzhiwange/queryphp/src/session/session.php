<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace Q\session;

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

use Q\traits\dynamic\expansion as dynamic_expansion;
use Q\assert\assert;
use Q\contract\session\session as contract_session;

/**
 * session 封装
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.17
 * @version 1.0
 */
class session implements contract_session {
    
    use dynamic_expansion;
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [ 
            'session_prefix' => 'q_',
            'session_id' => null,
            'session_name' => null,
            'session_cookid_domain' => null,
            'session_cache_limiter' => null,
            'session_cache_expire' => 86400,
            'session_cookie_lifetime' => null,
            'session_gc_maxlifetime' => null,
            'session_save_path' => null,
            'session_use_trans_sid' => null,
            'session_gc_probability' => null 
    ];
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct() {
        if (! isset ( $_SESSION )) {
            // 设置 session 不自动启动
            ini_set ( 'session.auto_start', 0 );
            
            // 设置 session id
            if ($this->getExpansionInstanceArgs_ ( 'session_id' )) {
                session_id ( $this->getExpansionInstanceArgs_ ( 'session_id' ) );
            } else {
                if (is_null ( $this->parseSessionId () )) {
                    $this->sessionId ( uniqid ( dechex ( mt_rand () ) ) );
                }
            }
            
            // cookie domain
            if ($this->getExpansionInstanceArgs_ ( 'session_cookie_domain' )) {
                $this->cookieDomain ( $this->getExpansionInstanceArgs_ ( 'session_cookie_domain' ) );
            }
            
            // session name
            if ($this->getExpansionInstanceArgs_ ( 'session_name' )) {
                $this->sessionName ( $this->getExpansionInstanceArgs_ ( 'session_name' ) );
            }
            
            // cache expire
            if ($this->getExpansionInstanceArgs_ ( 'session_cache_expire' )) {
                $this->cacheExpire ( $this->getExpansionInstanceArgs_ ( 'session_cache_expire' ) );
            }
            
            // gc maxlifetime
            if ($this->getExpansionInstanceArgs_ ( 'session_gc_maxlifetime' )) {
                $this->gcMaxlifetime ( $this->getExpansionInstanceArgs_ ( 'session_gc_maxlifetime' ) );
            }
            
            // cookie lifetime
            if ($this->getExpansionInstanceArgs_ ( 'session_cookie_lifetime' )) {
                $this->cookieLifetime ( $this->getExpansionInstanceArgs_ ( 'session_cookie_lifetime' ) );
            }
            
            // cache limiter
            if ($this->getExpansionInstanceArgs_ ( 'session_cache_limiter' )) {
                $this->cacheLimiter ( $this->getExpansionInstanceArgs_ ( 'session_cache_limiter' ) );
            }
            
            // save path
            if ($this->getExpansionInstanceArgs_ ( 'session_save_path' )) {
                $this->savePath ( $this->getExpansionInstanceArgs_ ( 'session_save_path' ) );
            }
            
            // use_trans_sid
            if ($this->getExpansionInstanceArgs_ ( 'session_use_trans_sid' )) {
                $this->useTransSid ( $this->getExpansionInstanceArgs_ ( 'session_use_trans_sid' ) );
            }
            
            // gc_probability
            if ($this->getExpansionInstanceArgs_ ( 'session_gc_probability' )) {
                $this->gcProbability ( $this->getExpansionInstanceArgs_ ( 'session_gc_probability' ) );
            }
            
            // 启动 session
            if (! session_start ()) {
                return null;
            }
        }
    }
    
    /**
     * 设置 session
     *
     * @param string $sName            
     * @param mxied $mixValue            
     * @param boolean $bPrefix            
     * @return void
     */
    public function set($sName, $mixValue, $bPrefix = true) {
        assert::string ( $sName );
        $sName = $this->getName_ ( $sName, $bPrefix );
        $_SESSION [$sName] = $mixValue;
    }
    
    /**
     * 取回 session
     *
     * @param string $sName            
     * @param boolean $bPrefix            
     * @return mxied
     */
    public function get($sName, $bPrefix = true) {
        assert::string ( $sName );
        $sName = $this->getName_ ( $sName, $bPrefix );
        return isset ( $_SESSION [$sName] ) ? $_SESSION [$sName] : null;
    }
    
    /**
     * 删除 session
     *
     * @param string $sName            
     * @param boolean $bPrefix            
     * @return bool
     */
    public function delete($sName, $bPrefix = true) {
        assert::string ( $sName );
        $sName = $this->getName_ ( $sName, $bPrefix );
        return session_unregister ( $sName );
    }
    
    /**
     * 是否存在 session
     *
     * @param string $sName            
     * @param boolean $bPrefix            
     */
    public function has($sName, $bPrefix = true) {
        assert::string ( $sName );
        $sName = $this->getName_ ( $sName, $bPrefix );
        return isset ( $_SESSION [$sName] );
    }
    
    /**
     * 删除 session
     *
     * @param boolean $bOnlyDeletePrefix            
     * @return int
     */
    public function clear($bOnlyDeletePrefix = true) {
        $nSession = count ( $_SESSION );
        $strSessionPrefix = $this->getExpansionInstanceArgs_ ( 'session_prefix' );
        foreach ( $_SESSION as $sKey => $Val ) {
            if ($bOnlyDeletePrefix === true && $strSessionPrefix) {
                if (strpos ( $sKey, $strSessionPrefix ) === 0) {
                    $this->delete ( $sKey, false );
                }
            } else {
                $this->delete ( $sKey, false );
            }
        }
        return $nSession;
    }
    
    /**
     * 暂停 session
     *
     * @return void
     */
    public function pause() {
        session_write_close ();
    }
    
    /**
     * 终止会话
     *
     * @return bool
     */
    public function destroy() {
        $this->clear ( false );
        
        if (isset ( $_COOKIE [$this->sessionName ()] )) {
            setcookie ( $this->sessionName (), '', time () - 42000, '/' );
        }
        
        session_destroy ();
    }
    
    /**
     * 获取解析 session_id
     *
     * @param string $sId            
     * @return string
     */
    public function parseSessionId() {
        if (($sId = $this->sessionId ())) {
            return $sId;
        }
        if ($this->useCookies ()) {
            if (isset ( $_COOKIE [$this->sessionName ()] )) {
                return $_COOKIE [$this->sessionName ()];
            }
        } else {
            if (isset ( $_GET [$this->sessionName ()] )) {
                return $_GET [$this->sessionName ()];
            }
            if (isset ( $_POST [$this->sessionName ()] )) {
                return $_POST [$this->sessionName ()];
            }
        }
        return null;
    }
    
    /**
     * 设置 save path
     *
     * @param string $sSavePath            
     * @return string
     */
    public function savePath($sSavePath = null) {
        return ! empty ( $sSavePath ) ? session_save_path ( $sSavePath ) : session_save_path ();
    }
    
    /**
     * 设置 cache limiter
     *
     * @param string $strCacheLimiter            
     * @return string
     */
    public function cacheLimiter($strCacheLimiter = null) {
        return isset ( $strCacheLimiter ) ? session_cache_limiter ( $strCacheLimiter ) : session_cache_limiter ();
    }
    
    /**
     * 设置 cache expire
     *
     * @param int $nExpireSecond            
     * @return void
     */
    public function cacheExpire($nExpireSecond = null) {
        return isset ( $nExpireSecond ) ? session_cache_expire ( intval ( $nExpireSecond ) ) : session_cache_expire ();
    }
    
    /**
     * session_name
     *
     * @param string $sName            
     * @return string
     */
    public function sessionName($sName = null) {
        return isset ( $sName ) ? session_name ( $sName ) : session_name ();
    }
    
    /**
     * session id
     *
     * @param string $sId            
     * @return string
     */
    public function sessionId($sId = null) {
        return isset ( $sId ) ? session_id ( $sId ) : session_id ();
    }
    
    /**
     * session 的 cookie_domain 设置
     *
     * @param string $sSessionDomain            
     * @return string
     */
    public function cookieDomain($sSessionDomain = null) {
        $sReturn = ini_get ( 'session.cookie_domain' );
        if (! empty ( $sSessionDomain )) {
            ini_set ( 'session.cookie_domain', $sSessionDomain ); // 跨域访问 session
        }
        return $sReturn;
    }
    
    /**
     * session 是否使用 cookie
     *
     * @param boolean $bUseCookies            
     * @return boolean
     */
    public function useCookies($bUseCookies = null) {
        $booReturn = ini_get ( 'session.use_cookies' ) ? true : false;
        if (isset ( $bUseCookies )) {
            ini_set ( 'session.use_cookies', $bUseCookies ? 1 : 0 );
        }
        return $booReturn;
    }
    
    /**
     * 客户端禁用 cookie 可以开启这个项
     *
     * @param string $nUseTransSid            
     * @return boolean
     */
    public function useTransSid($nUseTransSid = null) {
        $booReturn = ini_get ( 'session.use_trans_sid' ) ? true : false;
        if (isset ( $nUseTransSid )) {
            ini_set ( 'session.use_trans_sid', $nUseTransSid ? 1 : 0 );
        }
        return $booReturn;
    }
    
    /**
     * 设置过期 cookie lifetime
     *
     * @param int $nCookieLifeTime            
     * @return int
     */
    public function cookieLifetime($nCookieLifeTime) {
        $nReturn = ini_get ( 'session.cookie_lifetime' );
        if (isset ( $nCookieLifeTime ) && intval ( $nCookieLifeTime ) >= 1) {
            ini_set ( 'session.cookie_lifetime', intval ( $nCookieLifeTime ) );
        }
        return $nReturn;
    }
    
    /**
     * gc maxlifetime
     *
     * @param int $nGcMaxlifetime            
     * @return int
     */
    public function gcMaxlifetime($nGcMaxlifetime = null) {
        $nReturn = ini_get ( 'session.gc_maxlifetime' );
        if (isset ( $nGcMaxlifetime ) && intval ( $nGcMaxlifetime ) >= 1) {
            ini_set ( 'session.gc_maxlifetime', intval ( $nGcMaxlifetime ) );
        }
        return $nReturn;
    }
    
    /**
     * session 垃圾回收概率分子 (分母为 session.gc_divisor)
     *
     * @param int $nGcProbability            
     * @return int
     */
    public function gcProbability($nGcProbability = null) {
        $nReturn = ini_get ( 'session.gc_probability' );
        if (isset ( $nGcProbability ) && intval ( $nGcProbability ) >= 1 && intval ( $nGcProbability ) <= 100) {
            ini_set ( 'session.gc_probability', intval ( $nGcProbability ) );
        }
        return $nReturn;
    }
    
    /**
     * 返回 session 名字
     *
     * @param string $sName            
     * @param boolean $bPrefix            
     * @return string
     */
    private function getName_($sName, $bPrefix = true) {
        return ($bPrefix ? $this->getExpansionInstanceArgs_ ( 'session_prefix' ) : '') . $sName;
    }
}
