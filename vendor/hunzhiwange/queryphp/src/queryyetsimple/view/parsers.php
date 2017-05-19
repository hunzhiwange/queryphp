<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\view;

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

use queryyetsimple\datastruct\queue\stack;
use queryyetsimple\exception\exceptions;
use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;
use queryyetsimple\filesystem\directory;
use queryyetsimple\helper\helper;

/**
 * 分析模板
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2016.11.19
 * @version 1.0
 */
class parsers {
    
    use dynamic_expansion;
    
    /**
     * 分析器
     *
     * @var queryyetsimple\view\parsers
     */
    private static $objParsers = null;
    
    /**
     * 编译器
     *
     * @var queryyetsimple\view\compilers
     */
    private static $objCompilers = null;
    
    /**
     * 成对节点栈
     *
     * @var stack
     */
    private $oNodeStack;
    
    /**
     * js 和 node 共用分析器
     *
     * @var boolean
     */
    private $bJsNode = false;
    
    /**
     * 编译器
     *
     * @var array
     */
    public static $arrCompilers;
    
    /**
     * 分析器
     *
     * @var array
     */
    public static $arrParses = [ ];
    
    /**
     * 分析器定界符
     *
     * @var array
     */
    protected $arrTag = [ 
            'global' => [ 
                    'left' => '[<\{]',
                    'right' => '[\}>]',
                    'left_node' => '(?:<\!--<|<\!--\{)',
                    'right_node' => '(?:\}-->|>-->)' 
            ], // 全局
            'js' => [ 
                    'left' => '{{',
                    'right' => '}}',
                    'left_node' => '<!--{{',
                    'right_node' => '}}-->' 
            ], // js代码
            'jsvar' => [ 
                    'left' => '{{',
                    'right' => '}}',
                    'left_node' => '<!--{{',
                    'right_node' => '}}-->' 
            ], // js 变量代码
            'code' => [ 
                    'left' => '{',
                    'right' => '}',
                    'left_node' => '<!--{',
                    'right_node' => '}-->' 
            ], // 代码
            'node' => [ 
                    'left' => '<',
                    'right' => '>',
                    'left_node' => '<\!--<',
                    'right_node' => '>-->' 
            ], // 节点
            'revert' => [ ], // 反向
            'globalrevert' => [ ] 
    ]; // 全局反向
    
    /**
     * 模板树结构
     *
     * @var array
     */
    protected $arrThemeTree = [ ];
    
    /**
     * 模板项结构
     *
     * @var array
     */
    protected $arrThemeStruct = [ 
            'source' => '', // 原模板
            'content' => '', //
            'compiler' => null, // 编译器
            'children' => [ ],
            'position' => [ ] 
    ];
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [ 
            'theme_strip_space' => true,
            'theme_tag_note' => false 
    ];
    
    /**
     * 构造函数
     *
     * 注册分析其和编译器
     *
     * @return void
     */
    public function __construct() {
        // 注册编译器
        $arrMethods = get_class_methods ( __NAMESPACE__ . '\compilers' );
        
        // 编译器别名
        $arrCodeMap = compilers::getCodeMapHelps ();
        $arrNodeMap = compilers::getNodeMapHelps ();
        $arrJsMap = compilers::getJsMapHelps ();
        
        foreach ( $arrMethods as $sMethod ) {
            // 按照命名习惯排除的辅助方法和非public的方法
            if (substr ( $sMethod, - 4 ) != 'Help' && substr ( $sMethod, - 1 ) != '_') {
                $sMethod = substr ( $sMethod, 0, - 8 );
                // 排除掉几个全局的方法
                if (! in_array ( $sMethod, [ 
                        'global',
                        'jsvar',
                        'globalrevert',
                        'revert' 
                ] )) {
                    $sType = strtolower ( substr ( $sMethod, - 4 ) );
                    $sTag = substr ( $sMethod, 0, - 4 );
                    if ($sType == 'code') {
                        $name = isset ( $arrCodeMap [$sTag] ) ? $arrCodeMap [$sTag] : $sTag;
                    } elseif ($sType == 'node') {
                        $name = isset ( $arrNodeMap [$sTag] ) ? $arrNodeMap [$sTag] : $sTag;
                    } else {
                        $sType = strtolower ( substr ( $sMethod, - 2 ) );
                        $sTag = substr ( $sMethod, 0, - 2 );
                        $name = isset ( $arrJsMap [$sTag] ) ? $arrJsMap [$sTag] : $sTag;
                    }
                    static::regCompilers ( $sType, $name, $sTag );
                }
            }
        }
        
        // 注册分析器
        foreach ( $this->arrTag as $sKey => $arr ) {
            static::regParser ( $sKey );
        }
        
        // 创建编译器
        static::$objCompilers = new compilers ();
    }
    
