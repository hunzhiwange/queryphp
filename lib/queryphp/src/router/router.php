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
     * @return void
     */
    static function import($mixRouter, $strUrl, $in = []) {
        // 默认参数
        $in = array_merge ( [ 
                'prepend' => false,
                'where' => [ ],
                'params' => [ ],
                'domain' => '' 
        ], self::$arrGroupArgs, $in );
        
        // 支持数组传入
        if (! is_array ( $mixRouter )) {
            $strTemp = $mixRouter;
            $mixRouter = [ ];
            $mixRouter [] = [ 
                    $strTemp,
                    $strUrl,
                    $in 
            ];
        } else {
            foreach ( $mixRouter as &$arrRouter ) {
                if (count ( $arrRouter ) < 2) {
                    continue;
                }
                if (! isset ( $arrRouter [2] )) {
                    $arrRouter [2] = [ ];
                }
                if (! $arrRouter [1]) {
                    $arrRouter [1] = $strUrl;
                }
                $arrRouter [2] = array_merge ( $arrRouter [2], $in );
            }
        }
        
        foreach ( $mixRouter as $arrArgs ) {
            if (! isset ( $arrArgs [1] )) {
                continue;
            }
            
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
                if (is_string ( key ( $arrArgs [2] ['where'] ) )) {
                    $arrRouter ['where'] = array_merge ( $arrRouter ['where'], $arrArgs [2] ['where'] );
                } else {
                    $arrRouter ['where'] [$arrArgs [2] ['where'] [0]] = $arrArgs [2] ['where'] [1];
                }
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
            call_user_func_array ( $mixRouter, [ ] );
        } else {
            foreach ( $mixRouter as $arrVal ) {
                self::import ( $strPrefix . $arrVal [0], $arrVal [1], array_merge ( $in, $arrVal [2] ) );
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
    static public function cache($arrData = []) {
        if ($arrData) {
            self::import ( $arrData, '' );
        }
    }
    
    /**
     * 返回文件路由配置
     *
     * @return string
     */
    static public function getFileRouters() {
        return self::$arrFileRouters;
    }
    
    /**
     * 设置文件路由配置
     *
     * @param array $arrData            
     * @return void
     */
    static public function setFileRouters($arrData = []) {
        self::$arrFileRouters = $arrData;
    }
    
    /**
     * 获取绑定资源
     * 
     * @param string $sBindName
     * @return mixed
     */
    static public function getBind($sBindName) {
        return isset ( self::$arrBinds[$sBindName] ) ? self::$arrBinds[$sBindName] : null;
    }
    
    /**
     * 判断是否绑定资源
     * 
     * @param string $sBindName
     * @return boolean
     */
    static public function hasBind($sBindName) {
        return isset ( self::$arrBinds[$sBindName] ) ? true : false;
    }
    
    /**
     * 注册绑定资源
     * 
     * [
     *  注册控制器：router::bind( 'group://topic', $mixBind )
     *  注册方法：router::bind( 'group://topic/index', $mixBind )
     * ]
     * 
     * @param string $sBindName
     * @param mixed $mixBind
     * @return void
     */
    static public function bind($sBindName, $mixBind) {
        self::$arrBinds[$sBindName] = $mixBind;
    }

    /**
     * 匹配路由
     */
    public static function parse() {
        // 解析域名
        
        // 解析路由
        return self::parseRouter ();
    }
    
    /**
     * 解析路由规格
     *
     * @return array
     */
    private static function parseRouter() {
        $arrData = [ ];
        $sPathinfo = $_SERVER ['PATH_INFO'];
        
        // 匹配路由
        foreach ( self::$arrRouters as $sKey => $arrRouters ) {
            foreach ( $arrRouters as $arrRouter ) {
                
                $booFindFouter = false;
                if (strpos ( $arrRouter ['regex'], '{' ) !== false && preg_match_all ( "/{(.+?)}/isx", $arrRouter ['regex'], $arrRes )) {
                    // 解析匹配正则
                    $arrRouter ['regex'] = self::formatRegex_ ( $arrRouter ['regex'] );
                    foreach ( $arrRes [1] as $nIndex => $sWhere ) {
                        $arrRouter ['regex'] = str_replace ( '{' . $sWhere . '}', '(' . (isset ( $arrRouter ['where'] [$sWhere] ) ? $arrRouter ['where'] [$sWhere] : self::DEFAULT_REGEX) . ')', $arrRouter ['regex'] );
                    }
                    $arrRouter ['regex'] = '/^\/' . $arrRouter ['regex'] . ((isset ( $arrRouter ['strict'] ) ? $arrRouter ['strict'] : $GLOBALS ['option'] ['url_router_strict']) ? '$' : '') . '/';
                    $arrRouter ['args'] = $arrRes [1];
                    
                    // 匹配结果
                    if (preg_match ( $arrRouter ['regex'], $sPathinfo, $arrRes )) {
                        $booFindFouter = true;
                    }
                } else if ($arrRouter ['regex'] == $sPathinfo) {
                    $booFindFouter = true;
                }
                
                if ($booFindFouter === true) {
                    $arrData = Q::parseMvcUrl ( $arrRouter ['url'] );
                    
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
        
        return $arrData;
    }
    
    /**
     * 格式化正则
     *
     * @param string $sRegex            
     * @return string
     */
    private static function formatRegex_($sRegex) {
        return str_replace ( '/', '\/', $sRegex );
    }
}
