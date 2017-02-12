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
namespace Q\router;

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
     * 域名正则
     *
     * @var array
     */
    private static $arrDomainWheres = [ ];
    
    /**
     * 默认替换参数[字符串]
     *
     * @var string
     */
    const DEFAULT_REGEX = '\S+';
    
    /**
     * 分组传递参数
     *
     * @var array
     */
    private static $arrGroupArgs = [ ];
    
    /**
     * 配置文件路由
     *
     * @var string
     */
    private static $arrFileRouters = [ ];
    
    /**
     * 路由绑定资源
     *
     * @var string
     */
    private static $arrBinds = [ ];
    
    /**
     * 域名匹配数据
     *
     * @var array
     */
    private static $arrDomainData = [ ];
    
    /**
     * 导入路由规则
     *
     * @param mixed $mixRouter            
     * @param string $strUrl            
     * @param arra $in
     *            domain 域名
     *            params 参数
     *            where 参数正则
     *            prepend 插入顺序
     *            strict 严格模式，启用将在匹配正则 $
     *            prefix 前缀
     * @return void
     */
    static function import($mixRouter, $strUrl = '', $in = []) {
        // 默认参数
        $in = self::mergeIn_ ( [ 
                'prepend' => false,
                'where' => [ ],
                'params' => [ ],
                'domain' => '',
                'prefix' => '' 
        ], self::mergeIn_ ( self::$arrGroupArgs, $in ) );
        
        // 支持数组传入
        if (! is_array ( $mixRouter ) || \Q::oneImensionArray ( $mixRouter )) {
            $strTemp = $mixRouter;
            $mixRouter = [ ];
            if (is_string ( $strTemp )) {
                $mixRouter [] = [ 
                        $strTemp,
                        $strUrl,
                        $in 
                ];
            } else {
                if ($strUrl || $strTemp [1]) {
                    $mixRouter [] = [ 
                            $strTemp [0],
                            (! empty ( $strTemp [1] ) ? $strTemp [1] : $strUrl),
                            $in 
                    ];
                }
            }
        } else {
            foreach ( $mixRouter as $intKey => $arrRouter ) {
                if (! is_array ( $arrRouter ) || count ( $arrRouter ) < 2) {
                    continue;
                }
                if (! isset ( $arrRouter [2] )) {
                    $arrRouter [2] = [ ];
                }
                if (! $arrRouter [1]) {
                    $arrRouter [1] = $strUrl;
                }
                $arrRouter [2] = self::mergeIn_ ( $in, $arrRouter [2] );
                $mixRouter [$intKey] = $arrRouter;
            }
        }
        
        foreach ( $mixRouter as $arrArgs ) {
            $strPrefix = ! empty ( $arrArgs [2] ['prefix'] ) ? $arrArgs [2] ['prefix'] : '';
            $arrArgs [0] = $strPrefix . $arrArgs [0];
            
            $arrRouter = [ 
                    'url' => $arrArgs [1],
                    'regex' => $arrArgs [0],
                    'params' => $arrArgs [2] ['params'],
                    'where' => self::$arrWheres,
                    'domain' => $arrArgs [2] ['domain'] 
            ];
            
            if (isset ( $arrArgs [2] ['strict'] )) {
                $arrRouter ['strict'] = $arrArgs [2] ['strict'];
            }
            
            // 合并参数正则
            if (! empty ( $arrArgs [2] ['where'] ) && is_array ( $arrArgs [2] ['where'] )) {
                $arrRouter ['where'] = self::mergeWhere_ ( $arrRouter ['where'], $arrArgs [2] ['where'] );
            }
            
            if (! isset ( self::$arrRouters [$arrArgs [0]] )) {
                self::$arrRouters [$arrArgs [0]] = [ ];
            }
            
            // 优先插入
            if ($arrArgs [2] ['prepend'] === true) {
                array_unshift ( self::$arrRouters [$arrArgs [0]], $arrRouter );
            } else {
                array_push ( self::$arrRouters [$arrArgs [0]], $arrRouter );
            }
            
            // 域名支持
            if (! empty ( $arrRouter ['domain'] )) {
                $in ['router'] = true;
                self::domain ( $arrRouter ['domain'], $arrArgs [0], $in );
            }
        }
    }
    
    /**
     * 注册全局参数正则
     *
     * @param mixed $mixRegex            
     * @param string $strValue            
     * @return void
     */
    static public function regex($mixRegex, $strValue = '') {
        if (is_string ( $mixRegex )) {
            self::$arrWheres [$mixRegex] = $strValue;
        } else {
            self::$arrWheres = self::mergeWhere_ ( self::$arrWheres, $mixRegex );
        }
    }
    
    /**
     * 注册全局域名参数正则
     *
     * @param mixed $mixRegex            
     * @param string $strValue            
     * @return void
     */
    static public function regexDomain($mixRegex, $strValue = '') {
        if (is_string ( $mixRegex )) {
            self::$arrDomainWheres [$mixRegex] = $strValue;
        } else {
            self::$arrDomainWheres = self::mergeWhere_ ( self::$arrDomainWheres, $mixRegex );
        }
    }
    
    /**
     * 注册域名
     *
     * @param string $strDomain            
     * @param mixed $mixUrl            
     * @param array $in
     *            params 扩展参数
     *            domain_where 域名参数
     *            prepend 插入顺序
     *            router 对应路由规则
     * @return void
     */
    static public function domain($strDomain, $mixUrl, $in = []) {
        $in = self::mergeIn_ ( [ 
                'prepend' => false,
                'params' => [ ],
                'domain_where' => [ ],
                'router' => false 
        ], $in );
        
        // 闭包直接转接到分组
        if ($mixUrl instanceof \Closure) {
            $in ['domain'] = $strDomain;
            self::group ( $in, $mixUrl );
        }         

        // 注册域名
        else {
            $arrDomain = [ 
                    'url' => $mixUrl,
                    'params' => $in ['params'],
                    'router' => $in ['router'] 
            ];
            
            // 合并参数正则
            $arrDomainWheres = self::$arrDomainWheres;
            if (! empty ( $in ['domain_where'] ) && is_array ( $in ['domain_where'] )) {
                $arrDomainWheres = self::mergeWhere_ ( $in ['domain_where'], $arrDomainWheres );
            }
            
            // 主域名只有一个，路由可以有多个
            $strDomainBox = $arrDomain ['router'] === false ? 'main' : 'rule';
            if (! isset ( self::$arrDomains [$strDomain] )) {
                self::$arrDomains [$strDomain] = [ ];
            }
            self::$arrDomains [$strDomain] ['domain_where'] = $arrDomainWheres;
            if (! isset ( self::$arrDomains [$strDomain] [$strDomainBox] )) {
                self::$arrDomains [$strDomain] [$strDomainBox] = [ ];
            }
            
            // 纯域名绑定只支持一个，可以被覆盖
            if ($arrDomain ['router'] === false) {
                self::$arrDomains [$strDomain] [$strDomainBox] = $arrDomain;
            } else {
                // 优先插入
                if ($in ['prepend'] === true) {
                    array_unshift ( self::$arrDomains [$strDomain] [$strDomainBox], $arrDomain );
                } else {
                    array_push ( self::$arrDomains [$strDomain] [$strDomainBox], $arrDomain );
                }
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
     *            strict 严格模式，启用将在匹配正则 $
     * @param mixed $mixRouter            
     * @return void
     */
    static function group(array $in, $mixRouter) {
        // 分组参数叠加
        self::$arrGroupArgs = $in = self::mergeIn_ ( self::$arrGroupArgs, $in );
        
        if ($mixRouter instanceof \Closure) {
            call_user_func_array ( $mixRouter, [ ] );
        } else {
            if (! is_array ( current ( $mixRouter ) )) {
                $arrTemp = $mixRouter;
                $mixRouter = [ ];
                $mixRouter [] = $arrTemp;
            }
            
            foreach ( $mixRouter as $arrVal ) {
                if (! is_array ( $arrVal ) || count ( $arrVal ) < 2) {
                    continue;
                }
                
                if (! isset ( $arrVal [2] )) {
                    $arrVal [2] = [ ];
                }
                
                self::import ( $strPrefix . $arrVal [0], $arrVal [1], self::mergeIn_ ( $in, $arrVal [2] ) );
            }
        }
        
        self::$arrGroupArgs = [ ];
    }
    
    /**
     * 导入路由配置数据
     *
     * @param array $arrData
     *            @retun void
     */
    static public function cache($arrData) {
        if (isset ( $arrData ['~domains~'] )) {
            foreach ( $arrData ['~domains~'] as $arrVal ) {
                if (is_array ( $arrVal ) && isset ( $arrVal [1] )) {
                    empty ( $arrVal [2] ) && $arrVal [2] = [ ];
                    self::domain ( $arrVal [0], $arrVal [1], $arrVal [2] );
                }
            }
            unset ( $arrData ['~domains~'] );
        }
        
        if ($arrData) {
            self::import ( $arrData );
        }
    }
    
    /**
     * 获取绑定资源
     *
     * @param string $sBindName            
     * @return mixed
     */
    static public function getBind($sBindName) {
        return isset ( self::$arrBinds [$sBindName] ) ? self::$arrBinds [$sBindName] : null;
    }
    
    /**
     * 判断是否绑定资源
     *
     * @param string $sBindName            
     * @return boolean
     */
    static public function hasBind($sBindName) {
        return isset ( self::$arrBinds [$sBindName] ) ? true : false;
    }
    
    /**
     * 注册绑定资源
     *
     * 注册控制器：router::bind( 'group://topic', $mixBind )
     * 注册方法：router::bind( 'group://topic/index', $mixBind )
     *
     * @param string $sBindName            
     * @param mixed $mixBind            
     * @return void
     */
    static public function bind($sBindName, $mixBind) {
        self::$arrBinds [$sBindName] = $mixBind;
    }
    
    /**
     * 匹配路由
     */
    public static function parse() {
        $arrNextParse = [ ];
        
        // 解析域名
        if ($GLOBALS ['~@option'] ['url_router_domain_on'] === true) {
            if (($arrParseData = self::parseDomain_ ( $arrNextParse )) !== false) {
                return $arrParseData;
            }
        }
        
        // 解析路由
        $arrNextParse = $arrNextParse ? array_column ( $arrNextParse, 'url' ) : [ ];
        return self::parseRouter_ ( $arrNextParse );
    }
    
    /**
     * 解析域名路由
     *
     * @param array $arrNextParse            
     * @return void
     */
    private static function parseDomain_(&$arrNextParse) {
        $strHost = \Q::getHost ();
        
        $booFindDomain = false;
        foreach ( self::$arrDomains as $sKey => $arrDomains ) {
            
            // 直接匹配成功
            if ($strHost === $sKey || $strHost === $sKey . '.' . $GLOBALS ['~@option'] ['url_router_domain_top']) {
                $booFindDomain = true;
            }            

            // 域名参数支持
            elseif (strpos ( $sKey, '{' ) !== false) {
                if (strpos ( $sKey, $GLOBALS ['~@option'] ['url_router_domain_top'] ) === false) {
                    $sKey = $sKey . '.' . $GLOBALS ['~@option'] ['url_router_domain_top'];
                }
                
                // 解析匹配正则
                $sKey = self::formatRegex_ ( $sKey );
                $sKey = preg_replace_callback ( "/{(.+?)}/", function ($arrMatches) use(&$arrDomains) {
                    $arrDomains ['args'] [] = $arrMatches [1];
                    return '(' . (isset ( $arrDomains ['domain_where'] [$arrMatches [1]] ) ? $arrDomains ['domain_where'] [$arrMatches [1]] : self::DEFAULT_REGEX) . ')';
                }, $sKey );
                $sKey = '/^' . $sKey . '$/';
                
                // 匹配结果
                if (preg_match ( $sKey, $strHost, $arrRes )) {
                    // 变量解析
                    if (isset ( $arrDomains ['args'] )) {
                        array_shift ( $arrRes );
                        foreach ( $arrDomains ['args'] as $intArgsKey => $strArgs ) {
                            self::$arrDomainData [$strArgs] = $arrRes [$intArgsKey];
                        }
                    }
                    
                    $booFindDomain = true;
                }
            }
            
            // 分析结果
            if ($booFindDomain === true) {
                if (isset ( $arrDomains ['rule'] )) {
                    $arrNextParse = $arrDomains ['rule'];
                    return false;
                } else {
                    $arrData = \Q::parseMvcUrl ( $arrDomains ['main'] ['url'] );
                    
                    // 额外参数[放入 GET]
                    if (is_array ( $arrDomains ['main'] ['params'] ) && $arrDomains ['main'] ['params']) {
                        $arrData = array_merge ( $arrData, $arrDomains ['main'] ['params'] );
                    }
                    
                    // 合并域名匹配数据
                    $arrData = array_merge ( self::$arrDomainData, $arrData );
                    
                    return $arrData;
                }
            }
        }
    }
    
    /**
     * 解析路由规格
     *
     * @param array $arrNextParse            
     * @return array
     */
    private static function parseRouter_($arrNextParse = []) {
        $arrData = [ ];
        $sPathinfo = $_SERVER ['PATH_INFO'];
        
        // 匹配路由
        foreach ( self::$arrRouters as $sKey => $arrRouters ) {
            // 域名过掉无关路由
            if ($arrNextParse && ! in_array ( $sKey, $arrNextParse )) {
                continue;
            }
            
            foreach ( $arrRouters as $arrRouter ) {
                // 尝试匹配
                $booFindFouter = false;
                if ($arrRouter ['regex'] == $sPathinfo) {
                    $booFindFouter = true;
                } else {
                    // 解析匹配正则
                    $arrRouter ['regex'] = self::formatRegex_ ( $arrRouter ['regex'] );
                    $arrRouter ['regex'] = preg_replace_callback ( "/{(.+?)}/", function ($arrMatches) use(&$arrRouter) {
                        $arrRouter ['args'] [] = $arrMatches [1];
                        return '(' . (isset ( $arrRouter ['where'] [$arrMatches [1]] ) ? $arrRouter ['where'] [$arrMatches [1]] : self::DEFAULT_REGEX) . ')';
                    }, $arrRouter ['regex'] );
                    $arrRouter ['regex'] = '/^\/' . $arrRouter ['regex'] . ((isset ( $arrRouter ['strict'] ) ? $arrRouter ['strict'] : $GLOBALS ['~@option'] ['url_router_strict']) ? '$' : '') . '/';
                    
                    // 匹配结果
                    if (preg_match ( $arrRouter ['regex'], $sPathinfo, $arrRes )) {
                        $booFindFouter = true;
                    }
                }
                
                // 分析结果
                if ($booFindFouter === true) {
                    $arrData = \Q::parseMvcUrl ( $arrRouter ['url'] );
                    
                    // 额外参数
                    if (is_array ( $arrRouter ['params'] ) && $arrRouter ['params']) {
                        $arrData = array_merge ( $arrData, $arrRouter ['params'] );
                    }
                    
                    // 变量解析
                    if (isset ( $arrRouter ['args'] )) {
                        array_shift ( $arrRes );
                        foreach ( $arrRouter ['args'] as $intArgsKey => $strArgs ) {
                            $arrData [$strArgs] = $arrRes [$intArgsKey];
                        }
                    }
                    break 2;
                }
            }
        }
        
        // 合并域名匹配数据
        $arrData = array_merge ( self::$arrDomainData, $arrData );
        
        return $arrData;
    }
    
    /**
     * 格式化正则
     *
     * @param string $sRegex            
     * @return string
     */
    private static function formatRegex_($sRegex) {
        $sRegex = \Q::escapeRegexCharacter ( $sRegex );
        
        // 还原变量特殊标记
        return str_replace ( [ 
                '\{',
                '\}' 
        ], [ 
                '{',
                '}' 
        ], $sRegex );
    }
    
    /**
     * 合并 in 参数
     *
     * @param array $in            
     * @param array $arrExtend            
     * @return array
     */
    private static function mergeIn_(array $in, array $arrExtend) {
        // 合并特殊参数
        foreach ( [ 
                'params',
                'where',
                'domain_where' 
        ] as $strType ) {
            if (! empty ( $arrExtend [$strType] ) && is_array ( $arrExtend [$strType] )) {
                if (! isset ( $in [$strType] )) {
                    $in [$strType] = [ ];
                }
                $in [$strType] = self::mergeWhere_ ( $in [$strType], $arrExtend [$strType] );
            }
        }
        
        // 合并额外参数
        foreach ( [ 
                'prefix',
                'domain',
                'prepend',
                'strict',
                'router' 
        ] as $strType ) {
            if (isset ( $arrExtend [$strType] )) {
                $in [$strType] = $arrExtend [$strType];
            }
        }
        
        return $in;
    }
    
    /**
     * 合并 where 正则参数
     *
     * @param array $arrWhere            
     * @param array $arrExtend            
     * @return array
     */
    private static function mergeWhere_(array $arrWhere, array $arrExtend) {
        // 合并参数正则
        if (! empty ( $arrExtend ) && is_array ( $arrExtend )) {
            if (is_string ( key ( $arrExtend ) )) {
                $arrWhere = array_merge ( $arrWhere, $arrExtend );
            } else {
                $arrWhere [$arrExtend [0]] = $arrExtend [1];
            }
        }
        
        return $arrWhere;
    }
}
