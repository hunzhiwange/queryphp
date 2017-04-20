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
use Q\structure\flow_condition;

/**
 * 响应请求
 *
 * @author Xiangmin Liu
 */
class response {
    
    use flow_condition;
    
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
     * 自定义响应方法
     *
     * @var array
     */
    private static $arrCustomerResponse = [ ];
    
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
     * 拦截一些别名和快捷方式
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return boolean
     */
    public function __call($sMethod, $arrArgs) {
        // 条件控制语句支持
        if ($this->flowConditionCall_ ( $sMethod, $arrArgs ) !== false) {
            return $this;
        }
        
        // 调用自定义的响应方法
        if (isset ( self::$arrCustomerResponse [$sMethod] )) {
            $mixData = call_user_func_array ( self::$arrCustomerResponse [$sMethod], $arrArgs );
            if ($mixData instanceof response) {
                return $mixData;
            } else {
                return $this->data ( $mixData );
            }
        }
        
        \Q::throwException ( \Q::i18n ( 'response 没有实现魔法方法 %s.', $sMethod ), 'Q\request\exception' );
    }
    
    /**
     * 自定义响应方法
     *
     * @param string $strResponseName            
     * @param callback $calResponse            
     * @return $this
     */
    public function register($strResponseName, $calResponse) {
        // 严格验证参数
        if (! \Q::varType ( $strResponseName, 'string' ) || in_array ( $strResponseName, [ 
                'if',
                'elseIf',
                'else',
                'endIf' 
        ] ) || method_exists ( $this, $strResponseName )) {
            \Q::throwException ( \Q::i18n ( '响应名字必须是一个字符串，不能占用条件表达式，且不能注册一个存在的响应方法' ) );
        }
        if (! \Q::varType ( $calResponse, 'callback' )) {
            \Q::throwException ( \Q::i18n ( '响应内容必须是一个回调类型' ) );
        }
        
        self::$arrCustomerResponse [$strResponseName] = $calResponse;
        return $this;
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
        $this->contentTypeAndCharset_ ( $this->getContentType (), $this->getrCharset () );
        
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
        if ($this->checkFlowCondition_ ())
            return $this;
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
        if ($this->checkFlowCondition_ ())
            return $this;
        if (is_array ( $mixName )) {
            $this->arrOption = array_merge ( $this->arrOption, $mixName );
        } else {
            $this->arrOption [$mixName] = $strValue;
        }
        return $this;
    }
    
