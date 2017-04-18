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
 * @date 2017.04.18
 * @since 4.0
 */
namespace Q\request;

use Q\mvc\view;

/**
 * 响应请求
 *
 * @author Xiangmin Liu
 */
class response {
    
    /**
     * 请求实例
     *
     * @var Q\request\response
     */
    private static $oInstance = null;
    
    /**
     * 是否初始化
     *
     * @var boolean
     */
    private static $booInit = false;
    
    /**
     * 响应数据
     *
     * @var mixed
     */
    private $mixData;
    
    /**
     * 设置内容
     *
     * @var string
     */
    private $strContent;
    
    /**
     * 是否分析过内容
     *
     * @var boolean
     */
    private $booParseContent = false;
    
    /**
     * 响应状态
     *
     * @var int
     */
    private $intCode = 200;
    
    /**
     * 响应头
     *
     * @var array
     */
    private $arrHeader = [ ];
    
    /**
     * 响应类型
     *
     * @var string
     */
    private $strContentType = 'text/html';
    
    /**
     * 字符编码
     *
     * @var string
     */
    private $strCharset = 'utf-8';
    
    /**
     * 参数
     *
     * @var array
     */
    private $arrOption = [ ];
    
    /**
     * 响应类型
     *
     * @var string
     */
    private $strResponseType = 'default';
    
    /**
     * json 配置
     *
     * @var array
     */
    private static $arrJsonOption = [ 
            'json_callback' => '',
            'json_options' => JSON_UNESCAPED_UNICODE 
    ];
    
    /**
     * 视图实例
     *
     * @var Q\mvc\view
     */
    private static $objView = null;
    
    /**
     * 构造函数
     *
     * @param mixed $mixData            
     * @param int $intCode            
     * @param array $arrHeader            
     * @param array $arrOption            
     * @return $this
     */
    public function __construct($mixData = '', $intCode = 200, array $arrHeader = [], $arrOption = []) {
        // 是否初始化
        if (self::$booInit === true) {
            return $this;
        }
        self::$booInit = true;
        
        // 初始化参数
        $this->data ( $mixData )->code ( intval ( $intCode ) )->header ( $arrHeader )->option ( $arrOption );
    }
    
    /**
     * 创建请求实例
     *
     * @param mixed $mixData            
     * @param int $intCode            
     * @param array $arrHeader            
     * @param array $arrOption            
     * @return $this
     */
    static public function singleton($mixData = '', $intCode = 200, array $arrHeader = [], $arrOption = []) {
        if (self::$oInstance) {
            return self::$oInstance;
        } else {
            return self::$oInstance = new self ( $mixData, $intCode, $arrHeader, $arrOption );
        }
    }
    
    /**
     * 输出内容
     *
     * @return void
     */
    public function output() {
        // 组装编码
        $this->contentTypeAndCharset ( $this->getContentType (), $this->getrCharset () );
        
        // 发送头部 header
        if (! headers_sent () && ! empty ( $this->arrHeader )) {
            http_response_code ( $this->intCode );
            foreach ( $this->arrHeader as $strName => $strValue ) {
                header ( $strName . ':' . $strValue );
            }
        }
        
        // 输出内容
        echo $this->getContent ();
        
        // 提高响应速速
        if (function_exists ( 'fastcgi_finish_request' )) {
            fastcgi_finish_request ();
        }
    }
    
    /**
     * 设置头部参数
     *
     * @param string|array $mixName            
     * @param string $strValue            
     * @return $this
     */
    public function header($mixName, $strValue = null) {
        if (is_array ( $mixName )) {
            $this->arrHeader = array_merge ( $this->arrHeader, $mixName );
        } else {
            $this->arrHeader [$mixName] = $strValue;
        }
        return $this;
    }
    
    /**
     * 返回头部参数
     *
     * @param string $strHeaderName            
     * @return mixed
     */
    public function getHeader($strHeaderName = null) {
        if (is_null ( $strHeaderName )) {
            return $this->arrHeader;
        } else {
            return isset ( $this->arrHeader [$strHeaderName] ) ? $this->arrHeader [$strHeaderName] : null;
        }
    }
    
