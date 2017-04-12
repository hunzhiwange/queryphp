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
 * @date 2017.03.09
 * @since 1.0
 */
namespace Q\database;

use PDO;
use PDOException;
use Q\database\select;

/**
 * 数据库连接
 *
 * @author Xiangmin Liu
 */
abstract class connect {
    
    /**
     *
     * 数据库是否已经初始化连接
     *
     * @var bool
     */
    protected $booInitConnect = false;
    
    /**
     * 所有数据库连接
     *
     * @var array
     */
    protected $arrConnect = [ ];
    
    /**
     * 当前数据库连接
     *
     * @var array
     */
    protected $objConnect = null;
    
    /**
     * PDO 预处理语句对象
     *
     * @var PDOStatement
     */
    protected $objPDOStatement = null;
    
    /**
     * 数据查询组件
     *
     * @var \Q\database\select
     */
    protected $objSelect = null;
    
    /**
     * 数据库连接参数
     *
     * @var array
     */
    protected $arrOption = [ ];
    
    /**
     * 当前数据库连接参数
     *
     * @var array
     */
    protected $arrCurrentOption = [ ];
    
    /*
     * sql 最后查询语句
     *
     * @var string
     */
    protected $strSql = '';
    
    /*
     * sql 绑定参数
     *
     * @var array
     */
    protected $arrBindParams = [ ];
    
    /*
     * sql 影响记录数量
     *
     * @var int
     */
    protected $intNumRows = 0;
    
    /**
     * SQL 监听器
     *
     * @var callable
     */
    protected static $calSqlListen = null;
    
    /**
     * 构造函数
     *
     * @param array $arrOption            
     * @return void
     */
    public function __construct($arrOption) {
        // 初始化连接
        if (! $this->booInitConnect) {
            // 标识连接
            $this->booInitConnect = true;
            
            // 记录连接参数
            $this->arrOption = $arrOption;
            
            // 查询组件
            $this->objSelect = new select ( $this );
            
            // 尝试连接主服务器
            if (! $this->writeConnect_ ()) {
                $this->throwException_ ();
            }
            
            // 连接分布式服务器
            if ($arrOption ['db_distributed'] === true) {
                if (! $this->readConnect_ ()) {
                    $this->throwException_ ();
                }
            }
        }
    }
    
    /**
     * 拦截查询静态方法转接参数并再次转接到 select 组件
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return boolean
     */
    public function __call($sMethod, $arrArgs) {
        // 调用事件
        return call_user_func_array ( [ 
                $this->objSelect,
                $sMethod 
        ], $arrArgs );
    }
    
    /**
     * 返回 Pdo 查询连接
     *
     * @param mixed $mixMaster
     *            boolean false (读服务器) true (写服务器)
     *            其它 去对应服务器连接ID 0 表示主服务器
     * @return mixed
     */
    public function getPdo($mixMaster = false) {
        if (is_bool ( $mixMaster )) {
            if ($mixMaster === false) {
                return $this->readConnect_ ();
            } else {
                return $this->writeConnect_ ();
            }
        } else {
            return isset ( $this->arrConnect [$mixMaster] ) ? $this->arrConnect [$mixMaster] : null;
        }
    }
    
    /**
     * 查询数据记录
     *
     * @param string $strSql
     *            sql 语句
     * @param array $arrBindParams
     *            sql 参数绑定
     * @param mixed $mixMaster            
     * @param int $intFetchType            
     * @param mixed $mixFetchArgument            
     * @param array $arrCtorArgs            
     * @return mixed
     */
    public function query($strSql, $arrBindParams = [], $mixMaster = false, $intFetchType = PDO::FETCH_OBJ, $mixFetchArgument = null, $arrCtorArgs = []) {
        // 记录 sql 参数
        $this->setSqlBindParams_ ( $strSql, $arrBindParams );
        
        // 验证 sql 类型
        if ($this->getSqlType ( $strSql ) != 'select') {
            $this->throwException_ ( \Q::i18n ( 'query 方法只允许运行 select sql 语句' ) );
        }
        
        try {
            // 预处理
            $this->objPDOStatement = $this->getPdo ( $mixMaster )->prepare ( $strSql );
            
            // 参数绑定
            $this->bindParams_ ( $arrBindParams );
            
            // 执行 sql
            if ($this->objPDOStatement->execute () === false) {
                $this->throwException_ ();
            }
            
            // 记录 SQL 日志
            $this->recordSqlLog_ ();
            
            // 返回结果
            return $this->fetchResult ( $intFetchType, $mixFetchArgument, $arrCtorArgs );
        } catch ( PDOException $oE ) {
            $this->throwException_ ( $oE->getMessage () );
        }
    }
    