    /**
     * 返回编译实例
     *
     * @var queryyetsimple\theme\parsers
     */
    public static function run() {
        if (! static::$objParsers) {
            static::$objParsers = new self ();
        }
        return static::$objParsers;
    }
    
    /**
     * 清理模板树对象
     *
     * @return void
     */
    protected function clearThemeTree() {
        $this->arrThemeTree = [ ];
    }
    
    /**
     * 添加顶层树对象
     *
     * @param array $arrTheme            
     * @return void
     */
    protected function topTheme($arrTheme) {
        $this->arrThemeTree [] = $arrTheme;
    }
    
    /**
     * 将模板结构加入树结构中去
     *
     * @param array $arrTheme            
     * @return void
     */
    public function addTheme($arrTheme) {
        $arrTop = &$this->arrThemeTree [0];
        $arrTop = static::addThemeTree ( $arrTop, $arrTheme );
    }
    
    /**
     * 执行编译
     *
     * @param string $sFile            
     * @param string $sCachePath            
     * @param boolean $bReturn            
     * @return string
     */
    public function doCombile($sFile, $sCachePath, $bReturn = false) {
        if (! is_file ( $sFile )) {
            exceptions::throwException ( printf ( 'file %s is not exits', $sFile ), 'queryyetsimple\view\exception' );
        }
        
        // 源码
        $sCache = file_get_contents ( $sFile );
        
        // 逐个载入分析器编译模板
        foreach ( static::$arrParses as $sParser ) {
            // 清理对象 & 构建顶层树对象
            $this->clearThemeTree ();
            $arrTheme = [ 
                    'source' => $sCache,
                    'content' => $sCache,
                    'position' => static::getPosition ( $sCache, '', 0 ) 
            ];
            
            $arrTheme = array_merge ( $this->getDefaultStruct (), $arrTheme );
            $this->topTheme ( $arrTheme );
            
            // 分析模板生成模板树
            $sParser = $sParser . 'Parse';
            $this->{$sParser} ( $sCache ); // 分析
                                           
            // 编译模板树
            $sCache = $this->compileThemeTree ();
        }
        
        // 清理模板编译文件空格
        if ($this->getExpansionInstanceArgs_ ( 'theme_strip_space' ) === true) {
            
            /**
             * 清理 HTML 清除换行符,清除制表符,去掉注释标记
             * js 中的 “//” 注释将会造成错误，请避免这种写法
             *
             * @param string $sHtml            
             * @return string
             */
            $calCompress = function ($sHtml) {
                $arrPieces = preg_split ( '/(<pre.*?\/pre>)/ms', $sHtml, - 1, PREG_SPLIT_DELIM_CAPTURE );
                $sHtml = '';
                foreach ( $arrPieces as $sPiece ) {
                    if (strpos ( $sPiece, '<pre' ) !== 0) {
                        // 删除换行和制表符
                        $sPiece = preg_replace ( '/[\\n\\r\\t]+/', ' ', $sPiece );
                        // 移除掉多余空白，多个空白字符等价为一个空白字符
                        $sPiece = preg_replace ( '/\\s{2,}/', ' ', $sPiece );
                        // 移除成对标签内部的空白
                        $sPiece = preg_replace ( '/>\\s</', '><', $sPiece );
                        // 移除 CSS & JS 注释
                        $sPiece = preg_replace ( '/\\/\\*.*?\\*\\//i', '', $sPiece );
                    }
                    $sHtml .= $sPiece;
                }
                return $sHtml;
            };
            
            $sCache = $calCompress ( $sCache );
        }
        
        // 返回编译文件
        $sCache = "<?php !defined('Q_PATH') && exit; /* QueryPHP Cache " . date ( 'Y-m-d H:i:s', time () ) . "  */ ?>" . PHP_EOL . $sCache;
        
        // 解决不同操作系统源代码换行混乱
        $sCache = str_replace ( [ 
                "\r",
                "\n" 
        ], '~^^!queryphp_newline!^^~', $sCache );
        
        $sCache = preg_replace ( "/(~^^!queryphp_newline!^^~)+/i", '~^^!queryphp_newline!^^~', $sCache );
        $sCache = str_replace ( '~^^!queryphp_newline!^^~', PHP_EOL, $sCache );
        
        // 生成编译文件
        if ($bReturn === false) {
            $this->makeCacheFile ( $sCachePath, $sCache );
        } else {
            return $sCompiled;
        }
    }
    
