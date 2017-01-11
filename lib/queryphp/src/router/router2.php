<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.01.10
 * @since 1.0
 */
namespace Q\base;

use Q;

/**
 * 路由解析
 *
 * @author Xiangmin Liu
 */
class router {
    
    /**
     * 注册域名
     *
     * @var array
     */
    private static $arrDomains = [ ];
    
    /**
     * 注册路由
     *
     * @var array
     */
    private static $arrRouters = [ ];
    
    /**
     * 参数正则
     *
     * @var array
     */
    private static $arrWheres = [ ];
    
    /**
     * 默认替换参数[字符串]
     *
     * @var string
     */
    private static $strRegex = '\S+';
    
    /**
     * 分组传递参数
     *
     * @var array
     */
    private static $arrGroupArgs = [ ];
    
    /**
     * 导入路由规则
     *
     * @param string $strRouter            
     * @param string $strUrl            
     * @param arra $in
     *            domain 域名
     *            params 参数
     *            where 参数正则
     *            prepend 插入顺序
     * @return void
     */
    static function import($strRouter, $strUrl, $in = []) {
        $in = array_merge ( [ 
                'prepend' => false,
                'where' => [ ],
                'params' => [ ],
                'domain' => '' 
        ], self::$arrGroupArgs, $in );
        
        $arrRouter = [ 
                'url' => $strUrl,
                'regex' => $strRouter,
                'params' => $in ['params'],
                'where' => self::$arrWheres,
                'domain' => $in ['domain'] 
        ];
        
        // 合并参数正则
        if (! empty ( $in ['where'] ) && is_array ( $in ['where'] )) {
            if (is_string ( key ( $in ['where'] ) )) {
                $arrRouter ['where'] = array_merge ( $arrRouter ['where'], $in ['where'] );
            } else {
                $arrRouter ['where'] [$in ['where'] [0]] = $in ['where'] [1];
            }
        }
        
        // 分析 url 参数
        if (preg_match_all ( "/{(.+?)}/isx", $strRouter, $arrRes )) {
            foreach ( $arrRes [1] as $nIndex => $sWhere ) {
                $arrRouter ['regex'] = str_replace ( '{' . $sWhere . '}', '(' . (isset ( $arrRouter ['where'] [$sWhere] ) ? $arrRouter ['where'] [$sWhere] : self::$strRegex) . ')', $arrRouter ['regex'] );
            }
            $arrRouter ['args'] = $arrRes [1];
        }
        
        if (! isset ( self::$arrRouters [$strRouter] )) {
            self::$arrRouters [$strRouter] = [ ];
        }
        
        // 优先插入
        if ($in ['prepend'] === true) {
            array_unshift ( self::$arrRouters [$strRouter], $arrRouter );
        } else {
            array_push ( self::$arrRouters [$strRouter], $arrRouter );
        }
    }
    
    /**
     * 注册全局参数正则
     *
     * @param mixed $mixRegex            
     * @return void
     */
    static public function regex($mixRegex) {
        if (is_string ( key ( $mixRegex ) )) {
            self::$arrWheres = array_merge ( self::$arrWheres, $mixRegex );
        } else {
            self::$arrWheres [$mixRegex [0]] = $mixRegex [1];
        }
    }
    
    /**
     * 注册域名
     *
     * @param string $strDomain            
     * @param string $strUrl            
     * @param array $in
     *            params 扩展参数
     *            prepend 插入顺序
     * @return void
     */
    static public function domain($strDomain, $strUrl, $in = []) {
        $in = array_merge ( [ 
                'prepend' => false,
                'params' => [ ] 
        ], self::$arrGroupArgs, $in );
        
        // 闭包直接转接到分组
        if ($strUrl instanceof \Collator) {
            self::group ( [ 
                    'domain' => $strDomain 
            ], $strUrl );
        }         

        // 注册域名
        else {
            $arrDomain = [ 
                    'url' => $strUrl,
                    'params' => $in ['params'],
                    'domain' => $strDomain 
            ];
            
            if (! isset ( self::$arrDomains [$strDomain] )) {
                self::$arrDomains [$strDomain] = [ ];
            }
            
            // 优先插入
            if ($in ['prepend'] === true) {
                array_unshift ( self::$arrDomains [$strDomain], $arrDomain );
            } else {
                array_push ( self::$arrDomains [$strDomain], $arrDomain );
            }
        }
    }
    