    /**
     * 执行 sql 语句
     *
     * @param string $strSql
     *            sql 语句
     * @param array $arrBindParams
     *            sql 参数绑定
     * @return int
     */
    public function execute($strSql, $arrBindParams = []) {
        // 记录 sql 参数
        $this->setSqlBindParams_ ( $strSql, $arrBindParams );
        
        // 验证 sql 类型
        if (($strSqlType = $this->getSqlType ( $strSql )) == 'select') {
            $this->throwException_ ( \Q::i18n ( 'execute 方法不允许运行 select sql 语句' ) );
        }
        
        try {
            // 预处理
            $this->objPDOStatement = $this->getPdo ( true )->prepare ( $strSql );
            
            // 参数绑定
            $this->bindParams_ ( $arrBindParams );
            
            // 执行 sql
            if ($this->objPDOStatement->execute () === false) {
                $this->throwException_ ();
            }
            
            // 记录 SQL 日志
            $this->recordSqlLog_ ();
            
            $this->intNumRows = $this->objPDOStatement->rowCount ();
            
            if (in_array ( $strSqlType, [ 
                    'insert',
                    'replace' 
            ] )) {
                return $this->lastInsertId ();
            } else {
                return $this->intNumRows;
            }
        } catch ( PDOException $oE ) {
            $this->throwException_ ( $oE->getMessage () );
        }
    }
    
    /**
     * 执行数据库事务
     *
     * @param callable $calAction
     *            事务回调
     * @return mixed
     */
    public function transaction($calAction) {
        // 严格验证参数
        if (! \Q::varType ( $calAction, 'callback' )) {
            $this->throwException_ ( \Q::i18n ( 'transaction 必须是一个回调类型' ) );
        }
        
        // 事务过程
        $this->beginTransaction ();
        try {
            $mixResult = call_user_func_array ( $calAction, [ 
                    $this 
            ] );
            $this->commit ();
            return $mixResult;
        } catch ( Exception $oE ) {
            $this->rollBack ();
            $this->throwException_ ( $oE->getMessage () );
        }
    }
    
    /**
     * 启动事务
     *
     * @return void
     */
    public function beginTransaction() {
        if ($this->getPdo ( true )->beginTransaction () === false) {
            $this->throwException_ ();
        }
    }
    
    /**
     * 检查是否处于事务中
     *
     * @return boolean
     */
    public function inTransaction() {
        return $this->getPdo ( true )->inTransaction ();
    }
    
    /**
     * 用于非自动提交状态下面的查询提交
     *
     * @return void
     */
    public function commit() {
        if ($this->getPdo ( true )->commit () === false) {
            $this->throwException_ ();
        }
    }
    
    /**
     * 事务回滚
     *
     * @return void
     */
    public function rollBack() {
        if ($this->getPdo ( true )->rollBack () === false) {
            $this->throwException_ ();
        }
    }
    
    /**
     * 获取最后插入 ID 或者列
     *
     * @param string $strName
     *            自增序列名
     * @return string
     */
    public function lastInsertId($strName = null) {
        return $this->objConnect->lastInsertId ( $strName );
    }
    
    /**
     * 获取最近一次查询的 sql 语句
     *
     * @param bool $booWithBindParams
     *            是否和绑定参数一起返回
     * @return string
     */
    public function getLastSql($booWithBindParams = false) {
        if ($booWithBindParams === true) {
            return [ 
                    $this->strSql,
                    $this->arrBindParams 
            ];
        } else {
            return $this->strSql;
        }
    }
    
    /**
     * 获取最近一次绑定参数
     *
     * @return array
     */
    public function getBindParams() {
        return $this->arrBindParams;
    }
    
    /**
     * 返回影响记录
     *
     * @return int
     */
    public function getNumRows() {
        return $this->intNumRows;
    }
    
    /**
     * 注册 SQL 监视器
     *
     * @param callable $calSqlListen            
     * @return void
     */
    public function registerListen($calSqlListen) {
        if (! \Q::varType ( $calSqlListen, 'callback' )) {
            $this->throwException_ ( \Q::i18n ( 'SQL 监视器必须为一个回调类型' ) );
        }
        self::$calSqlListen = $calSqlListen;
    }
    