    // ######################################################
    // --------------------- 分析器 start ---------------------
    // ######################################################
    
    /**
     * 全局编译器 tagself
     *
     * @param string $sCompiled            
     * @return void
     */
    public function globalParse(&$sCompiled) {
        $arrTag = $this->getTag ( 'global' );
        
        $arrRes = [ ]; // 分析
        if (preg_match_all ( "/{$arrTag['left']}tagself{$arrTag['right']}(.+?){$arrTag['left']}\/tagself{$arrTag['right']}/isx", $sCompiled, $arrRes )) {
            $nStartPos = 0;
            foreach ( $arrRes [1] as $nIndex => $sEncode ) {
                $sSource = trim ( $arrRes [0] [$nIndex] );
                $sContent = trim ( $arrRes [1] [$nIndex] );
                
                $arrTheme = [ 
                        'source' => $sSource,
                        'content' => $sContent,
                        'compiler' => 'global', // 编译器
                        'children' => [ ] 
                ];
                
                $arrTheme ['position'] = static::getPosition ( $sCompiled, $sSource, $nStartPos );
                $nStartPos = $arrTheme ['position'] ['end'] + 1;
                $arrTheme = array_merge ( $this->arrThemeStruct, $arrTheme );
                $this->addTheme ( $arrTheme ); // 将模板数据加入到树结构中
            }
        }
    }
    
    /**
     * javascript 变量分析器
     *
     * @param string $sCompiled            
     * @return void
     */
    public function jsvarParse(&$sCompiled) {
        $arrTag = $this->getTag ( 'jsvar' );
        
        $arrRes = [ ]; // 分析
        if (preg_match_all ( "/{$arrTag['left']}(.+?){$arrTag['right']}/isx", $sCompiled, $arrRes )) {
            $nStartPos = 0;
            foreach ( $arrRes [1] as $nIndex => $sEncode ) {
                $sSource = trim ( $arrRes [0] [$nIndex] );
                $sContent = trim ( $arrRes [1] [$nIndex] );
                
                $arrTheme = [ 
                        'source' => $sSource,
                        'content' => $sContent,
                        'compiler' => 'jsvar', // 编译器
                        'children' => [ ] 
                ];
                
                $arrTheme ['position'] = static::getPosition ( $sCompiled, $sSource, $nStartPos );
                $nStartPos = $arrTheme ['position'] ['end'] + 1;
                $arrTheme = array_merge ( $this->arrThemeStruct, $arrTheme );
                $this->addTheme ( $arrTheme ); // 将模板数据加入到树结构中
            }
        }
    }
    
    /**
     * code 方式分析器
     *
     * @param string $sCompiled            
     * @return void
     */
    public function codeParse(&$sCompiled) {
        foreach ( static::$arrCompilers ['code'] as $sCompilers => $sTag ) {
            $arrNames [] = static::escapeCharacter ( $sCompilers ); // 处理一些正则表达式中有特殊意义的符号
        }
        
        if (! count ( $arrNames )) { // 没有任何编译器
            return;
        }
        
        // 正则分析
        $arrTag = $this->getTag ( 'code' );
        $sNames = implode ( '|', $arrNames );
        $sRegexp = "/" . $arrTag ['left'] . "({$sNames})(|.+?)" . $arrTag ['right'] . "/s";
        $arrRes = [ ]; // 分析
        if (preg_match_all ( $sRegexp, $sCompiled, $arrRes )) {
            $nStartPos = 0;
            foreach ( $arrRes [0] as $nIdx => &$sSource ) {
                $sObjType = trim ( $arrRes [1] [$nIdx] );
                ! $sObjType && $sObjType = '/';
                $sContent = trim ( $arrRes [2] [$nIdx] );
                
                $arrTheme = [ 
                        'source' => $sSource,
                        'content' => $sContent,
                        'compiler' => static::$arrCompilers ['code'] [$sObjType] . 'Code', // 编译器
                        'children' => [ ] 
                ];
                $arrTheme ['position'] = static::getPosition ( $sCompiled, $sSource, $nStartPos );
                $nStartPos = $arrTheme ['position'] ['end'] + 1;
                $arrTheme = array_merge ( $this->arrThemeStruct, $arrTheme );
                $this->addTheme ( $arrTheme ); // 将模板数据加入到树结构中
            }
        }
    }
    
