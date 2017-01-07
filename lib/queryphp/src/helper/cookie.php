<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.19
 * @since 1.0
 */
namespace Q\helper;

/**
 * 对 PHP 原生Cookie 函数库的封装
 *
 * @author Xiangmin Liu
 */
class cookie {
    
    /**
     * 设置 COOKIE
     *
     * @param string $sName            
     * @param string $mixValue            
     * @param number $nLife            
     * @param array $in
     *            cookie_domain 是否启用域名
     *            prefix 是否开启前缀
     *            http_only
     */
    public static function setCookie($sName, $mixValue = '', $nLife = 0, array $in = []) {
        $in = array_merge ( [ 
                'cookie_domain' => null,
                'prefix' => true,
                'http_only' => false 
        ], $in );
        
        $sName = ($in ['prefix'] ? $GLOBALS ['option'] ['cookie_prefix'] : '') . $sName;
        
        if ($mixValue === null || $nLife < 0) {
            $nLife = - 1;
            if (isset ( $_COOKIE [$sName] )) {
                unset ( $_COOKIE [$sName] );
            }
        } else {
            $_COOKIE [$sName] = $mixValue;
            if ($nLife !== NULL && $nLife == 0) {
                $nLife = $GLOBALS ['option'] ['cookie_expire'];
            }
        }
        
        $nLife = $nLife > 0 ? time () + $nLife : ($nLife < 0 ? time () - 31536000 : null);
        $sPath = $in ['http_only'] && PHP_VERSION < '5.2.0' ? $GLOBALS ['option'] ['cookie_path'] . ';HttpOnly' : $GLOBALS ['option'] ['cookie_path'];
        $in ['cookie_domain'] = $in ['cookie_domain'] !== null ? $in ['cookie_domain'] : $GLOBALS ['option'] ['cookie_domain'];
        
        $nSecure = $_SERVER ['SERVER_PORT'] == 443 ? 1 : 0;
        if (PHP_VERSION < '5.2.0') {
            setcookie ( $sName, $mixValue, $nLife, $sPath, $in ['cookie_domain'], $nSecure );
        } else {
            setcookie ( $sName, $mixValue, $nLife, $sPath, $in ['cookie_domain'], $nSecure, $in ['http_only'] );
        }
    }
    
    /**
     * 获取cookie
     *
     * @param string $sName            
     * @param string $bPrefix            
     * @return mixed
     */
    public static function getCookie($sName, $bPrefix = true) {
        $sName = ($bPrefix ? $GLOBALS ['option'] ['cookie_prefix'] : '') . $sName;
        return isset ( $_COOKIE [$sName] ) ? $_COOKIE [$sName] : null;
    }
    
    /**
     * 删除cookie
     *
     * @param string $sName            
     * @param string $sCookieDomain            
     * @param string $bPrefix            
     */
    public static function deleteCookie($sName, $sCookieDomain = null, $bPrefix = true) {
        self::setCookie ( $sName, null, - 1, [ 
                'cookie_domain' => $sCookieDomain,
                'prefix' => $bPrefix 
        ] );
    }
    
    /**
     * 清空cookie
     *
     * @param boolean $bOnlyDeletePrefix            
     * @param string $sCookieDomain            
     * @return cookie 顶层数量
     */
    public static function clearCookie($bOnlyDeletePrefix = true, $sCookieDomain = null) {
        $nCookie = count ( $_COOKIE );
        foreach ( $_COOKIE as $sKey => $Val ) {
            if ($bOnlyDeletePrefix === true && $GLOBALS ['option'] ['cookie_prefix']) {
                if (strpos ( $sKey, $GLOBALS ['option'] ['cookie_prefix'] ) === 0) {
                    self::deleteCookie ( $sKey, $sCookieDomain, false );
                }
            } else {
                self::deleteCookie ( $sKey, $sCookieDomain, false );
            }
        }
        
        return $nCookie;
    }
}
