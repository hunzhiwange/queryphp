<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\mvc;

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

use queryyetsimple\view\theme;
use queryyetsimple\database\database;
use queryyetsimple\filesystem\directory;
use queryyetsimple\filesystem\file;
use queryyetsimple\http\request;
use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;
use queryyetsimple\cookie\cookie;

/**
 * 视图
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
class view {
    
    use dynamic_expansion;
    
    /**
     * 当前主题目录
     *
     * @var string
     */
    private static $sTheme;
    
    /**
     * 模板主题目录
     *
     * @var string
     */
    private static $sThemeDefault;

    /**
     * 主题参数名
     *
     * @var string
     */
    const ARGS = '~@theme';
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [ 
            'view\cache_children' => false,
            'view\moduleaction_depr' => '_',
            'view\suffix' => '.html',
            'view\switch' => true,
            'view\default'=>'default',
            'view\cookie_app'=>false
    ];
    
    /**
     * 创建视图
     *         
     * @return void
     */
    public function __construct() {
    }
    
    /**
     * 变量赋值
     *
     * @param mixed $mixName            
     * @param mixed $mixValue            
     * @return mixed
     */
    public function assign($mixName, $mixValue = null) {
        return theme::setVars ( $mixName, $mixValue );
    }
    
    /**
     * 获取变量赋值
     *
     * @param string $sName            
     * @return mixed
     */
    public function getAssign($sName) {
        return theme::getVars ( $sName );
    }
    
    /**
     * 加载视图文件
     *
     * @param string $sFile            
     * @param array $in
     *            charset 编码
     *            content_type 内容类型
     *            return 是否返回
     * @return void|string
     */
    public function display($sFile = '', $in = []) {
        $in = array_merge ( [ 
                'charset' => 'utf-8',
                'content_type' => 'text/html',
                'return' => false 
        ], $in );
        
        // 设置 header
        if (! headers_sent ()) {
            header ( "Content-Type:" . $in ['content_type'] . "; charset=" . $in ['charset'] );
            header ( "Cache-control: private" ); // 支持页面回跳
        }
        
        // 加载视图文件
        if (! is_file ( $sFile )) {
            $sFile = static::parseFile ( $sFile );
        }
        
        $sContent = theme::displays ( $sFile, false );
        
        // 过滤编译文件子模板定位注释标签，防止在网页头部出现注释，导致 IE 浏览器不居中
        if (Q_DEBUG === true && $this->getExpansionInstanceArgs_ ( 'view\cache_children' ) === true) {
            $sContent = preg_replace ( "/<!--<\#\#\#\#incl\*(.*?)\*ude\#\#\#\#>-->/", '', $sContent );
            $sContent = preg_replace ( "/<!--<\/\#\#\#\#incl\*(.*?)\*ude\#\#\#\#\/>-->/", '', $sContent );
        }
        
        // 返回
        if ($in ['return'] === true) {
            return $sContent;
        } else { // 直接输出
            echo $sContent;
            unset ( $sContent );
        }
    }
    
    /**
     * 自动分析视图上下文环境
     *
     * @return string
     */
    public function parseContext() {
        if (! $this->getExpansionInstanceArgs_ ('view\switch')) {
            $sThemeSet = $this->getExpansionInstanceArgs_ ('view\default');
        } else {
            if ($this->getExpansionInstanceArgs_ ('view\cookie_app') === true) {
                $sCookieName = static::$objProjectContainer->app_name . '_view';
            } else {
                $sCookieName = 'view';
            }
    
            if (isset ( $_GET [static::ARGS] )) {
                $sThemeSet = $_GET [static::ARGS];
                cookie::sets ( $sCookieName, $sThemeSet );
            } else {
                if (cookie::gets ( $sCookieName )) {
                    $sThemeSet = cookie::gets ( $sCookieName );
                } else {
                    $sThemeSet = $this->getExpansionInstanceArgs_ ('view\default');
                }
            }
        }
        return $sThemeSet;
    }
    
    
    /**
     * 设置主题目录
     *
     * @param string $sDir            
     * @return string
     */
    public static function setThemeDir($sDir) {
        return static::$sTheme = $sDir;
    }
    
    /**
     * 设置默认主题目录
     *
     * @param string $sDir            
     * @return string
     */
    public static function setThemeDefault($sDir) {
        return static::$sThemeDefault = $sDir;
    }
    
    /**
     * 分析模板真实路径
     *
     * @param string $sTpl
     *            文件地址
     * @param string $sExt
     *            扩展名
     * @return string
     */
    public function parseFile($sTpl, $sExt = '') {
        $calHelp = function ($sContent) {
            return str_replace ( [ 
                    ':',
                    '+' 
            ], [ 
                    '->',
                    '::' 
            ], $sContent );
        };
        
        $sTpl = trim ( str_replace ( '->', '.', $sTpl ) );
        
        // 完整路径 或者变量
        if (file::getExtName ( $sTpl ) || strpos ( $sTpl, '$' ) === 0) {
            return $calHelp ( $sTpl );
        } elseif (strpos ( $sTpl, '(' ) !== false) { // 存在表达式
            return $calHelp ( $sTpl );
        } else {
            // 空取默认控制器和方法
            if ($sTpl == '') {
                $sTpl = static::$objProjectContainer->controller_name . $this->getExpansionInstanceArgs_ ( 'view\moduleaction_depr' ) . static::$objProjectContainer->action_name;
            }
            
            if (strpos ( $sTpl, '@' )) { // 分析主题
                $arrArray = explode ( '@', $sTpl );
                $sTheme = array_shift ( $arrArray );
                $sTpl = array_shift ( $arrArray );
                unset ( $arrArray );
            }
            
            $sTpl = str_replace ( [ 
                    '+',
                    ':' 
            ], $this->getExpansionInstanceArgs_ ( 'view\moduleaction_depr' ), $sTpl );
            
            return static::$objProjectContainer->path_app_theme . '/' . (isset ( $sTheme ) ? $sTheme : static::$objProjectContainer->name_app_theme) . '/' . $sTpl . ($sExt ?  : $this->getExpansionInstanceArgs_ ( 'view\suffix' ));
        }
    }
    
    /**
     * 匹配默认地址（文件不存在）
     *
     * @param string $sTpl
     *            文件地址
     * @return string
     */
    public function parseDefaultFile($sTpl) {
        if (is_file ( $sTpl )) {
            return $sTpl;
        }
        
        $sBakTpl = $sTpl;
        
        // 物理路径
        if (strpos ( $sTpl, ':' ) !== false || strpos ( $sTpl, '/' ) === 0 || strpos ( $sTpl, '\\' ) === 0) {
            $sTpl = str_replace ( directory::tidypath ( static::$objProjectContainer->path_app_theme . '/' . static::$objProjectContainer->name_app_theme . '/' ), '', directory::tidypath ( $sTpl ) );
        }
        
        // 当前主题
        if (is_file ( static::$sTheme . '/' . $sTpl )) {
            return static::$sTheme . '/' . $sTpl;
        }
        
        // 备用地址
        if (static::$sThemeDefault && is_file ( static::$sThemeDefault . '/' . $sTpl )) {
            return static::$sThemeDefault . '/' . $sTpl;
        }
        
        // default 主题
        if (static::$objProjectContainer->name_app_theme != 'default' && is_file ( static::$objProjectContainer->path_app_theme . '/default/' . $sTpl )) {
            return static::$objProjectContainer->path_app_theme . '/default/' . $sTpl;
        }
        
        return $sBakTpl;
    }
}