    /**
     * javascript 分析器 与 node 公用分析器
     *
     * @param string $sCompiled            
     * @return void
     */
    public function jsParse(&$sCompiled) {
        $this->bJsNode = true;
        $this->findNodeTag ( $sCompiled ); // 查找分析Node的标签
        $this->packNode ( $sCompiled ); // 用标签组装Node
    }
    
    /**
     * node 分析器
     *
     * @param string $sCompiled            
     * @return void
     */
    public function nodeParse(&$sCompiled) {
        $this->bJsNode = false;
        $this->findNodeTag ( $sCompiled ); // 查找分析Node的标签
        $this->packNode ( $sCompiled ); // 用标签组装Node
    }
    
    /**
     * code 还原分析器
     *
     * @param string $sCompiled            
     * @return void
     */
    public function revertParse(&$sCompiled) {
        $arrRes = [ ]; // 分析
        if (preg_match_all ( '/__##revert##START##\d+@(.+?)##END##revert##__/', $sCompiled, $arrRes )) {
            $nStartPos = 0;
            foreach ( $arrRes [1] as $nIndex => $sEncode ) {
                $sSource = $arrRes [0] [$nIndex];
                
                $arrTheme = [ 
                        'source' => $sSource,
                        'content' => $sEncode,
                        'compiler' => 'revert', // 编译器
                        'children' => [ ] 
                ];
                
                $arrTheme ['position'] = static::getPosition ( $sCompiled, $sSource, $nStartPos );
                $nStartPos = $arrTheme ['position'] ['end'] + 1;
                $arrTheme = array_merge ( $this->arrThemeStruct, $arrTheme );
                $this->addTheme ( $arrTheme ); // 将模板数据加入到树结构中
            }
        }
    }
    
    /**
     * tagself 还原分析器
     *
     * @param string $sCompiled            
     * @return void
     */
    public function globalrevertParse(&$sCompiled) {
        $arrRes = [ ]; // 分析
        if (preg_match_all ( '/__##global##START##\d+@(.+?)##END##global##__/', $sCompiled, $arrRes )) {
            $nStartPos = 0;
            
            foreach ( $arrRes [1] as $nIndex => $sEncode ) {
                $sSource = $arrRes [0] [$nIndex];
                $sContent = $arrRes [1] [$nIndex];
                
                $arrTheme = [ 
                        'source' => $sSource,
                        'content' => $sContent,
                        'compiler' => 'globalrevert', // 编译器
                        'children' => [ ] 
                ];
                
                $arrTheme ['position'] = static::getPosition ( $sCompiled, $sSource, $nStartPos );
                $nStartPos = $arrTheme ['position'] ['end'] + 1;
                $arrTheme = array_merge ( $this->arrThemeStruct, $arrTheme );
                $this->addTheme ( $arrTheme ); // 将模板数据加入到树结构中
            }
        }
    }
    
    // ######################################################
    // ---------------------- 分析器 end ----------------------
    // ######################################################
    
    /**
     * 注册分析器
     *
     * @param string $sTag            
     * @return array
     */
    public static function regParser($sTag) {
        static::$arrParses [] = $sTag;
        return $sTag;
    }
    
    /**
     * 注册编译器 code和node编译器注册
     *
     * @param string $sType
     *            code 代码标签
     *            node 节点标签
     * @param string $sName
     *            ~ 标签
     *            : 标签
     *            while 标签
     * @param array|string $Tag
     *            标签对应的编译器
     * @return void
     */
    public static function regCompilers($sType, $Name, $sTag) {
        if (! is_array ( $Name )) {
            $Name = [ 
                    $Name 
            ];
        }
        foreach ( $Name as $sTemp ) {
            static::$arrCompilers [$sType] [$sTemp] = $sTag;
        }
    }
    