    /**
     * 注册分组路由
     *
     * @param array $in
     *            prefix 前缀
     *            domain 域名
     *            params 参数
     *            where 参数正则
     *            prepend 插入顺序
     * @param mixed $mixRouter            
     * @return void
     */
    static function group($in, $mixRouter) {
        $strPrefix = isset ( $in ['prefix'] ) ? $in ['prefix'] : '';
        
        // 分组参数叠加
        self::$arrGroupArgs = array_merge ( self::$arrGroupArgs, $in );
        
        if ($mixRouter instanceof \Closure) {
            // var_dump($in);
            call_user_func_array ( $mixRouter, [ ] );
        } else {
            foreach ( $mixRouter as $arrVal ) {
                self::import ( $strPrefix . $arrVal [0], $arrVal [1], array_merge ( $in, $arrVal [2] ) );
            }
        }
        
        self::$arrGroupArgs = [ ];
    }
    public function __construct($oUrlParseObj = null) {
        if (! $GLOBALS ['_commonConfig_'] ['START_ROUTER']) {
            return false;
        }
        
        if (is_null ( $oUrlParseObj )) {
            $this->_oUrlParseObj = new Url ();
        } else {
            $this->_oUrlParseObj = $oUrlParseObj;
        }
    }
    public function G($sRouterName = null) {
        $sRouterName = $sRouterName ? $sRouterName : $this->getRouterName ();
        
        $arrRouteInfo = array ();
        if (! empty ( $this->_arrRouters )) {
            if (isset ( $this->_arrRouters [$sRouterName] )) {
                if (! strpos ( $sRouterName, '@' )) {
                    $arrRouteInfo = $this->getNormalRoute ( $sRouterName, $this->_arrRouters [$sRouterName] );
                } else {
                    $arrRouteInfo = $this->getFlowRoute ( $sRouterName, $this->_arrRouters [$sRouterName] );
                }
            } else {
                $sRegx = trim ( $_SERVER ['PATH_INFO'], '/' );
                foreach ( $this->_arrRouters as $sKey => $sRouter ) {
                    if (0 === strpos ( $sKey, '/' ) && preg_match ( $sKey, $sRegx, $arrMatches )) {
                        $arrRouteInfo = $this->getRegexRoute ( $arrMatches, $sRouter, $sRegx );
                        break;
                    }
                }
            }
        }
        
        $this->_arrRouteInfo = $arrRouteInfo;
        return $this->_arrRouteInfo;
    }
    public function import(array $arrRouters = null) {
        if (! $GLOBALS ['_commonConfig_'] ['START_ROUTER']) {
            return false;
        }
        
        if (is_null ( $arrRouters )) {
            $arrRouters = $GLOBALS ['_commonConfig_'] ['_ROUTER_'];
        }
        
        $this->_arrRouters = array_merge ( $this->_arrRouters, $arrRouters );
        return $this;
    }
    public function add($sRouteName, array $arrRule) {
        $this->_arrRouters [$sRouteName] = $arrRule;
        return $this;
    }
    public function remove($sRouteName) {
        unset ( $this->_arrRouters [$sRouteName] );
        return $this;
    }
    public function get($sRouteName) {
        return $this->_arrRouters [$sRouteName];
    }
    public function getLastRouterName() {
        return $this->_sLastRouterName;
    }
    public function getLastRouterInfo() {
        return $this->_arrLastRouteInfo;
    }
    private function parseUrl($Route) {
        if (is_string ( $Route )) {
            $arrArray = array_filter ( explode ( '/', $Route ) );
        } else {
            $arrArray = $Route;
        }
        
        if (count ( $arrArray ) !== 2) {
            Q::E ( '$Route parameter format error,claiming the $arrArray the number of elements equal 2.' );
        }
        
        $arrVar = array ();
        $arrVar ['a'] = array_pop ( $arrArray );
        $arrVar ['c'] = array_pop ( $arrArray );
        
        return $arrVar;
    }
    private function getRouterName() {
        if (isset ( $_GET ['r'] )) {
            $sRouteName = $_GET ['r'];
            unset ( $_GET ['r'] );
        } else {
            $sPathInfo = &$_SERVER ['PATH_INFO'];
            $arrPaths = explode ( $GLOBALS ['_commonConfig_'] ['URL_PATHINFO_DEPR'], trim ( $sPathInfo, '/' ) );
            
            if (isset ( $arrPaths [0] ) && $arrPaths [0] == 'app') {
                array_shift ( $arrPaths );
                $_GET ['app'] = array_shift ( $arrPaths );
            }
            
            $sRouteName = array_shift ( $arrPaths );
        }
        
        $sRouteName = strtolower ( $sRouteName );
        if (isset ( $this->_arrRouters [$sRouteName . '@'] )) {
            $sRouteName = $sRouteName . '@';
        }
        $this->_sLastRouterName = $sRouteName;
        return $this->_sLastRouterName;
    }
    private function getNormalRoute($sRouteName, array $arrRule) {
        if (isset ( $arrRule ['regex'] )) {
            return $this->getRegexRoute_ ( $sRouteName, $arrRule );
        } else {
            return $this->getSimpleRoute_ ( $sRouteName, $arrRule );
        }
    }
    private function getFlowRoute($sRouteName, array $arrRule) {
        foreach ( $arrRule as $arrRule ) {
            $arrVar = $this->getNormalRoute ( $sRouteName, $arrRule );
            if (! empty ( $arrVar )) {
                return $arrVar;
            }
        }
        
        return array ();
    }
    private function getSimpleRoute_($sRouteName, $arrRule) {
        if (count ( $arrRule ) < 2 || count ( $arrRule ) > 5) {
            Q::E ( '$arrRule parameter must be greater than or equal 2,less than or equal 5.' );
        }
        
        $arrVar = $this->parseUrl ( $arrRule [0] );
        if ($GLOBALS ['_commonConfig_'] ['URL_MODEL'] === URL_COMMON) {
            return $arrVar;
        }
        
        $sPathInfo = &$_SERVER ['PATH_INFO'];
        $sDepr = $GLOBALS ['_commonConfig_'] ['URL_PATHINFO_DEPR'];
        $sRegx = str_replace ( '/', $sDepr, rtrim ( $sPathInfo, '/' ) );
        $arrPaths = array_filter ( explode ( $sDepr, trim ( str_ireplace ( $sDepr . strtolower ( $sRouteName ) . $sDepr, $sDepr, $sRegx ), $sDepr ) ) );
        if (isset ( $arrPaths [0] ) && $arrPaths [0] == 'app') {
            array_shift ( $arrPaths );
            $arrVar ['app'] = array_shift ( $arrPaths );
        }
        
        if (! empty ( $arrRule [1] ) && in_array ( $arrRule [1], $arrPaths )) {
            foreach ( $arrPaths as $nKey => $sValue ) {
                if ($sValue == $arrRule [1]) {
                    unset ( $arrPaths [$nKey] );
                }
            }
        }
        
        $arrVars = explode ( ',', $arrRule [1] );
        for($nI = 0; $nI < count ( $arrVars ); $nI ++) {
            $arrVar [$arrVars [$nI]] = array_shift ( $arrPaths );
        }
        
        $this->_arrVar = $arrVar;
        preg_replace_callback ( '@(\w+)\/([^,\/]+)@', function ($arrMatches) {
            $this->_arrVar [$arrMatches [1]] = $arrMatches [2];
        }, implode ( '/', $arrPaths ) );
        $arrVar = $this->_arrVar;
        
        $arrParams = array ();
        if (isset ( $arrRule [2] )) {
            parse_str ( $arrRule [2], $arrParams );
            $arrVar = array_merge ( $arrVar, $arrParams );
        }
        
        return $arrVar;
    }
    private function getRegexRoute_($sRouteName, $arrRule) {
        if (count ( $arrRule ) < 3 || count ( $arrRule ) > 6) {
            Q::E ( '$arrRule parameter must be greater than or equal 3, less than or equal 6.' );
        }
        
        $sPathInfo = &$_SERVER ['PATH_INFO'];
        $sDepr = $GLOBALS ['_commonConfig_'] ['URL_PATHINFO_DEPR'];
        $sRegx = trim ( $sPathInfo, '/' );
        $sRegx = explode ( $sDepr, $sRegx );
        if ($sRegx [0] == 'app') {
            array_shift ( $sRegx );
            $_GET ['app'] = array_shift ( $sRegx );
        }
        $sRegx = implode ( $sDepr, $sRegx );
        $sRegx = ltrim ( $sRegx, strtolower ( rtrim ( $sRouteName, '@' ) ) );
        $sTheRegex = array_shift ( $arrRule );
        $arrMatches = array ();
        if (preg_match ( $sTheRegex, $sRegx, $arrMatches )) {
            $arrVar = $this->parseUrl ( $arrRule [0] );
            if ($GLOBALS ['_commonConfig_'] ['URL_MODEL'] === URL_COMMON) {
                return $arrVar;
            }
            
            $arrVars = explode ( ',', $arrRule [1] );
            for($nI = 0; $nI < count ( $arrVars ); $nI ++) {
                $arrVar [$arrVars [$nI]] = $arrMatches [$nI + 1];
            }
            
            $this->_arrVar = $arrVar;
            preg_replace_callback ( '@(\w+)\/([^,\/]+)@', function ($arrMatches) {
                $this->_arrVar [$arrMatches [1]] = $arrMatches [2];
            }, trim ( str_replace ( $arrMatches [0], '', $sRegx ), '\/' ) );
            $arrVar = $this->_arrVar;
            
            $arrParams = array ();
            if (isset ( $arrRule [2] )) {
                parse_str ( $arrRule [2], $arrParams );
                $arrVar = array_merge ( $arrVar, $arrParams );
            }
            return $arrVar;
        }
        
        return array ();
    }
    
