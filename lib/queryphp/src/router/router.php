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
                $strRegex = '/' . str_replace ( '/', '\/', $arrRouter ['regex'] ) . '/';
                
                // 匹配成功
                if (preg_match_all ( $strRegex, $sPathinfo, $arrRes )) {
                    $arrData = Q::parseMvcUrl ( $arrRouter ['url'] );
                    
                    // 额外参数
                    if (is_array ( $arrRouter ['params'] ) && $arrRouter ['params']) {
                        $arrData = array_merge ( $arrData, $arrRouter ['params'] );
                    }
                    
                    // 变量解析
                    foreach ( $arrRouter ['args'] as $intArgsKey => $strArgs ) {
                        $arrData [$strArgs] = $arrRes [1] [$intArgsKey];
                    }
                    
                    break;
                }
            }
        }
        
        return $arrData;
    }
}