    /**
     * 分析匹配标签的位置
     *
     * @param string $sContent
     *            待编译的模板
     * @param string $sFind
     *            匹配的标签
     * @param int $nStart
     *            起始查找的位置
     * @return array start 标签开始的位置（字节数）
     *         end 标签结束的位置（字节数）
     *         start_line 标签开始的行（行数）
     *         end_line 标签结束的行（行数）
     *         start_in 标签开始的所在的行的起始字节数
     *         end_in 标签结束的所在的行的起始字节数
     */
    public static function getPosition($sContent, $sFind, $nStart) {
        /*
         *
         * ======= start =======
         *
         * {tagself}
         * yes
         * {/tagself}
         *
         * ======== end =======
         *
         * Array
         * (
         * [start] => 27
         * [end] => 64
         * [start_line] => 2
         * [end_line] => 4
         * [start_in] => 2
         * [end_in] => 17
         * )
         */
        $arrData = [ ];
        
        if (empty ( $sFind )) { // 空
            $arrData ['start'] = - 1;
            $arrData ['end'] = - 1;
            $arrData ['start_line'] = - 1;
            $arrData ['end_line'] = - 1;
            $arrData ['start_in'] = - 1;
            $arrData ['end_in'] = - 1;
            return $arrData;
        }
        
        $nTotal = strlen ( $sContent );
        
        // 起止字节位置
        $nStart = strpos ( $sContent, $sFind, $nStart );
        $nEnd = $nStart + strlen ( $sFind ) - 1;
        
        // 起止行数
        $nStartLine = ($nStart <= 0) ? 0 : substr_count ( $sContent, "\n", 0, $nStart );
        $nEndLine = ($nEnd <= 0) ? 0 : substr_count ( $sContent, "\n", 0, $nEnd );
        
        /**
         * 匹配模块范围圈（在这个字节里面的都是它的子模快）
         * 找到开始和结束的地方就确定了这个模块所在区域范围
         */
        
        // 起点的行首换行位置 && 结束点的行首位置
        $nLineStartFirst = strrpos ( substr ( $sContent, 0, $nStart ), "\n" ) + 1;
        $nLineEndFirst = strrpos ( substr ( $sContent, 0, $nEnd ), "\n" ) + 1;
        $nStartIn = $nStart - $nLineStartFirst;
        $nEndIn = $nEnd - $nLineEndFirst;
        
        /**
         * 返回结果
         */
        $arrData ['start'] = $nStart;
        $arrData ['end'] = $nEnd;
        $arrData ['start_line'] = $nStartLine;
        $arrData ['end_line'] = $nEndLine;
        $arrData ['start_in'] = $nStartIn;
        $arrData ['end_in'] = $nEndIn;
        
        return $arrData;
    }
    
    /**
     * 对比两个模板相对位置
     * 这个和两个时间段之间的关系一样，其中交叉在模板引擎中是不被支持，因为无法实现
     * 除掉交叉，剩下包含、被包含、前面和后面，通过位置组装成一颗树结构
     *
     * @param array $arrOne
     *            待分析的第一个模板
     * @param array $arrTwo
     *            待分析的第二个模板
     * @return string front 第一个在第二个前面
     *         behind 第一个在第二个后面
     *         in 第一个在第二里面，成为它的子模板
     *         out 第一个在第一个里面，成为它的子模板
     */
    public static function positionRelative($arrOne, $arrTwo) {
        
        /**
         * 第一个匹配的标签在第二个前面
         * 条件：第一个结束字节位置 <= 第二个开始位置
         */
        /*
         *
         * ======= start =======
         *
         * {if}
         * one
         * {/if}
         *
         * {for}
         * two
         * {/for}
         *
         * ======== end =======
         */
        if ($arrOne ['end'] <= $arrTwo ['start']) {
            return 'front';
        }
        
        /**
         * 第一个匹配的标签在第二个后面
         * 条件：第一个开始字节位置 >= 第二个结束位置
         */
        
        /*
         *
         * ======= start =======
         *
         * {for}
         * two
         * {/for}
         *
         * {if}
         * one
         * {/if}
         *
         * ======== end =======
         */
        if ($arrOne ['start'] >= $arrTwo ['end']) {
            return 'behind';
        }
        
        /**
         * 第一个匹配的标签在第二个里面
         * 条件：第一个开始字节位置 >= 第二个开始位置
         */
        
        /*
         *
         * ======= start =======
         *
         * {for}
         * two
         *
         * {if}
         * one
         * {/if}
         *
         * {/for}
         *
         * ======== end =======
         */
        if ($arrOne ['start'] >= $arrTwo ['start']) {
            return 'in';
        }
        
        /**
         * 第一个匹配的标签在第二个外面
         * 条件：第一个开始字节位置 <= 第二个开始位置
         */
        
        /*
         *
         * ======= start =======
         *
         * {if}
         * one
         *
         * {for}
         * two
         * {/for}
         *
         * {/if}
         *
         * ======== end =======
         */
        if ($arrOne ['start'] <= $arrTwo ['start']) {
            return 'out';
        }
        
        /**
         * 交叉（两个时间段相互关系）
         */
        exceptions::throwException ( __ ( '标签库不支持交叉' ), 'queryyetsimple\view\exception' );
    }
    