    /**
     * 全局解析规则 TP
     */
    private function getRegexRoute($arrMatches, $sRouter, $sRegx) {
        $sUrl = is_array ( $sRouter ) ? $sRouter [0] : $sRouter;
        $this->_arrMatches = $arrMatches;
        $sUrl = preg_replace_callback ( '/:(\d+)/', function ($arrMatches) {
            return $this->_arrMatches [$arrMatches [1]];
        }, $sUrl );
        if (0 === strpos ( $sUrl, '/' ) || 0 === strpos ( $sUrl, 'http' )) {
            header ( "Location:{$sUrl}", true, is_array ( $sRouter ) && ! empty ( $sRouter [1] ) ? $sRouter [1] : 301 );
            exit ();
        } else {
            $arrVar = array ();
            if (false !== strpos ( $sUrl, '?' )) {
                $arrInfo = parse_url ( $sUrl );
                $arrPath = explode ( '/', $arrInfo ['path'] );
                parse_str ( $arrInfo ['query'], $arrVar );
            } elseif (strpos ( $sUrl, '/' )) {
                $arrPath = explode ( '/', $sUrl );
            } else {
                parse_str ( $sUrl, $arrVar );
            }
            
            if (isset ( $arrPath )) {
                $arrVar ['a'] = array_pop ( $arrPath );
                if (! empty ( $arrPath )) {
                    $arrVar ['c'] = array_pop ( $arrPath );
                }
                if (! empty ( $arrPath )) {
                    $var ['app'] = array_pop ( $arrPath );
                }
            }
            
            $sRegx = substr_replace ( $sRegx, '', 0, strlen ( $arrMatches [0] ) );
            if ($sRegx) {
                $this->_arrVar = $arrVar;
                preg_replace_callback ( '@(\w+)\/([^,\/]+)@', function ($arrMatches) {
                    $this->_arrVar [strtolower ( $arrMatches [1] )] = strip_tags ( $arrMatches [2] );
                }, $sRegx );
                $arrVar = $this->_arrVar;
            }
            
            if (is_array ( $sRouter ) && ! empty ( $sRouter [1] )) {
                parse_str ( $sRouter [1], $arrParams );
                $arrVar = array_merge ( $arrVar, $arrParams );
            }
        }
        
        return $arrVar;
    }
}
