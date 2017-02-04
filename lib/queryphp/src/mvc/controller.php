<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2016.11.19
 * @since 1.0
 */
namespace Q\mvc;

/**
 * 基类控制器
 *
 * @author Xiangmin Liu
 */
class controller {
    
    /**
     * app
     *
     * @var Q\mvc\app
     */
    protected $oApp = null;
    
    /**
     * 共享视图
     *
     * @var Q\mvc\view
     */
    protected static $oShareView = null;
    
    /**
     * in 参数
     *
     * @var array
     */
    public $in = [ ];
    
    /**
     * 构造函数
     *
     * @param Q\mvc\app $oApp            
     * @param 过滤后参数 $in            
     */
    public function __construct($oApp = null, $in = []) {
        // 检查视图和APP
        if (! $oApp) {
            $oApp = \Q::app ();
        }
        if (! self::$oShareView) {
            self::createShareView ();
        }
        
        $this->oApp = $oApp;
        
        // 属性 && 赋值
        $this->in = $in;
        $this->assign ( 'in', $in );
        $this->assign ( 'APP', $oApp );
        $this->assign ( 'CONTROLLER', $this );
    }
    
    /**
     * 赋值
     *
     * @param mixed $mixName            
     * @param mixed $Value            
     */
    public function __set($mixName, $mixValue) {
        $this->assign ( $mixName, $mixValue );
    }
    
    /**
     * 获取值
     *
     * @param string $sName            
     * @return mixed
     */
    public function &__get($sName) {
        $mixValue = $this->getAssign ( $sName );
        return $mixValue;
    }
    
    /**
     * 执行子控制器
     *
     * @param string $sActionName
     *            方法名
     * @param array $arrArgs
     *            参数
     */
    public function action($sActionName, $arrArgs = []) {
        // 判断方法是否存在
        if (method_exists ( $this, $sActionName )) {
            $this->$sActionName ();
        } else {
            
            // 判断是否已经注册过
            // if (($objAction = $this->oApp->getAction ( $this->oApp->controller_name, $sActionName ))) {
            // $this->oApp->action ( $this->oApp->controller_name, $sActionName );
            // } else {
            $sActionNameOld = $sActionName;
            $sActionName = get_class ( $this ) . '\\' . $sActionName;
            
            if (\Q::classExists ( $sActionName, false, true )) {
                $oAction = new $sActionName ();
                if (method_exists ( $oAction, 'run' )) {
                    $oAction = [ 
                            $oAction,
                            'run' 
                    ];
                    
                    // 注册控制器
                    $this->oApp->registerAction ( $this->oApp->controller_name, $sActionName, $oAction );
                    
                    // 执行
                    call_user_func_array ( $oAction, $arrArgs );
                } else {
                    \Q::throwException ( \Q::i18n ( 'Q\mvc\action 对象不存在执行入口  run' ) );
                }
            } else {
                \Q::throwException ( \Q::i18n ( '方法 %s 不存在', $sActionNameOld ) );
            }
        }
    }
    
    /**
     * 赋值
     *
     * @param 变量或变量数组集合 $Name            
     * @param string $Value            
     * @return this
     */
    public function assign($Name, $Value = '') {
        self::$oShareView->assign ( $Name, $Value );
        return $this;
    }
    
    /**
     * 加载视图文件
     *
     * @param string $sThemeFile            
     * @param array $in
     *            charset 编码
     *            content_type 类型
     *            return 是否返回 html 返回而不直接输出
     * @return mixed
     */
    public function display($sThemeFile = '', $in = []) {
        $in = array_merge ( [ 
                'charset' => 'utf-8',
                'content_type' => 'text/html',
                'return' => false 
        ], $in );
        
        return self::$oShareView->display ( $sThemeFile, $in );
    }
    
    /**
     * 取回赋值
     *
     * @param 变量名字 $sName            
     * @return mixed
     */
    protected function getAssign($sName) {
        $value = self::$oShareView->getVar ( $sName );
        return $value;
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
    protected function errorMessage($sMessage = '', $in = []) {
        $in = array_merge ( [ 
                'message' => $sMessage ?  : \Q::i18n ( '操作失败' ),
                'url' => '',
                'time' => 3 
        ], $in );
        
        $this->assign ( $in );
        $this->display ( $GLOBALS ['@option'] ['theme_action_fail'] );
        exit ();
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
    protected function successMessage($sMessage = '', $in = []) {
        $in = array_merge ( [ 
                'message' => $sMessage ?  : \Q::i18n ( '操作成功' ),
                'url' => '',
                'time' => 1 
        ], $in );
        
        $this->assign ( $in );
        $this->display ( $GLOBALS ['@option'] ['theme_action_success'] );
        exit ();
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
    protected function jsonMessage($sMessage = '', $in = []) {
        $in = array_merge ( [ 
                'status' => 'success',
                'message' => $sMessage 
        ], $in );
        
        header ( "Content-Type:text/html; charset=utf-8" );
        exit ( \Q::jsonEncode ( $in ) );
    }
    
    /**
     * URL 跳转
     *
     * @param string $sUrl            
     * @param 额外参数 $in
     *            params url 额外参数
     *            message 消息
     *            time 停留时间，0表示不停留
     * @return void
     */
    protected function urlRedirect($sUrl, $in = []) {
        $in = array_merge ( [ 
                'params' => [ ],
                'message' => '',
                'time' => 0 
        ], $in );
        
        \Q::urlRedirect ( \Q::url ( $sUrl, $in ['params'] ), $in ['time'], $in ['message'] );
    }
    
    /**
     * 实现 isPost,isGet等
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return boolean
     */
    public function __call($sMethod = '', $arrArgs = []) {
        switch ($sMethod) {
            case 'isPost' :
                return \Q::isPost ();
            case 'isGet' :
                return \Q::isGet ();
            case 'in' :
                if (! empty ( $arrArgs [0] )) {
                    return \Q::in ( $arrArgs [0], isset ( $arrArgs [1] ) ? $arrArgs [1] : 'R' );
                } else {
                    \Q::throwException ( 'Can not find method.' );
                }
            default :
                try {
                    $this->action ( $sMethod, $arrArgs );
                } catch ( Exception $e ) {
                }
        }
    }
    
    /**
     * 创建共享的视图
     *
     * @return \Q\base\view
     */
    static public function createShareView() {
        if (! self::$oShareView) {
            self::$oShareView = view::run ();
        }
        return self::$oShareView;
    }
}