    /**
     * 设置配置参数
     *
     * @param mixed $mixName            
     * @param string $strValue            
     * @return $this
     */
    public function option($mixName, $strValue = null) {
        if (is_array ( $mixName )) {
            $this->arrOption = array_merge ( $this->arrOption, $mixName );
        } else {
            $this->arrOption [$mixName] = $strValue;
        }
        return $this;
    }
    
    /**
     * 设置响应 cookie
     *
     * @param string $sName            
     * @param mixed $mixValue            
     * @param array $in
     *            life 过期时间
     *            cookie_domain 是否启用域名
     *            prefix 是否开启前缀
     *            http_only
     *            only_delete_prefix
     * @return $this
     */
    public function cookie($sName, $mixValue = '', array $in = []) {
        \Q::cookie ( $sName, $mixValue, $in );
        return $this;
    }
    
    /**
     * 设置原始数据
     *
     * @param mixed $mixData            
     * @return $this
     */
    public function data($mixData) {
        $this->mixData = $mixData;
        return $this;
    }
    
    /**
     * 返回原始数据
     *
     * @return $this
     */
    public function getData() {
        return $this->mixData;
    }
    
    /**
     * 响应状态
     *
     * @param int $intCode            
     * @return $this
     */
    public function code($intCode) {
        $this->intCode = intval ( $intCode );
        return $this;
    }
    
    /**
     * 返回响应状态
     *
     * @return number
     */
    public function getCode() {
        return $this->intCode;
    }
    
    /**
     * contentType
     *
     * @param string $strContentType            
     * @return $this
     */
    public function contentType($strContentType) {
        $this->strContentType = $strContentType;
        return $this;
    }
    
    /**
     * 返回 contentType
     *
     * @return string
     */
    public function getContentType() {
        return $this->strContentType;
    }
    
    /**
     *
     * @param unknown $strCharset            
     * @return \Q\request\response
     */
    public function charset($strCharset) {
        $this->strCharset = $strCharset;
        return $this;
    }
    
    /**
     *
     * @return string
     */
    public function getrCharset() {
        return $this->strCharset;
    }
    
    /**
     * 页面输出类型
     *
     * @param string $strContentType            
     * @param string $strCharset            
     * @return $this
     */
    public function contentTypeAndCharset($strContentType, $strCharset = 'utf-8') {
        return $this->header ( 'Content-Type', $strContentType . '; charset=' . $strCharset );
    }
    
    /**
     * 设置内容
     *
     * @param string $strContent            
     * @return $this
     */
    public function content($strContent) {
        $this->strContent = $strContent;
        return $this;
    }
    
    /**
     * 返回内容
     *
     * @return string
     */
    public function getContent() {
        if (! $this->booParseContent) {
            $strContent = '';
            switch ($this->getResponseType ()) {
                case 'json' :
                    $arrOption = array_merge ( self::$arrJsonOption, $this->arrOption );
                    $strContent = \Q::jsonEncode ( $this->getData (), $arrOption ['json_options'] );
                    if ($arrOption ['json_callback']) {
                        $strContent = $arrOption ['json_callback'] . '(' . $strContent . ');';
                    }
                    break;
                case 'xml' :
                    $strContent = \Q::xmlEncode ( $this->getData () );
                    break;
                case 'file' :
                    ob_end_clean ();
                    $resFp = fopen ( $this->arrOption ['file_name'], 'rb' );
                    fpassthru ( $resFp );
                    fclose ( $resFp );
                    break;
            }
            $this->content ( $strContent );
        }
        return $this->strContent;
    }
    
    /**
     * 设置相应类型
     *
     * @param string $strResponseType            
     * @return $this
     */
    public function responseType($strResponseType) {
        $this->strResponseType = $strResponseType;
        return $this;
    }
    
    /**
     * 返回相应类型
     *
     * @return string
     */
    public function getResponseType() {
        return $this->strResponseType;
    }
    
    /**
     * jsonp
     *
     * @param array $arrData            
     * @param int $intOptions            
     * @param string $strCharset            
     * @return $this
     */
    public function json($arrData = null, $intOptions = JSON_UNESCAPED_UNICODE, $strCharset = 'utf-8') {
        if (! is_null ( $arrData )) {
            $this->data ( $arrData );
        }
        $this->responseType ( 'json' )->contentType ( 'application/json' )->charset ( $strCharset )->option ( 'json_options', $intOptions );
        return $this;
    }
    