    /**
     * 将新的模板加入到树结构中去
     *
     * @param array $arrTop
     *            顶层模板
     * @param array $arrNew
     *            待加入的模板
     * @return array
     */
    public static function addThemeTree($arrTop, $arrNew) {
        $arrResult = [ ];
        
        foreach ( $arrTop ['children'] as $arrChild ) {
            if ($arrNew) {
                $sRelative = static::positionRelative ( $arrNew ['position'], $arrChild ['position'] );
                
                switch ($sRelative) {
                    
                    /**
                     * 新增的和上次处于平级关系直接加入上级的 children 容器中
                     * new 在前 child 在后面
                     */
                    case 'front' :
                        $arrResult [] = $arrNew;
                        $arrResult [] = $arrChild;
                        $arrNew = null;
                        break;
                    
                    /**
                     * 新增的和上次处于平级关系直接加入上级的 children 容器中
                     * child 在前 new 在后面
                     */
                    case 'behind' :
                        $arrResult [] = $arrChild;
                        break;
                    
                    /**
                     * new 处于 child 内部
                     * new 在 child 内部
                     */
                    case 'in' :
                        $arrChild = static::addThemeTree ( $arrChild, $arrNew );
                        $arrResult [] = $arrChild;
                        $arrNew = null;
                        break;
                    
                    /**
                     * child 处于 new 内部
                     * child 在 new 内部
                     */
                    case 'out' :
                        $arrNew = static::addThemeTree ( $arrNew, $arrChild );
                        break;
                }
            } else {
                $arrResult [] = $arrChild;
            }
        }
        
        if ($arrNew) {
            $arrResult [] = $arrNew;
        }
        
        $arrTop ['children'] = $arrResult;
        return $arrTop;
    }
    
    /**
     * 分析模板调用编译器编译
     *
     * @param array $arrTheme
     *            待编译的模板
     * @return string 返回编译后的模板
     */
    public static function compileTheme(&$arrTheme) {
        foreach ( $arrTheme ['children'] as $intKey => $arrOne ) {
            $strSource = $arrOne ['source'];
            
            static::compileTheme ( $arrOne ); // 编译子对象
            $arrTheme ['children'] [$intKey] = $arrOne;
            
            // 置换对象
            $nStart = strpos ( $arrTheme ['content'], $strSource );
            $nLen = $arrOne ['position'] ['end'] - $arrOne ['position'] ['start'] + 1;
            $arrTheme ['content'] = substr_replace ( $arrTheme ['content'], $arrOne ['content'], $nStart, $nLen );
        }
        
        // 编译自身
        if ($arrTheme ['compiler']) {
            $strCompilers = $arrTheme ['compiler'] . 'Compiler';
            static::$objCompilers->{$strCompilers} ( $arrTheme );
        }
    }
    
    /**
     * 取得默认模板项结构
     *
     * @return array
     */
    public function getDefaultStruct() {
        return $this->arrThemeStruct;
    }
    
    /**
     * code 编译编码，后还原
     *
     * @param string $sContent            
     * @return string
     */
    public static function revertEncode($sContent) {
        $nRand = rand ( 1000000, 9999999 );
        return "__##revert##START##{$nRand}@" . base64_encode ( $sContent ) . '##END##revert##__';
    }
    
    /**
     * tagself 编译编码，后还原
     *
     * @param string $sContent            
     * @return string
     */
    public static function globalEncode($sContent) {
        $nRand = rand ( 1000000, 9999999 );
        return "__##global##START##{$nRand}@" . base64_encode ( $sContent ) . '##END##global##__';
    }
    
    /**
     * 转移正则表达式特殊字符
     *
     * @param string $sTxt            
     * @return string
     */
    public static function escapeCharacter($sTxt) {
        return helper::escapeRegexCharacter ( $sTxt );
    }
    
    // ######################################################
    // -------------------- 私有函数 start --------------------
    // ######################################################
    
