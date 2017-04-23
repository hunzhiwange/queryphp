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
 * @date 2016.11.19
 * @since 1.0
 */
namespace Q\cookie;

use Q\traits\object_option;

/**
 * 对 PHP 原生Cookie 函数库的封装
 *
 * @author Xiangmin Liu
 */
class cookie {
    
    use object_option;
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrDefaultObjectOption = [ 
            'cookie_prefix' => 'q_',
            'cookie_expire' => 86400,
            'cookie_domain' => '',
            'cookie_path' => '/' 
    ];
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct() {
        $this->mergeObjectOption_ ();
    }
    
    /**
     * 设置 COOKIE
     *
     * @param string $sName            
     * @param string $mixValue            
     * @param array $in
     *            life 过期时间
     *            cookie_domain 是否启用域名
     *            prefix 是否开启前缀
     *            http_only
     * @return void
     */
    public function setCookie($sName, $mixValue = '', array $in = []) {
        $in = array_merge ( [ 
                'life' => 0,
                'cookie_domain' => null,
                'prefix' => true,
                'http_only' => false 
        ], $in );
        
        // 验证 cookie 值是不是一个标量
        if ($mixValue !== null && ! \Q::varType ( $mixValue, 'scalar' )) {
            \Q::throwException ( \Q::i18n ( 'cookie 值必须是一个 PHP 标量' ), 'Q\cookie\exception' );
        }
        
        $sName = ($in ['prefix'] === true ? $this->getObjectOption_ ( 'cookie_prefix' ) : '') . $sName;
        
        if ($mixValue === null || $in ['life'] < 0) {
            $in ['life'] = - 1;
            if (isset ( $_COOKIE [$sName] )) {
                unset ( $_COOKIE [$sName] );
            }
        } else {
            $_COOKIE [$sName] = $mixValue;
            if ($in ['life'] !== NULL && $in ['life'] === 0) {
                $in ['life'] = $this->getObjectOption_ ( 'cookie_expire' );
            }
        }
        
        $in ['life'] = $in ['life'] > 0 ? time () + $in ['life'] : ($in ['life'] < 0 ? time () - 31536000 : null);
        $in ['cookie_domain'] = $in ['cookie_domain'] !== null ? $in ['cookie_domain'] : $this->getObjectOption_ ( 'cookie_domain' );
        setcookie ( $sName, $mixValue, $in ['life'], $this->getObjectOption_ ( 'cookie_path' ), $in ['cookie_domain'], $_SERVER ['SERVER_PORT'] == 443 ? 1 : 0, $in ['http_only'] );
    }
    
    /**
     * 获取cookie
     *
     * @param string $sName            
     * @param string $bPrefix            
     * @return mixed
     */
    public function getCookie($sName, $bPrefix = true) {
        $sName = ($bPrefix ? $this->getObjectOption_ ( 'cookie_prefix' ) : '') . $sName;
        return isset ( $_COOKIE [$sName] ) ? $_COOKIE [$sName] : null;
    }
    
    /**
     * 删除cookie
     *
     * @param string $sName            
     * @param string $sCookieDomain            
     * @param string $bPrefix            
     * @return void
     */
    public function deleteCookie($sName, $sCookieDomain = null, $bPrefix = true) {
        self::setCookie ( $sName, null, [ 
                'life' => - 1,
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
    public function clearCookie($bOnlyDeletePrefix = true, $sCookieDomain = null) {
        $nCookie = count ( $_COOKIE );
        $strCookiePrefix = $this->getObjectOption_ ( 'cookie_prefix' );
        foreach ( $_COOKIE as $sKey => $Val ) {
            if ($bOnlyDeletePrefix === true && $strCookiePrefix) {
                if (strpos ( $sKey, $strCookiePrefix ) === 0) {
                    self::deleteCookie ( $sKey, $sCookieDomain, false );
                }
            } else {
                self::deleteCookie ( $sKey, $sCookieDomain, false );
            }
        }
        
        return $nCookie;
    }
}
