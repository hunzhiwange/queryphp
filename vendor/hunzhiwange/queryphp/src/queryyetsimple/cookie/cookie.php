<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\cookie;

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

use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;
use queryyetsimple\assert\assert;

/**
 * cookie 封装
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
class cookie {
    
    use dynamic_expansion;
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [ 
            'cookie\prefix' => 'q_',
            'cookie\expire' => 86400,
            'cookie\domain' => '',
            'cookie\path' => '/' 
    ];
    
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
    public function set($sName, $mixValue = '', array $in = []) {
        $in = array_merge ( [ 
                'life' => 0,
                'cookie\domain' => null,
                'prefix' => true,
                'http_only' => false 
        ], $in );
        
        // 验证 cookie 值是不是一个标量
        assert::notNull ( $mixValue );
        assert::scalar ( $mixValue );
        
        $sName = ($in ['prefix'] === true ? $this->getExpansionInstanceArgs_ ( 'cookie\prefix' ) : '') . $sName;
        
        if ($mixValue === null || $in ['life'] < 0) {
            $in ['life'] = - 1;
            if (isset ( $_COOKIE [$sName] )) {
                unset ( $_COOKIE [$sName] );
            }
        } else {
            $_COOKIE [$sName] = $mixValue;
            if ($in ['life'] !== NULL && $in ['life'] === 0) {
                $in ['life'] = $this->getExpansionInstanceArgs_ ( 'cookie\expire' );
            }
        }
        
        $in ['life'] = $in ['life'] > 0 ? time () + $in ['life'] : ($in ['life'] < 0 ? time () - 31536000 : null);
        $in ['cookie\domain'] = $in ['cookie\domain'] !== null ? $in ['cookie\domain'] : $this->getExpansionInstanceArgs_ ( 'cookie\domain' );
        setcookie ( $sName, $mixValue, $in ['life'], $this->getExpansionInstanceArgs_ ( 'cookie\path' ), $in ['cookie\domain'], $_SERVER ['SERVER_PORT'] == 443 ? 1 : 0, $in ['http_only'] );
    }
    
    /**
     * 获取 cookie
     *
     * @param string $sName            
     * @param string $bPrefix            
     * @return mixed
     */
    public function get($sName, $bPrefix = true) {
        $sName = ($bPrefix ? $this->getExpansionInstanceArgs_ ( 'cookie\prefix' ) : '') . $sName;
        return isset ( $_COOKIE [$sName] ) ? $_COOKIE [$sName] : null;
    }
    
    /**
     * 删除 cookie
     *
     * @param string $sName            
     * @param string $sCookieDomain            
     * @param boolean $bPrefix            
     * @return void
     */
    public function delete($sName, $sCookieDomain = null, $bPrefix = true) {
        if (is_null ( $sCookieDomain ))
            $sCookieDomain = $this->getExpansionInstanceArgs_ ( 'cookie\domain' );
        $this->set ( $sName, null, [ 
                'life' => - 1,
                'cookie\domain' => $sCookieDomain,
                'prefix' => $bPrefix 
        ] );
    }
    
    /**
     * 清空 cookie
     *
     * @param boolean $bOnlyDeletePrefix            
     * @param string $sCookieDomain            
     * @return cookie 顶层数量
     */
    public function clear($bOnlyDeletePrefix = true, $sCookieDomain = null) {
        $nCookie = count ( $_COOKIE );
        $strCookiePrefix = $this->getExpansionInstanceArgs_ ( 'cookie\prefix' );
        if (is_null ( $sCookieDomain ))
            $sCookieDomain = $this->getExpansionInstanceArgs_ ( 'cookie\domain' );
        foreach ( $_COOKIE as $sKey => $Val ) {
            if ($bOnlyDeletePrefix === true && $strCookiePrefix) {
                if (strpos ( $sKey, $strCookiePrefix ) === 0) {
                    $this->delete ( $sKey, $sCookieDomain, false );
                }
            } else {
                $this->delete ( $sKey, $sCookieDomain, false );
            }
        }
        return $nCookie;
    }
}
