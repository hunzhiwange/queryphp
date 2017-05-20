<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\http;

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

use queryyetsimple\mvc\view;
use queryyetsimple\traits\flow\control as flow_control;
use queryyetsimple\exception\exceptions;
use queryyetsimple\cookie\cookie;
use queryyetsimple\assert\assert;
use queryyetsimple\traits\dynamic\expansion as dynamic_expansion;
use queryyetsimple\router\router;
use queryyetsimple\xml\xml;
use queryyetsimple\filesystem\file;

/**
 * 响应请求
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.04.18
 * @version 4.0
 */
class response {
    
    use flow_control;
    use dynamic_expansion {
        __call as __callExpansion;
    }
    
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
     * @var queryyetsimple\mvc\view
     */
    private static $objView = null;
    
    /**
     * 自定义响应方法
     *
     * @var array
     */
    private static $arrCustomerResponse = [ ];
    
    /**
     * 配置
     *
     * @var array
     */
    protected $arrInitExpansionInstanceArgs = [ 
            'view\action_fail' => 'public+fail',
            'view\action_success' => 'public+success' 
    ];
    
    /**
     * 创建一个响应
     *
     * @param mixed $mixData            
     * @param int $intCode            
     * @param array $arrHeader            
     * @param array $arrOption            
     * @return $this
     */
    public function make($mixData = '', $intCode = 200, array $arrHeader = [], $arrOption = []) {
        return $this->data ( $mixData )->code ( intval ( $intCode ) )->header ( $arrHeader )->option ( $arrOption );
    }
    