    /**
     * 释放 PDO 预处理查询
     *
     * @return void
     */
    public function freePDOStatement() {
        $this->objPDOStatement = null;
    }
    
    /**
     * 关闭数据库连接
     *
     * @return void
     */
    public function closeDatabase() {
        $this->arrConnect = [ ];
        $this->objConnect = null;
    }
    
    // ######################################################
    // ------------------- 辅助方法 start --------------------
    // ######################################################
    
    /**
     * sql 表达式格式化
     *
     * @param string $sSql            
     * @param string $sTableName            
     * @param array $arrMapping            
     * @return string
     */
    public function qualifyExpression($sSql, $sTableName, array $arrMapping = null) {
        if (empty ( $sSql )) {
            return '';
        }
        
        $arrMatches = null;
        preg_match_all ( '/\[[a-z][a-z0-9_\.]*\]|\[\*\]/i', $sSql, $arrMatches, PREG_OFFSET_CAPTURE );
        $arrMatches = reset ( $arrMatches );
        if (! is_array ( $arrMapping )) {
            $arrMapping = [ ];
        }
        
        $sOut = '';
        $nOffset = 0;
        foreach ( $arrMatches as $arrM ) {
            $nLen = strlen ( $arrM [0] );
            $sField = substr ( $arrM [0], 1, $nLen - 2 );
            $arrArray = explode ( '.', $sField );
            switch (count ( $arrArray )) {
                case 3 :
                    $sF = ! empty ( $arrMapping [$arrArray [2]] ) ? $arrMapping [$arrArray [2]] : $arrArray [2];
                    $sTable = "{$arrArray[0]}.{$arrArray[1]}";
                    break;
                case 2 :
                    $sF = ! empty ( $arrMapping [$arrArray [1]] ) ? $arrMapping [$arrArray [1]] : $arrArray [1];
                    $sTable = $arrArray [0];
                    break;
                default :
                    $sF = ! empty ( $arrMapping [$arrArray [0]] ) ? $arrMapping [$arrArray [0]] : $arrArray [0];
                    $sTable = $sTableName;
            }
            $sField = $this->qualifyTableOrColumn ( "{$sTable}.{$sF}" );
            $sOut .= substr ( $sSql, $nOffset, $arrM [1] - $nOffset ) . $sField;
            $nOffset = $arrM [1] + $nLen;
        }
        $sOut .= substr ( $sSql, $nOffset );
        
        return $sOut;
    }
    
    /**
     * 表或者字段格式化（支持别名）
     *
     * @param string $sName            
     * @param string $sAlias            
     * @param string $sAs            
     * @return string
     */
    public function qualifyTableOrColumn($sName, $sAlias = null, $sAs = null) {
        $sName = str_replace ( '`', '', $sName ); // 过滤'`'字符
        if (strpos ( $sName, '.' ) === false) { // 不包含表名字
            $sName = $this->identifierColumn ( $sName );
        } else {
            $arrArray = explode ( '.', $sName );
            foreach ( $arrArray as $nOffset => $sName ) {
                if (empty ( $sName )) {
                    unset ( $arrArray [$nOffset] );
                } else {
                    $arrArray [$nOffset] = $this->identifierColumn ( $sName );
                }
            }
            $sName = implode ( '.', $arrArray );
        }
        if ($sAlias) {
            return "{$sName} {$sAs} " . $this->identifierColumn ( $sAlias );
        } else {
            return $sName;
        }
    }
    
    /**
     * 字段格式化
     *
     * @param string $sKey            
     * @param string $sTableName            
     * @return string
     */
    public function qualifyColumn($sKey, $sTableName) {
        if (strpos ( $sKey, '.' )) {
            // 如果字段名带有 .，则需要分离出数据表名称和 schema
            $arrKey = explode ( '.', $sKey );
            switch (count ( $arrKey )) {
                case 3 :
                    $sField = $this->qualifyTableOrColumn ( "{$arrKey[0]}.{$arrKey[1]}.{$arrKey[2]}" );
                    break;
                case 2 :
                    $sField = $this->qualifyTableOrColumn ( "{$arrKey[0]}.{$arrKey[1]}" );
                    break;
            }
        } else {
            $sField = $this->qualifyTableOrColumn ( "{$sTableName}.{$sKey}" );
        }
        return $sField;
    }
    
