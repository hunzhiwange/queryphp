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
namespace Q\mvc;

use Q\view\theme;

/**
 * 视图
 *
 * @author Xiangmin Liu
 */
class view {
    
    /**
     * 视图管理
     *
     * @var object
     */
    private static $objView;
    
    /**
     * 主题管理器
     *
     * @var object
     */
    private $oTheme;
    
    /**
     * 共享主题管理器
     *
     * @var object
     */
    private static $oShareTheme;
    
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
     * 构造函数
     *
     * @param object $oTheme            
     * @return void
     */
    public function __construct($oTheme = null) {
        if ($oTheme) {
            $this->setTheme ( $oTheme );
        } else {
            $this->setTheme ( self::shareTheme () );
        }
    }
    
    /**
     * 返回视图实例
     *
     * @param object $oTheme            
     * @var Q\mvc\view
     */
    public static function run($oTheme = null) {
        if (! self::$objView) {
            self::$objView = new self ( $oTheme );
        }
        return self::$objView;
    }
    
    /**
     * 变量赋值
     *
     * @param mixed $mixName            
     * @param mixed $mixValue            
     * @return mixed
     */
    public function assign($mixName, $mixValue = null) {
        return $this->getTheme ()->setVar ( $mixName, $mixValue );
    }
    
    /**
     * 获取变量赋值
     *
     * @param string $sName            
     * @return mixed
     */
    public function getAssign($sName) {
        return $this->getTheme ()->getVar ( $sName );
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
            $sFile = self::parseFile ( $sFile );
        }
        $sContent = $this->getTheme ()->display ( $sFile, false );
        
        // 过滤编译文件子模板定位注释标签，防止在网页头部出现注释，导致 IE 浏览器不居中
        if (Q_DEBUG === TRUE && $GLOBALS ['~@option'] ['theme_cache_children'] === true) {
            $sContent = preg_replace ( "/<!--<\#\#\#\#incl\*(.*?)\*ude\#\#\#\#>-->/", '', $sContent );
            $sContent = preg_replace ( "/<!--<\/\#\#\#\#incl\*(.*?)\*ude\#\#\#\#\/>-->/", '', $sContent );
        }
        
        // 调试信息
        if (! \Q::isAjax ()) {
            if (Q_DEBUG === TRUE && $GLOBALS ['~@option'] ['show_page_trace']) {
                $sContent .= $this->trace ();
            }
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
     * 设置主题目录
     *
     * @param string $sDir            
     * @return string
     */
    static public function setThemeDir($sDir) {
        return self::$sTheme = $sDir;
    }
    
    /**
     * 设置默认主题目录
     *
     * @param string $sDir            
     * @return string
     */
    static public function setThemeDefault($sDir) {
        return self::$sThemeDefault = $sDir;
    }
    
    /**
     * 获取当前主题管理器
     *
     * @return object
     */
    public function getTheme() {
        if (is_null ( $this->oTheme )) {
            $this->oTheme = self::shareTheme ();
        }
        return $this->oTheme;
    }
    
    /**
     * 设置当期主题管理器
     *
     * @param object $oTheme            
     * @return 旧值
     */
    public function setTheme($oTheme) {
        $oOld = $this->oTheme;
        $this->oTheme = $oTheme;
        return $oOld;
    }
    
    /**
     * 创建共享主题管理器
     *
     * @return object
     */
    static public function shareTheme() {
        if (! self::$oShareTheme) {
            self::$oShareTheme = new theme ();
        }
        return self::$oShareTheme;
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
    public static function parseFile($sTpl, $sExt = '') {
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
        if (\Q::getExtName ( $sTpl ) || strpos ( $sTpl, '$' ) === 0) {
            return $calHelp ( $sTpl );
        } elseif (strpos ( $sTpl, '(' ) !== false) { // 存在表达式
            return $calHelp ( $sTpl );
        } else {
            $objApp = \Q::app ();

            // 空取默认控制器和方法
            if ($sTpl == '') {
                $sTpl = $objApp->controller_name . $GLOBALS ['~@option'] ['theme_moduleaction_depr'] . $objApp->action_name;
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
            ], $GLOBALS ['~@option'] ['theme_moduleaction_depr'], $sTpl );
            
            return $objApp->apptheme_path . '/' . (isset ( $sTheme ) ? $sTheme : $objApp->apptheme_name) . '/' . $sTpl . ($sExt ?  : $GLOBALS ['~@option'] ['theme_suffix']);
        }
    }
    
    /**
     * 匹配默认地址（文件不存在）
     *
     * @param string $sTpl
     *            文件地址
     * @return string
     */
    static public function parseDefaultFile($sTpl) {
        if (is_file ( $sTpl )) {
            return $sTpl;
        }
        
        $sBakTpl = $sTpl;
        $objApp = \Q::app ();
        
        // 物理路径
        if (strpos ( $sTpl, ':' ) !== false || strpos ( $sTpl, '/' ) === 0 || strpos ( $sTpl, '\\' ) === 0) {
            $sTpl = str_replace ( \Q::tidypath ( $objApp->apptheme_path . '/' . $objApp->apptheme_name . '/' ), '', \Q::tidypath ( $sTpl ) );
        }
        
        // 当前主题
        if (is_file ( self::$sTheme . '/' . $sTpl )) {
            return self::$sTheme . '/' . $sTpl;
        }
        
        // 备用地址
        if (self::$sThemeDefault && is_file ( self::$sThemeDefault . '/' . $sTpl )) {
            return self::$sThemeDefault . '/' . $sTpl;
        }
        
        // default 主题
        if ($objApp->apptheme_name != 'default' && is_file ( $objApp->apptheme_path . '/default/' . $sTpl )) {
            return $objApp->apptheme_path . '/default/' . $sTpl;
        }
        
        return $sBakTpl;
    }
    
    /**
     * 记录调试信息
     * SQL 记录，加载文件等等
     *
     * @return void
     */
    public function trace() {
        $arrTrace = [ ];
        
        // SQL 记录
        // $arrLog = Log::$_arrLog;
        $arrLog = [ 
                'SELECT title FROM blog WHERE id = 1;' 
        ];
        if ($arrLog) {
            $arrTrace [\Q::i18n ( 'SQL记录' ) . ' (' . count ( $arrLog ) . ')'] = implode ( '\n', $arrLog );
        }
        
        // 其它日志
        // $arrLog = Log::$_arrLog;
        $arrLog = [ ];
        if ($arrLog) {
            $arrTrace [\Q::i18n ( '日志记录' ) . ' (' . count ( $arrLog ) . ')'] = '';
            $arrTrace = array_merge ( $arrTrace, $arrLog );
        }
        
        // 加载文件
        $arrInclude = get_included_files ();
        $arrTrace [\Q::i18n ( '加载文件' ) . ' (' . count ( $arrInclude ) . ')'] = implode ( '\n', array_map ( function ($sVal) {
            return str_replace ( '\\', '/', $sVal );
        }, $arrInclude ) );
        
        ob_start ();
        include Q_PATH . '/__tpl/trace.php';
        $sContent = ob_get_contents ();
        ob_end_clean ();
        
        return $sContent;
    }
}