    /**
     * 逐个编译模板树
     *
     * @return string
     */
    protected function compileThemeTree() {
        // 逐个编译
        $sCache = '';
        foreach ( $this->arrThemeTree as $arrTheme ) {
            static::compileTheme ( $arrTheme );
            $sCache .= $arrTheme ['content'];
        }
        return $sCache;
    }
    
    /**
     * 创建缓存文件
     *
     * @param string $sCachePath            
     * @param string $sCompiled            
     * @return void
     */
    protected function makeCacheFile($sCachePath, &$sCompiled) {
        ! is_file ( $sCachePath ) && ! is_dir ( dirname ( $sCachePath ) ) && directory::create ( dirname ( $sCachePath ) );
        file_put_contents ( $sCachePath, $sCompiled );
    }
    
    /**
     * 查找成对节点
     *
     * @param string $sCompiled            
     * @return void
     */
    protected function findNodeTag(&$sCompiled) {
        // 设置一个栈
        $this->oNodeStack = new stack ();
        
        // 判断是那种编译器
        $sNodeType = $this->bJsNode === true ? 'js' : 'node';
        
        foreach ( static::$arrCompilers [$sNodeType] as $sCompilers => $sTag ) { // 所有一级节点名称
            $arrNames [] = static::escapeCharacter ( $sCompilers ); // 处理一些正则表达式中有特殊意义的符号
        }
        if (! count ( $arrNames )) { // 没有 任何编译器
            return;
        }
        // 正则分析
        $arrTag = $this->getTag ( $sNodeType );
        $sNames = implode ( '|', $arrNames );
        $sRegexp = "/{$arrTag['left']}(\/?)(({$sNames})(:[^\s" . ($this->bJsNode === true ? '' : "\>") . "\}]+)?)(\s[^" . ($this->bJsNode === true ? '' : ">") . "\}]*?)?\/?{$arrTag['right']}/isx";
        $nNodeNameIdx = 2; // 标签名称位置
        $nNodeTopNameIdx = 3; // 标签顶级名称位置
        $nTailSlasheIdx = 1; // 尾标签斜线位置
        $nTagAttributeIdx = 5; // 标签属性位置
        
        if ($this->bJsNode === true) {
            $arrCompiler = static::$arrCompilers ['js'];
        } else {
            $arrCompiler = static::$arrCompilers ['node'];
        }
        
        if (preg_match_all ( $sRegexp, $sCompiled, $arrRes )) { // 依次创建标签对象
            $nStartPos = 0;
            foreach ( $arrRes [0] as $nIdx => &$sTagSource ) {
                $sNodeName = $arrRes [$nNodeNameIdx] [$nIdx];
                $sNodeTopName = $arrRes [$nNodeTopNameIdx] [$nIdx];
                $nNodeType = $arrRes [$nTailSlasheIdx] [$nIdx] === '/' ? 'tail' : 'head';
                
                $sNodeName = strtolower ( $sNodeName ); // 将节点名称统一为小写
                $sNodeTopName = strtolower ( $sNodeTopName );
                
                $arrTheme = [ 
                        'source' => $sTagSource,
                        'name' => $arrCompiler [$sNodeTopName],
                        'type' => $nNodeType 
                ];
                
                // 头标签的属性
                if ($nNodeType == 'head') {
                    $arrTheme ['attribute'] = $arrRes [$nTagAttributeIdx] [$nIdx];
                } else {
                    $arrTheme ['attribute'] = '';
                }
                $arrTheme ['content'] = $arrTheme ['attribute'];
                $arrTheme ['position'] = static::getPosition ( $sCompiled, $sTagSource, $nStartPos );
                $nStartPos = $arrTheme ['position'] ['end'] + 1;
                $arrTheme = array_merge ( $this->arrThemeStruct, $arrTheme );
                $this->oNodeStack->in ( $arrTheme ); // 加入到标签栈
            }
        }
    }
    