    /**
     * 字段值格式化
     *
     * @param boolean $booQuotationMark            
     * @param mixed $mixValue            
     * @return mixed
     */
    public function qualifyColumnValue($mixValue, $booQuotationMark = true) {
        if (is_array ( $mixValue )) { // 数组，递归
            foreach ( $mixValue as $nOffset => $sV ) {
                $mixValue [$nOffset] = $this->qualifyColumnValue ( $sV );
            }
            return $mixValue;
        }
        
        if (is_int ( $mixValue )) {
            return $mixValue;
        }
        if (is_bool ( $mixValue )) {
            return $mixValue ? true : false;
        }
        if (is_null ( $mixValue )) { // Null值
            return null;
        }
        
        $mixValue = trim ( $mixValue );
        
        // 问号占位符
        if ($mixValue == '[?]') {
            return '?';
        }
        
        // [:id] 占位符
        if (preg_match ( '/^\[:[a-z][a-z0-9_\-\.]*\]$/i', $mixValue, $arrMatche )) {
            return trim ( $arrMatche [0], '[]' );
        }
        
        if ($booQuotationMark === true) {
            return "'" . addslashes ( $mixValue ) . "'";
        } else {
            return $mixValue;
        }
    }
    
    /**
     * sql 字段格式化
     *
     * @return string
     */
    abstract public function identifierColumn($sName);
    
    /**
     * 返回当前配置连接信息（方便其他组件调用设置为 public）
     *
     * @param string $strOptionName            
     * @return array
     */
    public function getCurrentOption($strOptionName = null) {
        if (is_null ( $strOptionName )) {
            return $this->arrCurrentOption;
        } else {
            return isset ( $this->arrCurrentOption [$strOptionName] ) ? $this->arrCurrentOption [$strOptionName] : null;
        }
    }
    
    /**
     * 分析 sql 类型数据
     *
     * @param string $strSql            
     * @return string
     */
    public function getSqlType($strSql) {
        $strSql = trim ( $strSql );
        foreach ( [ 
                'select',
                'show',
                'delete',
                'insert',
                'replace',
                'update' 
        ] as $strType ) {
            if (stripos ( $strSql, $strType ) === 0) {
                if ($strType == 'show') {
                    $strType = 'select';
                }
                return $strType;
            }
        }
        return 'statement';
    }
    
    /**
     * 分析绑定参数类型数据
     *
     * @param mixed $mixValue            
     * @return string
     */
    public function getBindParamType($mixValue) {
        // 参数
        switch (true) {
            case is_int ( $mixValue ) :
                return PDO::PARAM_INT;
                break;
            case is_bool ( $mixValue ) :
                return PDO::PARAM_BOOL;
                break;
            default :
                return PDO::PARAM_STR;
                break;
        }
    }
    
    // ######################################################
    // -------------------- 辅助方法 end ---------------------
    // ######################################################
    
    // ######################################################
    // ------------------- 私有方法 start --------------------
    // ######################################################
    
    /**
     * 连接主服务器
     *
     * @return Pdo
     */
    protected function writeConnect_() {
        // 判断是否已经连接
        if (! empty ( $this->arrConnect [0] )) {
            return $this->objConnect = $this->arrConnect [0];
        }
        
        // 没有连接开始请求连接
        if (! ($objPdo = $this->commonConnect_ ( $this->arrOption ['db_master'], 0 ))) {
            return false;
        }
        
        // 当前连接
        return $this->objConnect = $objPdo;
    }
    
    /**
     * 连接读服务器
     *
     * @return Pdo
     */
    protected function readConnect_() {
        // 未开启分布式服务器连接或则没有读服务器，直接连接写服务器
        if ($this->arrOption ['db_distributed'] === false || empty ( $this->arrOption ['db_slave'] )) {
            return $this->writeConnect_ ();
        }
        
        // 只有主服务器,主服务器必须先连接,未连接过附属服务器
        if (count ( $this->arrConnect ) == 1) {
            foreach ( $this->arrOption ['slave'] as $arrRead ) {
                $this->commonConnect_ ( $arrRead, null );
            }
            
            // 没有连接成功的读服务器
            if (count ( $this->arrConnect ) < 2) {
                return $this->writeConnect_ ();
            }
        }
        
        // 如果为读写分离,去掉主服务器
        $arrConnect = $this->arrConnect;
        if ($this->arrOption ['db_rw_separate'] === true) {
            unset ( $arrConnect [0] );
        }
        
        // 随机在已连接的 Slave 机中选择一台
        return $this->objConnect = $arrConnect [floor ( mt_rand ( 0, count ( $arrConnect ) - 1 ) )];
    }
    