    /**
     * json callback
     *
     * @param string $strJsonCallback            
     * @return $this
     */
    public function jsonCallback($strJsonCallback) {
        return $this->option ( 'json_callback', $strJsonCallback );
    }
    
    /**
     * jsonp
     *
     * @param string $strJsonCallback            
     * @param array $arrData            
     * @param int $intOptions            
     * @param string $strCharset            
     * @return $this
     */
    public function jsonp($strJsonCallback, $arrData = null, $intOptions = JSON_UNESCAPED_UNICODE, $strCharset = 'utf-8') {
        return $this->jsonCallback ( $strJsonCallback )->json ( $arrData, $intOptions, $strCharset );
    }
    
    /**
     * view 变量赋值
     *
     * @param mixed $mixName            
     * @param mixed $mixValue            
     * @return $this
     */
    public function view($mixName = null, $mixValue = null) {
        if (! self::$objView) {
            self::$objView = view::run ();
        }
        if (! is_null ( $mixName )) {
            $this->assign ( $mixName, $mixValue );
        }
        return $this;
    }
    
    /**
     * view 变量赋值
     *
     * @param mixed $mixName            
     * @param mixed $mixValue            
     * @return $this
     */
    public function assign($mixName, $mixValue = null) {
        self::$objView->assign ( $mixName, $mixValue );
        return $this;
    }
    
    /**
     * view 加载视图文件
     *
     * @param string $sFile            
     * @param array $in
     *            charset 编码
     *            content_type 内容类型
     *            return 是否返回
     * @return void|string
     */
    public function display($sFile = '', $in = []) {
        return self::$objView->display ( $sFile, $in );
    }
    
    /**
     * 路由 URL 跳转
     *
     * @param string $sUrl            
     * @param 额外参数 $in
     *            params url 额外参数
     *            message 消息
     *            time 停留时间，0表示不停留
     * @return void
     */
    public function redirect($sUrl, $in = []) {
        \Q::redirect ( $sUrl, $in );
    }
    
    /**
     * xml
     *
     * @param mixed $arrData            
     * @param string $strCharset            
     * @return $this
     */
    public function xml($arrData = null, $strCharset = 'utf-8') {
        if (! is_null ( $arrData )) {
            $this->data ( $arrData );
        }
        $this->responseType ( 'xml' )->contentType ( 'text/xml' )->charset ( $strCharset );
        return $this;
    }
    
    /**
     * 下载文件
     *
     * @param string $sFileName            
     * @param string $sDownName            
     * @param array $arrHeader            
     * @return $this
     */
    public function download($sFileName, $sDownName = '', array $arrHeader = []) {
        if (! $sDownName) {
            $sDownName = basename ( $sFileName );
        } else {
            $sDownName = $sDownName . '.' . \Q::getExtName ( $sFileName );
        }
        $this->downloadAndFile_ ( $sFileName, $arrHeader )->header ( 'Content-Disposition', 'attachment;filename=' . $sDownName );
        return $this;
    }
    
    /**
     * 读取文件
     *
     * @param string $sFileName            
     * @param array $arrHeader            
     * @return $this
     */
    public function file($sFileName, array $arrHeader = []) {
        $this->downloadAndFile_ ( $sFileName, $arrHeader )->header ( 'Content-Disposition', 'attachment;filename=' . basename ( $sFileName ) );
        return $this;
    }
    
    /**
     * 下载或者读取文件
     *
     * @param string $sFileName            
     * @param array $arrHeader            
     * @return $this
     */
    private function downloadAndFile_($sFileName, array $arrHeader = []) {
        if (! is_file ( $sFileName )) {
            \Q::throwException ( \Q::i18n ( '读取的文件不存在' ) );
        }
        $sFileName = realpath ( $sFileName );
        
        // 读取类型
        $resFinfo = finfo_open ( FILEINFO_MIME );
        $strMimeType = finfo_file ( $resFinfo, $sFileName );
        finfo_close ( $resFinfo );
        
        $arrHeader = array_merge ( [ 
                'Cache-control' => 'max-age=31536000',
                'Content-Encoding' => 'none',
                'Content-type' => $strMimeType,
                'Content-Length' => filesize ( $sFileName ) 
        ], $arrHeader );
        $this->responseType ( 'file' )->header ( $arrHeader )->option ( 'file_name', $sFileName );
        
        return $this;
    }
}