    /**
     * 拦截一些别名和快捷方式
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return boolean
     */
    public function __call($sMethod, $arrArgs) {
        
        // 调用 trait __call 实现扩展方法
        $mixData = $this->__callExpansion ( $sMethod, $arrArgs );
        if ($mixData instanceof response) {
            return $mixData;
        } else {
            return $this->data ( $mixData );
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
        if ($this->checkFlowControl_ ())
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
        if ($this->checkFlowControl_ ())
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
        if ($this->checkFlowControl_ ())
            return $this;
        cookie::sets ( $sName, $mixValue, $in );
        return $this;
    }
    
    /**
     * 设置原始数据
     *
     * @param mixed $mixData            
     * @return $this
     */
    public function data($mixData) {
        if ($this->checkFlowControl_ ())
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
        if ($this->checkFlowControl_ ())
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
        if ($this->checkFlowControl_ ())
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
     * 编码设置
     *
     * @param string $strCharset            
     * @return \queryyetsimple\http\response
     */
    public function charset($strCharset) {
        if ($this->checkFlowControl_ ())
            return $this;
        $this->strCharset = $strCharset;
        return $this;
    }
    
    /**
     * 获取编码
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
        if ($this->checkFlowControl_ ())
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
                    $arrOption = array_merge ( static::$arrJsonOption, $this->getOption () );
                    $mixContent = json_encode ( $mixContent, $arrOption ['json_options'] );
                    if ($arrOption ['json_callback']) {
                        $mixContent = $arrOption ['json_callback'] . '(' . $mixContent . ');';
                    }
                    break;
                case 'xml' :
                    $mixContent = xml::xmlSerialize ( $mixContent );
                    break;
                case 'file' :
                    ob_end_clean ();
                    $resFp = fopen ( $this->getOption ( 'file_name' ), 'rb' );
                    fpassthru ( $resFp );
                    fclose ( $resFp );
                    break;
                case 'redirect' :
                    static::redirects ( $this->getOption ( 'redirect_url' ), $this->getOption ( 'in' ) );
                    break;
                case 'view' :
                    $mixContent = static::$objView->display ( $this->getOption ( 'file' ), $this->getOption ( 'in' ) );
                    break;
                default :
                    if (is_callable ( $mixContent )) {
                        $mixTemp = call_user_func_array ( $mixContent, [ ] );
                        if ($mixTemp !== null) {
                            $mixContent = $mixTemp;
                        }
                        unset ( $mixTemp );
                    } elseif (is_array ( $mixContent )) {
                        $mixContent = json_encode ( $mixContent, JSON_UNESCAPED_UNICODE );
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
        if ($this->checkFlowControl_ ())
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
        if ($this->checkFlowControl_ ())
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
        if ($this->checkFlowControl_ ())
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
        if ($this->checkFlowControl_ ())
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
        if ($this->checkFlowControl_ ())
            return $this;
        if (! static::$objView) {
            static::$objView = view::run ();
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
        if ($this->checkFlowControl_ ())
            return $this;
        if (! static::$objView) {
            static::$objView = view::run ();
        }
        static::$objView->assign ( $mixName, $mixValue );
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
        if ($this->checkFlowControl_ ())
            return $this;
        assert::string ( $sUrl );
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
        if ($this->checkFlowControl_ ())
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
        if ($this->checkFlowControl_ ())
            return $this;
        if (! $sDownName) {
            $sDownName = basename ( $sFileName );
        } else {
            $sDownName = $sDownName . '.' . file::getExtName ( $sFileName );
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
        if ($this->checkFlowControl_ ())
            return $this;
        return $this->downloadAndFile_ ( $sFileName, $arrHeader )->header ( 'Content-Disposition', 'inline;filename=' . basename ( $sFileName ) );
    }
    
    /**
     * 错误返回消息
     *
     * @param $sMessage 消息            
     * @param $in message
     *            消息内容
     *            url 跳转 url 地址
     *            time 停留时间
     *            
     * @return json
     */
    protected function error($sMessage = '', $in = []) {
        $in = array_merge ( [ 
                'message' => $sMessage ?  : __ ( '操作失败' ),
                'url' => '',
                'time' => 3 
        ], $in );
        $this->assign ( $in );
        $this->display ( $this->getExpansionInstanceArgs_ ( 'view\action_fail' ) );
    }
    
    /**
     * 正确返回消息
     *
     * @param $sMessage 消息            
     * @param $in message
     *            消息内容
     *            url 跳转 url 地址
     *            time 停留时间
     *            
     * @return json
     */
    protected function success($sMessage = '', $in = []) {
        $in = array_merge ( [ 
                'message' => $sMessage ?  : __ ( '操作成功' ),
                'url' => '',
                'time' => 1 
        ], $in );
        $this->assign ( $in );
        $this->display ( $this->getExpansionInstanceArgs_ ( 'view\action_success' ) );
    }
    
    /**
     * json 格式化
     *
     * @param $sMessage 消息            
     * @param $in status
     *            状态 fail = 失败，success = 成功
     *            message 消息内容
     *            
     * @return json
     */
    protected function json2($sMessage = '', $in = []) {
        $in = array_merge ( [ 
                'status' => 'success',
                'message' => $sMessage 
        ], $in );
        header ( "Content-Type:text/html; charset=utf-8" );
        exit ( json_encode ( $in, JSON_UNESCAPED_UNICODE ) );
    }
    
    /**
     * URL 重定向
     *
     * @param string $sUrl            
     * @param number $nTime            
     * @param string $sMsg            
     * @return void
     */
    public static function urlRedirect($sUrl, $nTime = 0, $sMsg = '') {
        $sUrl = str_replace ( [ 
                "\n",
                "\r" 
        ], '', $sUrl ); // 多行URL地址支持
        if (empty ( $sMsg )) {
            $sMsg = 'Please wait for a while...';
        }
        
        if (! headers_sent ()) {
            if (0 == $nTime) {
                header ( "Location:" . $sUrl );
            } else {
                header ( "refresh:{$nTime};url={$sUrl}" );
                include (Q_PATH . '/resource/template/url.php'); // 包含跳转页面模板
            }
            exit ();
        } else {
            $sHeader = "<meta http-equiv='Refresh' content='{$nTime};URL={$sUrl}'>";
            if ($nTime == 0) {
                $sHeader = '';
            }
            include (Q_PATH . '/resource/template/url.php'); // 包含跳转页面模板
            exit ();
        }
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
    public static function redirects($sUrl, $in = []) {
        $in = array_merge ( [ 
                'params' => [ ],
                'message' => '',
                'time' => 0 
        ], $in );
        
        static::urlRedirect ( router::url ( $sUrl, $in ['params'] ), $in ['time'], $in ['message'] );
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
            exceptions::throwException ( __ ( '读取的文件不存在' ), 'queryyetsimple\http\exception' );
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