    /**
     * 连接数据库
     *
     * @param array $arrOption            
     * @param string $nLinkid            
     * @return mixed
     */
    protected function commonConnect_($arrOption = '', $nLinkid = null) {
        // 数据库连接 ID
        if ($nLinkid === null) {
            $nLinkid = count ( $this->arrConnect );
        }
        
        // 已经存在连接
        if (! empty ( $this->arrConnect [$nLinkid] )) {
            return $this->arrConnect [$nLinkid];
        }
        
        // 数据库长连接
        if ($arrOption ['db_persistent']) {
            $arrOption [PDO::ATTR_PERSISTENT] = true;
        }
        
        try {
            $this->setCurrentOption_ ( $arrOption );
            return $this->arrConnect [$nLinkid] = new \PDO ( $this->parseDsn_ ( $arrOption ), $arrOption ['db_user'], $arrOption ['db_password'], $arrOption ['db_params'] );
        } catch ( PDOException $oE ) {
            return false;
        }
    }
    
    /**
     * pdo　参数绑定
     *
     * @param array $arrBindParams
     *            绑定参数
     * @return void
     */
    protected function bindParams_(array $arrBindParams = []) {
        foreach ( $arrBindParams as $mixKey => $mixVal ) {
            // 占位符
            $mixKey = is_numeric ( $mixKey ) ? $mixKey + 1 : ':' . $mixKey;
            if (is_array ( $mixVal )) {
                $strParam = $mixVal [1];
                $mixVal = $mixVal [0];
            } else {
                $strParam = PDO::PARAM_STR;
            }
            
            if ($this->objPDOStatement->bindValue ( $mixKey, $mixVal, $strParam ) === false) {
                $this->throwException_ ( \Q::i18n ( 'sql %s 参数绑定失败: %s', $this->strSql, \Q::dump ( $arrBindParams, true ) ) );
            }
        }
    }
    
    /**
     * 获得数据集
     *
     * @param int $intFetchType            
     * @param mixed $mixFetchArgument            
     * @param array $arrCtorArgs            
     * @return array
     */
    protected function fetchResult($intFetchType = PDO::FETCH_OBJ, $mixFetchArgument = null, $arrCtorArgs = []) {
        $arrArgs = [ 
                $intFetchType 
        ];
        if ($mixFetchArgument) {
            $arrArgs [] = $mixFetchArgument;
            if ($arrCtorArgs) {
                $arrArgs [] = $arrCtorArgs;
            }
        }
        return call_user_func_array ( [ 
                $this->objPDOStatement,
                'fetchAll' 
        ], $arrArgs );
    }
    
    /**
     * 设置 sql 绑定参数
     *
     * @return void
     */
    protected function setSqlBindParams_($strSql, $arrBindParams = []) {
        $this->strSql = $strSql;
        $this->arrBindParams = $arrBindParams;
    }
    
    /**
     * 设置当前数据库连接信息
     *
     * @param array $arrOption            
     * @return void
     */
    protected function setCurrentOption_($arrOption) {
        $this->arrCurrentOption = $arrOption;
    }
    
    /**
     * 记录 SQL 日志
     *
     * @return void
     */
    protected function recordSqlLog_() {
        // SQL 监视器
        if (self::$calSqlListen !== null) {
            call_user_func_array ( self::$calSqlListen, [ 
                    $this 
            ] );
        }
        
        // 记录 SQL 日志
        $arrLastSql = $this->getLastSql ( true );
        \Q::log ( $arrLastSql [0] . (! empty ( $arrLastSql [1] ) ? ' @ ' . \Q::jsonEncode ( $arrLastSql [1] ) : ''), 'sql' );
    }
    
    /**
     * 数据查询异常，抛出错误
     *
     * @param string $strError
     *            错误信息
     * @return string
     */
    protected function throwException_($strError = '') {
        if ($this->objPDOStatement) {
            $arrTemp = $this->objPDOStatement->errorInfo ();
            $strError = '(' . $arrTemp [1] . ')' . $arrTemp [2] . "\r\n" . $strError;
        }
        \Q::throwException ( $strError, 'Q\database\exception' );
    }
    
    // ######################################################
    // -------------------- 私有方法 end ---------------------
    // ######################################################
    
    /**
     * 析构方法
     *
     * @return void
     */
    public function __destruct() {
        // 释放 PDO 预处理查询
        $this->freePDOStatement ();
        
        // 关闭数据库连接
        $this->closeDatabase ();
    }
}