    /**
     * 返回配置参数
     *
     * @param string $strOptionName            
     * @return mixed
     */
    public function getOption($strOptionName = null) {
        if (is_null ( $strOptionName )) {
            return $this->arrOption;
        } else {
            return isset ( $this->arrOption [$strOptionName] ) ? $this->arrOption [$strOptionName] : null;
        }
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
        if ($this->checkFlowCondition_ ())
            return $this;
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
        if ($this->checkFlowCondition_ ())
            return $this;
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
        if ($this->checkFlowCondition_ ())
            return $this;
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
        if ($this->checkFlowCondition_ ())
            return $this;
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
        if ($this->checkFlowCondition_ ())
            return $this;
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
     * 设置内容
     *
     * @param string $strContent            
     * @return $this
     */
    public function content($strContent) {
        if ($this->checkFlowCondition_ ())
            return $this;
        $this->strContent = $strContent;
        return $this;
    }
    
    /**
     * 解析并且返回内容
     *
     * @return string
     */
    public function getContent() {
        if (! $this->booParseContent) {
            $mixContent = $this->getData ();
            switch ($this->getResponseType ()) {
                case 'json' :
                    $arrOption = array_merge ( self::$arrJsonOption, $this->getOption () );
                    $mixContent = \Q::jsonEncode ( $mixContent, $arrOption ['json_options'] );
                    if ($arrOption ['json_callback']) {
                        $mixContent = $arrOption ['json_callback'] . '(' . $mixContent . ');';
                    }
                    break;
                case 'xml' :
                    $mixContent = \Q::xmlEncode ( $mixContent );
                    break;
                case 'file' :
                    ob_end_clean ();
                    $resFp = fopen ( $this->getOption ( 'file_name' ), 'rb' );
                    fpassthru ( $resFp );
                    fclose ( $resFp );
                    break;
                case 'redirect' :
                    \Q::redirect ( $this->getOption ( 'redirect_url' ), $this->getOption ( 'in' ) );
                    break;
                case 'view' :
                    $mixContent = self::$objView->display ( $this->getOption ( 'file' ), $this->getOption ( 'in' ) );
                    break;
                default :
                    if (is_callable ( $mixContent )) {
                        $mixTemp = call_user_func_array ( $mixContent, [ ] );
                        if ($mixTemp !== null) {
                            $mixContent = $mixTemp;
                        }
                        unset ( $mixTemp );
                    } elseif (is_array ( $mixContent )) {
                        $mixContent = \Q::jsonEncode ( $mixContent );
                    }
                    if (! is_scalar ( $mixContent )) {
                        ob_start ();
                        print_r ( $mixContent );
                        $mixContent = ob_get_contents ();
                        ob_end_clean ();
                    }
                    break;
            }
            $this->content ( $mixContent );
            unset ( $mixContent );
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
        if ($this->checkFlowCondition_ ())
            return $this;
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
        if ($this->checkFlowCondition_ ())
            return $this;
        if (is_array ( $arrData )) {
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
        if ($this->checkFlowCondition_ ())
            return $this;
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
        if ($this->checkFlowCondition_ ())
            return $this;
        return $this->jsonCallback ( $strJsonCallback )->json ( $arrData, $intOptions, $strCharset );
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
    public function view($sFile = '', $in = []) {
        if ($this->checkFlowCondition_ ())
            return $this;
        if (! self::$objView) {
            self::$objView = view::run ();
        }
        if (! isset ( $in ['return'] )) {
            $in ['return'] = true;
        }
        if (! empty ( $in ['charset'] )) {
            $this->charset ( $in ['charset'] );
        }
        if (! empty ( $in ['content_type'] )) {
            $this->contentType ( $in ['content_type'] );
        }
        return $this->responseType ( 'view' )->option ( 'file', $sFile )->option ( 'in', $in )->header ( 'Cache-control', 'private' );
    }
    
    /**
     * view 变量赋值
     *
     * @param mixed $mixName            
     * @param mixed $mixValue            
     * @return $this
     */
    public function assign($mixName, $mixValue = null) {
        if ($this->checkFlowCondition_ ())
            return $this;
        if (! self::$objView) {
            self::$objView = view::run ();
        }
        self::$objView->assign ( $mixName, $mixValue );
        return $this;
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
        if ($this->checkFlowCondition_ ())
            return $this;
        return $this->responseType ( 'redirect' )->code ( 301 )->option ( 'redirect_url', $sUrl )->option ( 'in', $in );
    }
    
    /**
     * xml
     *
     * @param mixed $arrData            
     * @param string $strCharset            
     * @return $this
     */
    public function xml($arrData = null, $strCharset = 'utf-8') {
        if ($this->checkFlowCondition_ ())
            return $this;
        if (is_array ( $arrData )) {
            $this->data ( $arrData );
        }
        return $this->responseType ( 'xml' )->contentType ( 'text/xml' )->charset ( $strCharset );
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
        if ($this->checkFlowCondition_ ())
            return $this;
        if (! $sDownName) {
            $sDownName = basename ( $sFileName );
        } else {
            $sDownName = $sDownName . '.' . \Q::getExtName ( $sFileName );
        }
        return $this->downloadAndFile_ ( $sFileName, $arrHeader )->header ( 'Content-Disposition', 'attachment;filename=' . $sDownName );
    }
    
    /**
     * 读取文件
     *
     * @param string $sFileName            
     * @param array $arrHeader            
     * @return $this
     */
    public function file($sFileName, array $arrHeader = []) {
        if ($this->checkFlowCondition_ ())
            return $this;
        return $this->downloadAndFile_ ( $sFileName, $arrHeader )->header ( 'Content-Disposition', 'inline;filename=' . basename ( $sFileName ) );
    }
    
    /**
     * 页面输出类型
     *
     * @param string $strContentType            
     * @param string $strCharset            
     * @return $this
     */
    private function contentTypeAndCharset_($strContentType, $strCharset = 'utf-8') {
        return $this->header ( 'Content-Type', $strContentType . '; charset=' . $strCharset );
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