    /**
     * 装配节点
     *
     * @param string $sCompiled            
     * @return void
     */
    protected function packNode(&$sCompiled) {
        if ($this->bJsNode === true) {
            $arrNodeTag = compilers::getJsTagHelps ();
            $sCompiler = 'Js';
        } else {
            $arrNodeTag = compilers::getNodeTagHelps ();
            $sCompiler = 'Node';
        }
        
        $oTailStack = new stack ( 'array' ); // 尾标签栈
        while ( ($arrTag = $this->oNodeStack->out ()) !== null ) { // 载入节点属性分析器&依次处理所有标签
            if ($arrTag ['type'] == 'tail') { // 尾标签，加入到尾标签中
                $oTailStack->in ( $arrTag );
                continue;
            }
            
            $arrTailTag = $oTailStack->out (); // 从尾标签栈取出一项
            if (! $arrTailTag or ! $this->findHeadTag ( $arrTag, $arrTailTag )) { // 单标签节点
                
                if ($arrNodeTag [$arrTag ['name']] ['single'] !== true) {
                    exceptions::throwException ( __ ( '%s 类型节点 必须成对使用，没有找到对应的尾标签', $arrTag ['name'] ), 'queryyetsimple\view\exception' );
                }
                if ($arrTailTag) { // 退回栈中
                    $oTailStack->in ( $arrTailTag );
                }
                
                $arrThemeNode = [ 
                        'content' => $arrTag ['content'],
                        'compiler' => $arrTag ['name'] . $sCompiler, // 编译器
                        'source' => $arrTag ['source'],
                        'name' => $arrTag ['name'] 
                ];
                $arrThemeNode ['position'] = $arrTag ['position'];
                $arrThemeNode = array_merge ( $this->arrThemeStruct, $arrThemeNode );
            } else { // 成对标签
                     // 头尾标签中间为整个标签内容
                $nStart = $arrTag ['position'] ['start'];
                $nLen = $arrTailTag ['position'] ['end'] - $nStart + 1;
                $sSource = substr ( $sCompiled, $nStart, $nLen );
                
                $arrThemeNode = [ 
                        'content' => $sSource,
                        'compiler' => $arrTag ['name'] . $sCompiler, // 编译器
                        'source' => $sSource,
                        'name' => $arrTag ['name'] 
                ];
                $arrThemeNode ['position'] = static::getPosition ( $sCompiled, $sSource, $nStart );
                $arrThemeNode = array_merge ( $this->arrThemeStruct, $arrThemeNode );
                
                // 标签body
                $nStart = $arrTag ['position'] ['end'] + 1;
                $nLen = $arrTailTag ['position'] ['start'] - $nStart;
                if ($nLen > 0) {
                    $sBody = substr ( $sCompiled, $nStart, $nLen );
                    $arrThemeBody = [ 
                            'content' => $sBody,
                            'compiler' => null, // 编译器
                            'source' => $sBody,
                            'is_body' => 1 
                    ];
                    $arrThemeBody ['position'] = static::getPosition ( $sCompiled, $sBody, $nStart );
                    $arrThemeBody = array_merge ( $this->arrThemeStruct, $arrThemeBody );
                    $arrThemeNode = static::addThemeTree ( $arrThemeNode, $arrThemeBody );
                }
            }
            
            // 标签属性
            $arrThemeAttr = [ 
                    'content' => $arrTag ['content'],
                    'compiler' => 'attributeNode', // 编译器
                    'source' => $arrTag ['source'],
                    'attribute_list' => [ ],
                    'is_attribute' => true,
                    'parent_name' => $arrThemeNode ['name'],
                    'is_js' => $this->bJsNode 
            ];
            
            $arrThemeAttr ['position'] = static::getPosition ( $sCompiled, $arrTag ['source'], 0 );
            $arrThemeAttr = array_merge ( $this->arrThemeStruct, $arrThemeAttr );
            $arrThemeNode = static::addThemeTree ( $arrThemeNode, $arrThemeAttr );
            $this->addTheme ( $arrThemeNode ); // 将模板数据加入到树结构中
        }
    }
    
    /**
     * 查找 node 标签
     *
     * @param array $arrTag            
     * @param array $arrTailTag            
     * @return boolean
     */
    protected function findHeadTag($arrTag, $arrTailTag) {
        if ($arrTailTag ['type'] != 'tail') {
            exceptions::throwException ( __ ( '参数必须是一个尾标签' ), 'queryyetsimple\view\exception' );
        }
        return preg_match ( "/^{$arrTailTag['name']}/i", $arrTag ['name'] );
    }
    
    /**
     * 取得模板分析器定界符
     *
     * @param string $sType            
     * @return array
     */
    protected function getTag($sType) {
        return $this->arrTag [$sType . ($this->getExpansionInstanceArgs_ ( 'theme_tag_note' ) === true ? '_node' : '')];
    }
    
    // ######################################################
    // --------------------- 私有函数 end ---------------------
    // ######################################################
}
