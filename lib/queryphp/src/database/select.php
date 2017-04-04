<?php
/*
 * [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
 * ©2010-2017 http://queryphp.com All rights reserved.
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @version $$
 * @date 2017.03.09
 * @since 1.0
 */
namespace Q\database;

use PDO;

/**
 * 数据库查询器
 *
 * @author Xiangmin Liu
 */
class select {
    
    /**
     * 数据库连接
     *
     * @var Q\database\connect
     */
    private $objConnect = null;
    
    /**
     * 绑定参数
     *
     * @var array
     */
    private $arrBindParams = [ ];
    
    /**
     * 连接参数
     *
     * @var array
     */
    private $arrOption = [ ];
    
    /**
     * 查询类型
     *
     * @var array
     */
    private $arrQueryParams = [ ];
    
    /**
     * 字段映射
     *
     * @var array
     */
    private $arrColumnsMapping = [ ];
    
    /**
     * 支持的聚合类型
     *
     * @var array
     */
    private static $arrAggregateTypes = [ 
            'COUNT' => 'COUNT',
            'MAX' => 'MAX',
            'MIN' => 'MIN',
            'AVG' => 'AVG',
            'SUM' => 'SUM' 
    ];
    
    /**
     * 支持的 join 类型
     *
     * @var array
     */
    private static $arrJoinTypes = [ 
            'inner join' => 'inner join',
            'left join' => 'left join',
            'right join' => 'right join',
            'full join' => 'full join',
            'cross join' => 'cross join',
            'natural join' => 'natural join' 
    ];
    
    /**
     * 支持的 union 类型
     *
     * @var array
     */
    private static $arrUnionTypes = [ 
            'UNION' => 'UNION',
            'UNION ALL' => 'UNION ALL' 
    ];
    
    /**
     * 支持的 index 类型
     *
     * @var array
     */
    private static $arrIndexTypes = [ 
            'FORCE' => 'FORCE',
            'IGNORE' => 'IGNORE' 
    ];
    
    /**
     * 连接参数
     *
     * @var array
     */
    private static $arrOptionDefault = [ 
            'prefix' => [ ],
            'distinct' => false,
            'columns' => [ ],
            'aggregate' => [ ],
            'union' => [ ],
            'table' => null,
            'from' => [ ],
            'index' => [ ],
            'where' => null,
            'group' => [ ],
            'having' => null,
            'order' => [ ],
            'limitcount' => null,
            'limitoffset' => null,
            'limitquery' => true,
            'forupdate' => false 
    ];
    
    /**
     * 查询类型
     *
     * @var array
     */
    private static $arrQueryParamsDefault = [
            // PDO:fetchAll 参数
            'fetch_type' => [ 
                    'fetch_type' => PDO::FETCH_OBJ,
                    'fetch_argument' => null,
                    'ctor_args' => [ ] 
            ],
            
            // 查询主服务器
            'master' => false,
            
            // 每一项记录以对象返回
            'as_class' => null,
            
            // 数组或者默认
            'as_default' => true,
            
            // 以对象集合方法返回
            'as_collection' => false 
    ];
    
    /**
     * 原生 sql 类型
     *
     * @var string
     */
    private $strNativeSql = 'select';
    
    /**
     * And 逻辑运算符
     *
     * @var string
     */
    const LOGIC_AND = 'and';
    
    /**
     * Or 逻辑运算符
     *
     * @var string
     */
    const LOGIC_OR = 'or';
    
    /**
     * 逻辑分组左符号
     *
     * @var string
     */
    const LOGIC_GROUP_LEFT = '(';
    
    /**
     * 逻辑分组右符号
     *
     * @var string
     */
    const LOGIC_GROUP_RIGHT = ')';
    
    /**
     * 条件逻辑连接符
     *
     * @var string
     */
    public $strConditionLogic = 'and';
    
    /**
     * 条件逻辑类型
     *
     * @var string
     */
    private $strConditionType = 'where';
    
    /**
     * 当前表信息
     *
     * @var string
     */
    private $strCurrentTable = '';
    
    /**
     * 构造函数
     *
     * @param Q\database\connect $objConnect            
     * @return void
     */
    public function __construct($objConnect) {
        $this->objConnect = $objConnect;
        $this->initOption_ ();
    }
    
    /**
     * 拦截一些别名和快捷方式
     *
     * @param 方法名 $sMethod            
     * @param 参数 $arrArgs            
     * @return boolean
     */
    public function __call($sMethod, $arrArgs) {
        // where 别名支持
        if (in_array ( $sMethod, [ 
                'whereBetween',
                'whereNotBetween',
                'whereIn',
                'whereNotIn',
                'whereNull',
                'whereNotNull' 
        ] )) {
            $this->setTypeAndLogic_ ( 'where', self::LOGIC_AND );
            array_unshift ( $arrArgs, str_replace ( 'not', 'not ', strtolower ( ltrim ( $sMethod, 'where' ) ) ) );
            return call_user_func_array ( [ 
                    $this,
                    'aliasCondition_' 
            ], $arrArgs );
        }
        
        // having 别名支持
        if (in_array ( $sMethod, [ 
                'havingBetween',
                'havingNotBetween',
                'havingIn',
                'havingNotIn',
                'havingNull',
                'havingNotNull' 
        ] )) {
            $this->setTypeAndLogic_ ( 'having', self::LOGIC_AND );
            array_unshift ( $arrArgs, str_replace ( 'not', 'not ', strtolower ( ltrim ( $sMethod, 'having' ) ) ) );
            return call_user_func_array ( [ 
                    $this,
                    'aliasCondition_' 
            ], $arrArgs );
        }        

        // join 别名支持
        elseif (in_array ( $sMethod, [ 
                'innerJoin',
                'leftJoin',
                'rightJoin',
                'fullJoin',
                'crossJoin',
                'naturalJoin' 
        ] )) {
            array_unshift ( $arrArgs, str_replace ( 'join', ' join', strtolower ( $sMethod ) ) );
            return call_user_func_array ( [ 
                    $this,
                    'join_' 
            ], $arrArgs );
        }
        
        \Q::throwException ( \Q::i18n ( 'select 没有实现魔法方法 %s.', $sMethod ) );
    }
    
    // ######################################################
    // ------------------ 返回查询结果 start -------------------
    // ######################################################
    
    /**
     * 原生 sql 查询数据 select
     *
     * @param null|string $mixData            
     * @return mixed
     */
    public function select($mixData = null) {
        $this->setNativeSql_ ( 'select' );
        return call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], func_get_args () );
    }
    
    /**
     * 原生 sql 插入数据 insert
     *
     * @param null|string $mixData            
     * @return int 最后插入ID
     */
    public function insert($mixData = null) {
        $this->setNativeSql_ ( 'insert' );
        return call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], func_get_args () );
    }
    
    /**
     * 原生 sql 更新数据 update
     *
     * @param null|string $mixData            
     * @return int 影响记录
     */
    public function update($mixData = null) {
        $this->setNativeSql_ ( 'update' );
        return call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], func_get_args () );
    }
    
    /**
     * 原生 sql 删除数据 delete
     *
     * @param null|string $mixData            
     * @return int 影响记录
     */
    public function delete($mixData = null) {
        $this->setNativeSql_ ( 'delete' );
        return call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], func_get_args () );
    }
    
    /**
     * 原生 sql 无返回一般 sql 声明 statement
     *
     * @param null|string $mixData            
     * @return void
     */
    public function statement($mixData = null) {
        $this->setNativeSql_ ( 'statement' );
        call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], func_get_args () );
    }
    
    /**
     * 返回一条记录
     *
     * @return mixed
     */
    public function getOne() {
        return $this->one ()->query_ ();
    }
    
    /**
     * 返回所有记录
     *
     * @return mixed
     */
    public function getAll() {
        if ($this->arrOption ['limitquery']) {
            return $this->query_ ();
        } else {
            return $this->all ()->query_ ();
        }
    }
    
    /**
     * 返回最后几条记录
     *
     * @param mixed $nNum            
     * @return mixed
     */
    public function get($nNum = null) {
        if (! is_null ( $nNum )) {
            return $this->top ( $nNum )->query_ ();
        } else {
            return $this->query_ ();
        }
    }
    
    /**
     * 总记录数
     *
     * @param string $strField            
     * @param string $sAlias            
     * @return int
     */
    public function getCount($strField = '*', $sAlias = 'row_count') {
        $arrRow = ( array ) $this->count ( $strField, $sAlias )->get ();
        return intval ( $arrRow [$sAlias] );
    }
    
    /**
     * 平均数
     *
     * @param string $strField            
     * @param string $sAlias            
     * @return number
     */
    public function getAvg($strField, $sAlias = 'avg_value') {
        $arrRow = ( array ) $this->avg ( $strField, $sAlias )->get ();
        return ( float ) $arrRow [$sAlias];
    }
    
    /**
     * 最大值
     *
     * @param string $strField            
     * @param string $sAlias            
     * @return number
     */
    public function getMax($strField, $sAlias = 'max_value') {
        $arrRow = ( array ) $this->max ( $strField, $sAlias )->get ();
        return ( float ) $arrRow [$sAlias];
    }
    
    /**
     * 最小值
     *
     * @param string $strField            
     * @param string $sAlias            
     * @return number
     */
    public function getMin($strField, $sAlias = 'min_value') {
        $arrRow = ( array ) $this->min ( $strField, $sAlias )->get ();
        return ( float ) $arrRow [$sAlias];
    }
    
    /**
     * 合计
     *
     * @param string $strField            
     * @param string $sAlias            
     * @return number
     */
    public function getSum($strField, $sAlias = 'sum_value') {
        $arrRow = ( array ) $this->sum ( $strField, $sAlias )->get ();
        return $arrRow [$sAlias];
    }
    
    // ######################################################
    // ------------------- 返回查询结果 end --------------------
    // ######################################################
    
    // ######################################################
    // ------------------ 构造查询条件 start -------------------
    // ######################################################
    
    /**
     * 设置是否查询主服务器
     *
     * @param boolean $booMaster            
     * @return $this
     */
    public function asMaster($booMaster = false) {
        $this->arrQueryParams ['master'] = $booMaster;
        return $this;
    }
    
    /**
     * 设置查询结果类型
     *
     * @param mixed $mixType            
     * @param mixed $mixValue            
     * @return $this
     */
    public function asFetchType($mixType, $mixValue = null) {
        if (is_array ( $mixType )) {
            $this->arrQueryParams ['fetch_type'] = array_merge ( $this->arrQueryParams ['fetch_type'], $mixType );
        } else {
            if (is_null ( $mixValue )) {
                $this->arrQueryParams ['fetch_type'] ['fetch_type'] = $mixType;
            } else {
                $this->arrQueryParams ['fetch_type'] [$mixType] = $mixValue;
            }
        }
        return $this;
    }
    
    /**
     * 设置以类返会结果
     *
     * @param string $sClassName            
     * @return $this
     */
    public function asClass($sClassName) {
        $this->arrQueryParams ['as_class'] = $sClassName;
        $this->arrQueryParams ['as_default'] = false;
        return $this;
    }
    
    /**
     * 设置默认形式返回
     *
     * @return $this
     */
    public function asDefault() {
        $this->arrQueryParams ['as_class'] = null;
        $this->arrQueryParams ['as_default'] = true;
        return $this;
    }
    
    /**
     * 设置是否以集合返回
     *
     * @param string $bAsCollection            
     * @return $this
     */
    public function asCollection($bAsCollection = true) {
        $this->arrQueryParams ['as_collection'] = $bAsCollection;
        return $this;
    }
    
    /**
     * 重置查询条件
     *
     * @param string $sOption            
     * @return $this
     */
    public function reset($sOption = null) {
        if ($sOption == null) {
            $this->initOption_ ();
        } elseif (array_key_exists ( $sOption, self::$arrOptionDefault )) {
            $this->arrOption [$sOption] = self::$arrOptionDefault [$sOption];
        }
        return $this;
    }
    
    /**
     * prefix 查询
     *
     * @param string|array $mixPrefix            
     * @return $this
     */
    public function prefix($mixPrefix) {
        $mixPrefix = \Q::normalize ( $mixPrefix );
        foreach ( $mixPrefix as $strValue ) {
            $strValue = \Q::normalize ( $strValue );
            foreach ( $strValue as $strTemp ) {
                $strTemp = trim ( $strTemp );
                if (empty ( $strTemp )) {
                    continue;
                }
                $this->arrOption ['prefix'] [] = strtoupper ( $strTemp );
            }
        }
        return $this;
    }
    
    /**
     * 添加一个要查询的表及其要查询的字段
     *
     * @param mixed $mixTable            
     * @param string|array $mixCols            
     * @return $this
     */
    public function table($mixTable, $mixCols = '*') {
        $this->setCurrentTable_ ( $mixTable );
        return $this->join_ ( 'inner join', $mixTable, $mixCols );
    }
    
    /**
     * 添加字段
     *
     * @param mixed $mixCols            
     * @param string $strTable            
     * @return $this
     */
    public function columns($mixCols = '*', $strTable = null) {
        if (is_null ( $strTable )) {
            $strTable = $this->getCurrentTable_ ();
        }
        $this->addCols_ ( $strTable, $mixCols );
        return $this;
    }
    
    /**
     * 设置字段
     *
     * @param mixed $mixCols            
     * @param string $strTable            
     * @return $this
     */
    public function setColumns($mixCols = '*', $strTable = null) {
        if (is_null ( $strTable )) {
            $strTable = $this->getCurrentTable_ ();
        }
        $this->arrOption ['columns'] = [ ];
        $this->addCols_ ( $strTable, $mixCols );
        return $this;
    }
    
    /**
     * 设置一个或多个字段的映射名，如果 $sMappingTo 为 NULL，则取消对指定字段的映射
     *
     * @param array|string $mixName            
     * @param string|null $sMappingTo            
     * @return $this
     */
    public function columnsMapping($mixName, $sMappingTo = NULL) {
        if (is_array ( $mixName )) {
            $this->arrColumnsMapping = array_merge ( $this->arrColumnsMapping, $mixName );
        } else {
            if (empty ( $sMappingTo )) {
                if (isset ( $this->arrColumnsMapping [$mixName] )) {
                    unset ( $this->arrColumnsMapping [$mixName] );
                }
            } else {
                $this->arrColumnsMapping [$mixName] = $sMappingTo;
            }
        }
        return $this;
    }
    
    /**
     * where 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function where($mixCond /* args */){
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, self::LOGIC_AND );
        array_unshift ( $arrArgs, 'where' );
        return call_user_func_array ( [ 
                $this,
                'aliasTypeAndLogic_' 
        ], $arrArgs );
    }
    
    /**
     * orWhere 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function orWhere($mixCond /* args */){
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, self::LOGIC_OR );
        array_unshift ( $arrArgs, 'where' );
        return call_user_func_array ( [ 
                $this,
                'aliasTypeAndLogic_' 
        ], $arrArgs );
    }
    
    /**
     * exists 方法支持
     *
     * @return $this
     */
    public function whereExists(/* args */){
        $arrArgs = func_get_args ();
        return call_user_func_array ( [ 
                $this,
                'addConditions_' 
        ], [ 
                [ 
                        'exists__' => $arrArgs [0] 
                ] 
        ] );
    }
    
    /**
     * 参数绑定支持
     *
     * @param mixed $mixName            
     * @param mixed $mixValue            
     * @param int $intType            
     * @return $this
     */
    public function bind($mixName, $mixValue = null, $intType = PDO::PARAM_STR) {
        if (is_array ( $mixName )) {
            foreach ( $mixName as $mixKey => $mixValue ) {
                if (! is_array ( $mixValue )) {
                    $mixTemp = $mixValue;
                    $mixValue = [ 
                            $mixTemp,
                            $intType 
                    ];
                }
                $this->arrBindParams [$mixKey] = $mixValue;
            }
        } else {
            $this->arrBindParams [$mixName] = [ 
                    $mixValue,
                    $intType 
            ];
        }
        return $this;
    }
    
    /**
     * index 强制索引（或者忽略索引）
     *
     * @param string|array $mixIndex            
     * @param string $sType            
     * @return $this
     */
    public function forceIndex($mixIndex, $sType = 'FORCE') {
        if (! isset ( self::$arrIndexTypes [$sType] )) {
            \Q::throwException ( \Q::i18n ( '无效的 Index 类型 %s', $sType ) );
        }
        $sType = strtoupper ( $sType );
        $mixIndex = \Q::normalize ( $mixIndex );
        foreach ( $mixIndex as $strValue ) {
            $strValue = \Q::normalize ( $strValue );
            foreach ( $strValue as $strTemp ) {
                $strTemp = trim ( $strTemp );
                if (empty ( $strTemp )) {
                    continue;
                }
                if (empty ( $this->arrOption ['index'] [$sType] )) {
                    $this->arrOption ['index'] [$sType] = [ ];
                }
                $this->arrOption ['index'] [$sType] [] = $strTemp;
            }
        }
        return $this;
    }
    
    /**
     * index 忽略索引
     *
     * @param string|array $mixIndex            
     * @return $this
     */
    public function ignoreIndex($mixIndex) {
        return $this->forceIndex ( $mixIndex, 'IGNORE' );
    }
    
    /**
     * join 查询
     *
     * @param mixed $mixTable
     *            同 table $mixTable
     * @param string|array $mixCols
     *            同 table $mixCols
     * @param mixed $mixCond
     *            同 where $mixCond
     * @return $this
     */
    public function join($mixTable, $mixCols = '*', $mixCond /* args */){
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'inner join' );
        return call_user_func_array ( [ 
                $this,
                'join_' 
        ], $arrArgs );
    }
    
    /**
     * 添加一个 UNION 查询
     *
     * @param array|string|callable $mixSelect            
     * @param string $sType            
     * @return $this
     */
    public function union($mixSelect, $sType = 'UNION') {
        if (! isset ( self::$arrUnionTypes [$sType] )) {
            \Q::throwException ( \Q::i18n ( '无效的 UNION 类型 %s', $sType ) );
        }
        
        if (! is_array ( $mixSelect )) {
            $mixTemp = $mixSelect;
            $mixSelect = [ ];
            $mixSelect [] = $mixTemp;
        }
        
        foreach ( $mixSelect as $mixTemp ) {
            $this->arrOption ['union'] [] = [ 
                    $mixTemp,
                    $sType 
            ];
        }
        
        return $this;
    }
    
    /**
     * 添加一个 UNION ALL 查询
     *
     * @param array|string|callable $mixSelect            
     * @return $this
     */
    public function unionAll($mixSelect) {
        return $this->union ( $mixSelect, 'UNION ALL' );
    }
    
    /**
     * 指定 GROUP BY 子句
     *
     * @param string|array $mixExpr            
     * @return $this
     */
    public function groupBy($mixExpr) {
        // 处理条件表达式
        if (is_string ( $mixExpr ) && strpos ( $mixExpr, ',' ) !== false && strpos ( $mixExpr, '{' ) !== false && preg_match_all ( '/{(.+?)}/', $mixExpr, $arrRes )) {
            $mixExpr = str_replace ( $arrRes [1] [0], base64_encode ( $arrRes [1] [0] ), $mixExpr );
        }
        $mixExpr = \Q::normalize ( $mixExpr );
        // 还原
        if (! empty ( $arrRes )) {
            foreach ( $arrRes [1] as $strTemp ) {
                $mixExpr [array_search ( '{' . base64_encode ( $strTemp ) . '}', $mixExpr, true )] = '{' . $strTemp . '}';
            }
        }
        
        $strTableName = $this->getCurrentTable_ ();
        foreach ( $mixExpr as $strValue ) {
            // 处理条件表达式
            if (is_string ( $strValue ) && strpos ( $strValue, ',' ) !== false && strpos ( $strValue, '{' ) !== false && preg_match_all ( '/{(.+?)}/', $strValue, $arrResTwo )) {
                $strValue = str_replace ( $arrResTwo [1] [0], base64_encode ( $arrResTwo [1] [0] ), $strValue );
            }
            $strValue = \Q::normalize ( $strValue );
            // 还原
            if (! empty ( $arrResTwo )) {
                foreach ( $arrResTwo [1] as $strTemp ) {
                    $strValue [array_search ( '{' . base64_encode ( $strTemp ) . '}', $strValue, true )] = '{' . $strTemp . '}';
                }
            }
            
            foreach ( $strValue as $strTemp ) {
                $strTemp = trim ( $strTemp );
                if (empty ( $strTemp )) {
                    continue;
                }
                
                // 表达式支持
                if (strpos ( $strTemp, '{' ) !== false && preg_match ( '/^{(.+?)}$/', $strTemp, $arrResThree )) {
                    $strTemp = $this->objConnect->qualifyExpression ( $arrResThree [1], $strTableName, $this->arrColumnsMapping );
                } elseif (! preg_match ( '/\(.*\)/', $strTemp )) {
                    $sCurrentTableName = $strTableName;
                    if (preg_match ( '/(.+)\.(.+)/', $strTemp, $arrMatch )) {
                        $sCurrentTableName = $arrMatch [1];
                        $strTemp = $arrMatch [2];
                    }
                    if (isset ( $this->arrColumnsMapping [$strTemp] )) {
                        $strTemp = $this->arrColumnsMapping [$strTemp];
                    }
                    $strTemp = $this->objConnect->qualifyTableOrColumn ( "{$sCurrentTableName}.{$strTemp}" );
                }
                $this->arrOption ['group'] [] = $strTemp;
            }
        }
        
        return $this;
    }
    
    /**
     * 添加一个 HAVING 条件
     *
     * < 参数规范参考 where()方法 >
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function having($mixCond /* args */){
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, self::LOGIC_AND );
        array_unshift ( $arrArgs, 'having' );
        return call_user_func_array ( [ 
                $this,
                'aliasTypeAndLogic_' 
        ], $arrArgs );
    }
    
    /**
     * orHaving 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function orHaving($mixCond /* args */){
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, self::LOGIC_OR );
        array_unshift ( $arrArgs, 'having' );
        return call_user_func_array ( [ 
                $this,
                'aliasTypeAndLogic_' 
        ], $arrArgs );
    }
    
    /**
     * 添加排序
     *
     * @param string|array $mixExpr            
     * @param string $sOrderDefault            
     * @return $this
     */
    public function orderBy($mixExpr, $sOrderDefault = 'ASC') {
        // 格式化为大写
        $sOrderDefault = strtoupper ( $sOrderDefault );
        
        // 处理条件表达式
        if (is_string ( $mixExpr ) && strpos ( $mixExpr, ',' ) !== false && strpos ( $mixExpr, '{' ) !== false && preg_match_all ( '/{(.+?)}/', $mixExpr, $arrRes )) {
            $mixExpr = str_replace ( $arrRes [1] [0], base64_encode ( $arrRes [1] [0] ), $mixExpr );
        }
        $mixExpr = \Q::normalize ( $mixExpr );
        // 还原
        if (! empty ( $arrRes )) {
            foreach ( $arrRes [1] as $strTemp ) {
                $mixExpr [array_search ( '{' . base64_encode ( $strTemp ) . '}', $mixExpr, true )] = '{' . $strTemp . '}';
            }
        }
        
        $strTableName = $this->getCurrentTable_ ();
        foreach ( $mixExpr as $strValue ) {
            // 处理条件表达式
            if (is_string ( $strValue ) && strpos ( $strValue, ',' ) !== false && strpos ( $strValue, '{' ) !== false && preg_match_all ( '/{(.+?)}/', $strValue, $arrResTwo )) {
                $strValue = str_replace ( $arrResTwo [1] [0], base64_encode ( $arrResTwo [1] [0] ), $strValue );
            }
            $strValue = \Q::normalize ( $strValue );
            // 还原
            if (! empty ( $arrResTwo )) {
                foreach ( $arrResTwo [1] as $strTemp ) {
                    $strValue [array_search ( '{' . base64_encode ( $strTemp ) . '}', $strValue, true )] = '{' . $strTemp . '}';
                }
            }
            foreach ( $strValue as $strTemp ) {
                $strTemp = trim ( $strTemp );
                if (empty ( $strTemp )) {
                    continue;
                }
                
                // 表达式支持
                if (strpos ( $strTemp, '{' ) !== false && preg_match ( '/^{(.+?)}$/', $strTemp, $arrResThree )) {
                    $strTemp = $this->objConnect->qualifyExpression ( $arrResThree [1], $strTableName, $this->arrColumnsMapping );
                    if (preg_match ( '/(.*\W)(' . 'ASC' . '|' . 'DESC' . ')\b/si', $strTemp, $arrMatch )) {
                        $strTemp = trim ( $arrMatch [1] );
                        $sSort = strtoupper ( $arrMatch [2] );
                    } else {
                        $sSort = $sOrderDefault;
                    }
                    $this->arrOption ['order'] [] = $strTemp . ' ' . $sSort;
                } else {
                    $sCurrentTableName = $strTableName;
                    $sSort = $sOrderDefault;
                    if (preg_match ( '/(.*\W)(' . 'ASC' . '|' . 'DESC' . ')\b/si', $strTemp, $arrMatch )) {
                        $strTemp = trim ( $arrMatch [1] );
                        $sSort = strtoupper ( $arrMatch [2] );
                    }
                    
                    if (! preg_match ( '/\(.*\)/', $strTemp )) {
                        if (preg_match ( '/(.+)\.(.+)/', $strTemp, $arrMatch )) {
                            $sCurrentTableName = $arrMatch [1];
                            $strTemp = $arrMatch [2];
                        }
                        if (isset ( $this->arrColumnsMapping [$strTemp] )) {
                            $strTemp = $this->arrColumnsMapping [$strTemp];
                        }
                        $strTemp = $this->objConnect->qualifyTableOrColumn ( "{$sCurrentTableName}.{$strTemp}" );
                    }
                    $this->arrOption ['order'] [] = $strTemp . ' ' . $sSort;
                }
            }
        }
        
        return $this;
    }
    
    /**
     * 创建一个 SELECT DISTINCT 查询
     *
     * @param bool $flag
     *            指示是否是一个 SELECT DISTINCT 查询（默认 true）
     * @return $this
     */
    public function distinct($bFlag = true) {
        $this->arrOption ['distinct'] = ( bool ) $bFlag;
        return $this;
    }
    
    /**
     * 总记录数
     *
     * @param string $strField            
     * @param string $sAlias            
     * @return $this
     */
    public function count($strField = '*', $sAlias = 'row_count') {
        return $this->addAggregate_ ( 'COUNT', $strField, $sAlias );
    }
    
    /**
     * 平均数
     *
     * @param string $strField            
     * @param string $sAlias            
     * @return $this
     */
    public function avg($strField, $sAlias = 'avg_value') {
        return $this->addAggregate_ ( 'AVG', $strField, $sAlias );
    }
    
    /**
     * 最大值
     *
     * @param string $strField            
     * @param string $sAlias            
     * @return $this
     */
    public function max($strField, $sAlias = 'max_value') {
        return $this->addAggregate_ ( 'MAX', $strField, $sAlias );
    }
    
    /**
     * 最小值
     *
     * @param string $strField            
     * @param string $sAlias            
     * @return $this
     */
    public function min($strField, $sAlias = 'min_value') {
        return $this->addAggregate_ ( 'MIN', $strField, $sAlias );
    }
    
    /**
     * 合计
     *
     * @param string $strField            
     * @param string $sAlias            
     * @return $this
     */
    public function sum($strField, $sAlias = 'sum_value') {
        return $this->addAggregate_ ( 'SUM', $strField, $sAlias );
    }
    
    /**
     * 指示仅查询第一个符合条件的记录
     *
     * @return $this
     */
    public function one() {
        $this->arrOption ['limitcount'] = 1;
        $this->arrOption ['limitoffset'] = null;
        $this->arrOption ['limitquery'] = false;
        return $this;
    }
    
    /**
     * 指示查询所有符合条件的记录
     *
     * @return $this
     */
    public function all() {
        $this->arrOption ['limitcount'] = null;
        $this->arrOption ['limitoffset'] = null;
        $this->arrOption ['limitquery'] = true;
        return $this;
    }
    
    /**
     * 查询几条记录
     *
     * @param number $nCount            
     * @return $this
     */
    public function top($nCount = 30) {
        return $this->limit ( 0, $nCount );
    }
    
    /**
     * limit 限制条数
     *
     * @param number $nOffset            
     * @param number $nCount            
     * @return $this
     */
    public function limit($nOffset = 0, $nCount = 30) {
        $this->arrOption ['limitcount'] = abs ( intval ( $nCount ) );
        $this->arrOption ['limitoffset'] = abs ( intval ( $nOffset ) );
        $this->arrOption ['limitquery'] = true;
        return $this;
    }
    
    /**
     * 是否构造一个 FOR UPDATE 查询
     *
     * @param boolean $bFlag            
     * @return $this
     */
    public function forUpdate($bFlag = true) {
        $this->arrOption ['forupdate'] = ( bool ) $bFlag;
        return $this;
    }
    
    // ######################################################
    // -------------------- 构造查询条件 end -------------------
    // ######################################################
    
    // ######################################################
    // ------------------ sql 语句分析 start -------------------
    // ######################################################
    
    /**
     * 获得查询字符串
     *
     * @return string
     */
    public function makeSql() {
        $arrSql = [ 
                'SELECT' 
        ];
        
        foreach ( array_keys ( $this->arrOption ) as $sOption ) {
            if ($sOption == 'from') {
                $arrSql ['from'] = '';
            } else if ($sOption == 'union') {
                continue;
            } else {
                $sMethod = 'parse' . ucfirst ( $sOption ) . '_';
                if (method_exists ( $this, $sMethod )) {
                    $arrSql [$sOption] = $this->$sMethod ();
                }
            }
        }
        
        $arrSql ['from'] = $this->parseFrom_ ();
        foreach ( $arrSql as $nOffset => $sOption ) { // 删除空元素
            if (trim ( $sOption ) == '') {
                unset ( $arrSql [$nOffset] );
            }
        }
        
        $arrSql [] = $this->parseUnion_ ();
        $this->_sLastSql = implode ( ' ', $arrSql );
        return $this->_sLastSql;
    }
    
    /**
     * 解析 prefix 分析结果
     *
     * @return string
     */
    private function parsePrefix_() {
        if (empty ( $this->arrOption ['prefix'] )) {
            return '';
        }
        return join ( ' ', $this->arrOption ['prefix'] );
    }
    
    /**
     * 解析 distinct 分析结果
     *
     * @return string
     */
    private function parseDistinct_() {
        if (! $this->arrOption ['distinct']) {
            return '';
        }
        return 'DISTINCT';
    }
    
    /**
     * 分析语句中的字段
     *
     * @return string
     */
    private function parseColumns_() {
        if (empty ( $this->arrOption ['columns'] )) {
            return '';
        }
        
        $arrColumns = array ();
        foreach ( $this->arrOption ['columns'] as $arrEntry ) {
            list ( $sTableName, $sCol, $sAlias ) = $arrEntry;
            
            // 表达式支持
            if (strpos ( $sCol, '{' ) !== false && preg_match ( '/^{(.+?)}$/', $sCol, $arrRes )) {
                $arrColumns [] = $this->objConnect->qualifyExpression ( $arrRes [1], $sTableName, $this->arrColumnsMapping );
            } else {
                if (isset ( $this->arrColumnsMapping [$sCol] )) {
                    $sCol = $this->arrColumnsMapping [$sCol];
                }
                if ($sCol != '*' && $sAlias) {
                    $arrColumns [] = $this->objConnect->qualifyTableOrColumn ( "{$sTableName}.{$sCol}", $sAlias, 'AS' );
                } else {
                    $arrColumns [] = $this->objConnect->qualifyTableOrColumn ( "{$sTableName}.{$sCol}" );
                }
            }
        }
        
        return implode ( ',', $arrColumns );
    }
    
    /**
     * 解析 aggregate 分析结果
     *
     * @return string
     */
    protected function parseAggregate_() {
        if (empty ( $this->arrOption ['aggregate'] )) {
            return '';
        }
        
        $arrColumns = [ ];
        foreach ( $this->arrOption ['aggregate'] as $arrAggregate ) {
            list ( , $sField, $sAlias ) = $arrAggregate;
            if ($sAlias) {
                $arrColumns [] = $sField . ' AS ' . $sAlias;
            } else {
                $arrColumns [] = $sField;
            }
        }
        
        return (empty ( $arrColumns )) ? '' : implode ( ',', $arrColumns );
    }
    
    /**
     * 解析 from(table) 分析结果
     *
     * @return string
     */
    private function parseFrom_() {
        if (empty ( $this->arrOption ['from'] )) {
            return '';
        }
        
        $arrFrom = [ ];
        foreach ( $this->arrOption ['from'] as $sAlias => $arrTable ) {
            $sTmp = '';
            // 如果不是第一个 FROM，则添加 JOIN
            if (! empty ( $arrFrom )) {
                $sTmp .= ' ' . strtoupper ( $arrTable ['join_type'] ) . ' ';
            }
            
            if ($sAlias == $arrTable ['table_name']) {
                $sTmp .= $this->objConnect->qualifyTableOrColumn ( "{$arrTable['schema']}.{$arrTable['table_name']}" );
            } else {
                $sTmp .= $this->objConnect->qualifyTableOrColumn ( "{$arrTable['schema']}.{$arrTable['table_name']}", $sAlias );
            }
            
            // 添加 JOIN 查询条件
            if (! empty ( $arrFrom ) && ! empty ( $arrTable ['join_cond'] )) {
                $sTmp .= ' ON ' . $arrTable ['join_cond'];
            }
            $arrFrom [] = $sTmp;
        }
        
        if (! empty ( $arrFrom )) {
            return 'FROM ' . implode ( ' ', $arrFrom );
        } else {
            return '';
        }
    }
    
    /**
     * 解析 index 分析结果
     *
     * @return string
     */
    private function parseIndex_() {
        $strIndex = '';
        foreach ( [ 
                'FORCE',
                'IGNORE' 
        ] as $sType ) {
            if (empty ( $this->arrOption ['index'] [$sType] )) {
                continue;
            }
            $strIndex .= ($strIndex ? ' ' : '') . $sType . ' INDEX ( ' . join ( ',', $this->arrOption ['index'] [$sType] ) . ' )';
        }
        return $strIndex;
    }
    
    /**
     * 解析 where 分析结果
     *
     * @param boolean $booChild            
     * @return string
     */
    private function parseWhere_($booChild = false) {
        if (empty ( $this->arrOption ['where'] )) {
            return '';
        }
        return $this->analyseCondition_ ( 'where', $booChild );
    }
    
    /**
     * 解析 union 分析结果
     *
     * @return string
     */
    private function parseUnion_() {
        if (empty ( $this->arrOption ['union'] )) {
            return '';
        }
        
        $sSql = '';
        if ($this->arrOption ['union']) {
            $nOptions = count ( $this->arrOption ['union'] );
            foreach ( $this->arrOption ['union'] as $nCnt => $arrUnion ) {
                list ( $mixUnion, $sType ) = $arrUnion;
                if ($mixUnion instanceof select) {
                    $mixUnion = $mixUnion->makeSql ();
                }
                if ($nCnt <= $nOptions - 1) {
                    $sSql .= "\n" . $sType . ' ' . $mixUnion;
                }
            }
        }
        return $sSql;
    }
    
    /**
     * 解析 order 分析结果
     *
     * @return string
     */
    private function parseOrder_() {
        if (empty ( $this->arrOption ['order'] )) {
            return '';
        }
        return 'ORDER BY ' . implode ( ',', array_unique ( $this->arrOption ['order'] ) );
    }
    
    /**
     * 解析 group 分析结果
     *
     * @return string
     */
    protected function parseGroup_() {
        if (empty ( $this->arrOption ['group'] )) {
            return '';
        }
        return 'GROUP BY ' . implode ( ',', $this->arrOption ['group'] );
    }
    
    /**
     * 解析 having 分析结果
     *
     * @param boolean $booChild            
     * @return string
     */
    private function parseHaving_($booChild = false) {
        if (empty ( $this->arrOption ['having'] )) {
            return '';
        }
        return $this->analyseCondition_ ( 'having', $booChild );
    }
    
    /**
     * 解析 limit 分析结果
     *
     * @return string
     */
    private function parseLimitcount_() {
        if (is_null ( $this->arrOption ['limitoffset'] ) && is_null ( $this->arrOption ['limitcount'] )) {
            return '';
        }
        
        if (! is_null ( $this->arrOption ['limitoffset'] )) {
            $sSql = 'LIMIT ' . ( int ) $this->arrOption ['limitoffset'];
            if (! is_null ( $this->arrOption ['limitcount'] )) {
                $sSql .= ',' . ( int ) $this->arrOption ['limitcount'];
            } else {
                $sSql .= ',999999999999';
            }
            
            return $sSql;
        } elseif (! is_null ( $this->arrOption ['limitcount'] )) {
            return 'LIMIT ' . ( int ) $this->arrOption ['limitcount'];
        }
    }
    
    /**
     * 解析 forupdate 分析结果
     *
     * @return string
     */
    private function parseForUpdate_() {
        if (! $this->arrOption ['forupdate']) {
            return '';
        }
        return 'FOR UPDATE';
    }
    
    /**
     * 解析 condition　条件（包括 where,having）
     *
     * @param string $sCondType            
     * @param boolean $booChild            
     * @return string
     */
    private function analyseCondition_($sCondType, $booChild = false) {
        if (! $this->arrOption [$sCondType]) {
            return '';
        }
        
        $arrSqlCond = [ ];
        $strTable = $this->getCurrentTable_ ();
        foreach ( $this->arrOption [$sCondType] as $sKey => $mixCond ) {
            // 逻辑连接符
            if (in_array ( $mixCond, [ 
                    self::LOGIC_AND,
                    self::LOGIC_OR 
            ] )) {
                $arrSqlCond [] = strtoupper ( $mixCond );
                continue;
            }
            
            // 特殊处理
            if (is_string ( $sKey )) {
                if (in_array ( $sKey, [ 
                        'string__' 
                ] )) {
                    $arrSqlCond [] = implode ( ' AND ', $mixCond );
                }
            } elseif (is_array ( $mixCond )) {
                // 表达式支持
                if (strpos ( $mixCond [0], '{' ) !== false && preg_match ( '/^{(.+?)}$/', $mixCond [0], $arrRes )) {
                    $mixCond [0] = $this->objConnect->qualifyExpression ( $arrRes [1], $strTable, $this->arrColumnsMapping );
                } else {
                    // 字段处理
                    if (strpos ( $mixCond [0], ',' ) !== false) {
                        $arrTemp = explode ( ',', $mixCond [0] );
                        $mixCond [0] = $arrTemp [1];
                        $strCurrentTable = $mixCond [0];
                    } else {
                        $strCurrentTable = $strTable;
                    }
                    
                    if (isset ( $this->arrColumnsMapping [$mixCond [0]] )) {
                        $mixCond [0] = $this->arrColumnsMapping [$mixCond [0]];
                    }
                    
                    $mixCond [0] = $this->objConnect->qualifyColumn ( $mixCond [0], $strCurrentTable );
                }
                
                // 格式化字段值，支持数组
                if (isset ( $mixCond [2] )) {
                    if (is_array ( $mixCond [2] )) {
                        foreach ( $mixCond [2] as &$strTemp ) {
                            // 表达式支持
                            if (strpos ( $strTemp, '{' ) !== false && preg_match ( '/^{(.+?)}$/', $strTemp, $arrRes )) {
                                $strTemp = $this->objConnect->qualifyExpression ( $arrRes [1], $strTable, $this->arrColumnsMapping );
                            } else {
                                $strTemp = $this->objConnect->qualifyColumnValue ( $strTemp );
                            }
                        }
                    } else {
                        // 表达式支持
                        if (strpos ( $mixCond [2], '{' ) !== false && preg_match ( '/^{(.+?)}$/', $mixCond [2], $arrRes )) {
                            $mixCond [2] = $this->objConnect->qualifyExpression ( $arrRes [1], $strTable, $this->arrColumnsMapping );
                        } else {
                            $mixCond [2] = $this->objConnect->qualifyColumnValue ( $mixCond [2] );
                        }
                    }
                }
                
                // 拼接结果
                if (in_array ( $mixCond [1], [ 
                        'null',
                        'not null' 
                ] )) {
                    $arrSqlCond [] = $mixCond [0] . ' IS ' . strtoupper ( $mixCond [1] );
                } elseif (in_array ( $mixCond [1], [ 
                        'in',
                        'not in' 
                ] )) {
                    $arrSqlCond [] = $mixCond [0] . ' ' . strtoupper ( $mixCond [1] ) . ' (' . implode ( ',', $mixCond [2] ) . ')';
                } elseif (in_array ( $mixCond [1], [ 
                        'between',
                        'not between' 
                ] )) {
                    $arrSqlCond [] = $mixCond [0] . ' ' . strtoupper ( $mixCond [1] ) . ' ' . $mixCond [2] [0] . ' AND ' . $mixCond [2] [1];
                } elseif (! is_array ( $mixCond [2] )) {
                    $arrSqlCond [] = $mixCond [0] . ' ' . strtoupper ( $mixCond [1] ) . ' ' . $mixCond [2];
                }
            }
        }
        
        // 剔除第一个逻辑符
        array_shift ( $arrSqlCond );
        return ($booChild === false ? strtoupper ( $sCondType ) . ' ' : '') . implode ( ' ', $arrSqlCond );
    }
    
    /**
     * 别名条件
     *
     * @param string $strConditionType            
     * @param mixed $mixCond            
     * @return $this
     */
    private function aliasCondition_($strConditionType, $mixCond) {
        if (! is_array ( $mixCond )) {
            $arrArgs = func_get_args ();
            $this->addConditions_ ( $arrArgs [1], $strConditionType, isset ( $arrArgs [2] ) ? $arrArgs [2] : null );
        } else {
            foreach ( $mixCond as $arrTemp ) {
                $this->addConditions_ ( $arrTemp [0], $strConditionType, $arrTemp [1] );
            }
        }
        return $this;
    }
    
    /**
     * 别名类型和逻辑
     *
     * @param string $strType            
     * @param string $strLogic            
     * @param mixed $mixCond            
     * @return $this
     */
    private function aliasTypeAndLogic_($strType, $strLogic, $mixCond /* args */){
        $this->setTypeAndLogic_ ( $strType, $strLogic );
        if (\Q::varType ( $mixCond, 'callback' )) {
            $objSelect = new self ( $this->objConnect );
            $objSelect->setCurrentTable_ ( $this->getCurrentTable_ () );
            call_user_func_array ( $mixCond, [ 
                    &$objSelect 
            ] );
            $strParseType = 'parse' . ucwords ( $strType ) . '_';
            $this->setConditionItem_ ( self::LOGIC_GROUP_LEFT . $objSelect->{$strParseType} ( true ) . self::LOGIC_GROUP_RIGHT, 'string__' );
            return $this;
        } else {
            $arrArgs = func_get_args ();
            array_shift ( $arrArgs );
            array_shift ( $arrArgs );
            return call_user_func_array ( [ 
                    $this,
                    'addConditions_' 
            ], $arrArgs );
        }
    }
    
    /**
     * 组装条件
     *
     * @return $this
     */
    private function addConditions_() {
        $arrArgs = func_get_args ();
        $strTable = $this->getCurrentTable_ ();
        
        // 整理多个参数到二维数组
        if (! is_array ( $arrArgs [0] )) {
            $mixTemp = $arrArgs;
            $arrArgs [0] = [ ];
            $arrArgs [0] [] = $mixTemp;
        } else {
            // 一维数组统一成二维数组格式
            $booOneImension = false;
            foreach ( $arrArgs [0] as $mixKey => $mixValue ) {
                if (is_int ( $mixKey ) && ! is_array ( $mixValue )) {
                    $booOneImension = true;
                }
                break;
            }
            
            if ($booOneImension === true) {
                $arrTemp = $arrArgs [0];
                $arrArgs [0] = [ ];
                $arrArgs [0] [] = $arrTemp;
            }
        }
        
        // 遍历数组拼接结果
        foreach ( $arrArgs [0] as $strKey => $arrTemp ) {
            if (! is_int ( $strKey )) {
                $strKey = trim ( $strKey );
            }
            
            // 字符串表达式
            if (is_string ( $strKey ) && $strKey == 'string__') {
                // 不符合规则跳过
                if (! is_string ( $arrTemp )) {
                    \Q::throwException ( \Q::i18n ( 'string__ 只支持字符串' ) );
                }
                
                // 表达式支持
                if (strpos ( $arrTemp, '{' ) !== false && preg_match ( '/^{(.+?)}$/', $arrTemp, $arrRes )) {
                    $arrTemp = $this->objConnect->qualifyExpression ( $arrRes [1], $strTable, $this->arrColumnsMapping );
                }
                $this->setConditionItem_ ( $arrTemp, 'string__' );
            }            

            // 子表达式
            elseif (is_string ( $strKey ) && in_array ( $strKey, [ 
                    'subor__',
                    'suband__' 
            ] )) {
                $arrTypeAndLogic = $this->getTypeAndLogic_ ();
                
                $objSelect = new self ( $this->objConnect );
                $objSelect->setCurrentTable_ ( $this->getCurrentTable_ () );
                $objSelect->setTypeAndLogic_ ( $arrTypeAndLogic [0] );
                
                // 逻辑表达式
                if (isset ( $arrTemp ['logic__'] )) {
                    if (strtolower ( $arrTemp ['logic__'] ) == self::LOGIC_OR) {
                        $objSelect->setTypeAndLogic_ ( null, self::LOGIC_OR );
                    }
                    unset ( $arrTemp ['logic__'] );
                }
                
                $objSelect = call_user_func_array ( [ 
                        $objSelect,
                        'addConditions_' 
                ], [ 
                        $arrTemp 
                ] );
                
                // 解析结果
                $strParseType = 'parse' . ucwords ( $arrTypeAndLogic [0] ) . '_';
                $strOldLogic = $arrTypeAndLogic [1];
                $this->setTypeAndLogic_ ( null, 'subor__' ? self::LOGIC_OR : self::LOGIC_AND );
                $this->setConditionItem_ ( self::LOGIC_GROUP_LEFT . $objSelect->{$strParseType} ( true ) . self::LOGIC_GROUP_RIGHT, 'string__' );
                $this->setTypeAndLogic_ ( null, $strOldLogic );
            }            

            // exists 支持
            elseif (is_string ( $strKey ) && $strKey == 'exists__') {
                // having 不支持 exists
                if ($this->getTypeAndLogic_ ()[0] == 'having') {
                    \Q::throwException ( \Q::i18n ( 'having 不支持 exists 写法' ) );
                }
                
                if ($arrTemp instanceof select) {
                    $arrTemp = $arrTemp->makeSql ();
                } elseif (\Q::varType ( $arrTemp, 'callback' )) {
                    $objSelect = new self ( $this->objConnect );
                    $objSelect->setCurrentTable_ ( $this->getCurrentTable_ () );
                    call_user_func_array ( $arrTemp, [ 
                            &$objSelect 
                    ] );
                    $arrTemp = $objSelect->makeSql ();
                }
                
                $arrTemp = 'EXISTS ' . self::LOGIC_GROUP_LEFT . ' ' . $arrTemp . ' ' . self::LOGIC_GROUP_RIGHT;
                $this->setConditionItem_ ( $arrTemp, 'string__' );
            }             

            // 其它
            else {
                // 处理字符串 "null"
                if (is_string ( $arrTemp )) {
                    $mixTemp = $arrTemp;
                    $arrTemp = [ ];
                    $arrTemp [] = $mixTemp;
                }
                
                // 合并字段到数组
                if (is_string ( $strKey )) {
                    array_unshift ( $arrTemp, $strKey );
                }
                
                // 处理默认 “=”的类型
                if (count ( $arrTemp ) === 2 && ! in_array ( $arrTemp [1], [ 
                        'null',
                        'not null' 
                ] )) {
                    $mixTemp = $arrTemp [1];
                    $arrTemp [1] = '=';
                    $arrTemp [2] = $mixTemp;
                }
                
                // 字段
                $arrTemp [1] = trim ( $arrTemp [1] );
                
                // 特殊类型
                if (in_array ( $arrTemp [1], [ 
                        'between',
                        'not between',
                        'in',
                        'not in',
                        'null',
                        'not null' 
                ] )) {
                    if (isset ( $arrTemp [2] ) && ! is_array ( $arrTemp [2] )) {
                        $arrTemp [2] = explode ( ',', $arrTemp [2] );
                    }
                    $this->setConditionItem_ ( [ 
                            $arrTemp [0],
                            $arrTemp [1],
                            isset ( $arrTemp [2] ) ? $arrTemp [2] : null 
                    ] );
                }                 

                // 普通类型
                else {
                    $this->setConditionItem_ ( $arrTemp );
                }
            }
        }
        
        return $this;
    }
    
    /**
     * 设置条件的一项
     *
     * @param array $arrItem            
     * @param string $strType            
     * @return void
     */
    private function setConditionItem_($arrItem, $strType = '') {
        $arrTypeAndLogic = $this->getTypeAndLogic_ ();
        if ($strType) {
            if (empty ( $this->arrOption [$arrTypeAndLogic [0]] [$strType] )) {
                $this->arrOption [$arrTypeAndLogic [0]] [] = $arrTypeAndLogic [1];
                $this->arrOption [$arrTypeAndLogic [0]] [$strType] = [ ];
            }
            $this->arrOption [$arrTypeAndLogic [0]] [$strType] [] = $arrItem;
        } else {
            $this->arrOption [$arrTypeAndLogic [0]] [] = $arrTypeAndLogic [1];
            $this->arrOption [$arrTypeAndLogic [0]] [] = $arrItem;
        }
    }
    
    /**
     * 设置条件的逻辑和类型
     *
     * @param string $strType            
     * @param string $strLogic            
     * @return void
     */
    private function setTypeAndLogic_($strType = NULL, $strLogic = NULL) {
        if (! is_null ( $strType )) {
            $this->strConditionType = $strType;
        }
        if (! is_null ( $strLogic )) {
            $this->strConditionLogic = $strLogic;
        }
    }
    
    /**
     * 获取条件的逻辑和类型
     *
     * @return array
     */
    private function getTypeAndLogic_() {
        return [ 
                $this->strConditionType,
                $this->strConditionLogic 
        ];
    }
    
    /**
     * 连表 join 操作
     *
     * @param string $sJoinType            
     * @param mixed $mixName            
     * @param mixed $mixCols            
     * @param array|null $arrCondArgs            
     * @return $this
     */
    private function join_($sJoinType, $mixName, $mixCols, $mixCond = null/* args */) {
        // 验证 join 类型
        if (! isset ( self::$arrJoinTypes [$sJoinType] )) {
            \Q::throwException ( \Q::i18n ( '无效的 JOIN 类型 %s', $sJoinType ) );
        }
        
        // 不能在使用 UNION 查询的同时使用 JOIN 查询
        if (count ( $this->arrOption ['union'] )) {
            \Q::throwException ( \Q::i18n ( '不能在使用 UNION 查询的同时使用 JOIN 查询' ) );
        }
        
        // 没有指定表，获取默认表
        if (empty ( $mixName )) {
            $sTable = $this->getCurrentTable_ ();
            $sAlias = '';
        }        

        // $mixName 为数组配置
        elseif (is_array ( $mixName )) {
            foreach ( $mixName as $sAlias => $sTable ) {
                if (! is_string ( $sAlias )) {
                    $sAlias = '';
                }
                break;
            }
        }        

        // 字符串指定别名
        elseif (preg_match ( '/^(.+)\s+AS\s+(.+)$/i', $mixName, $arrMatch )) {
            $sTable = $arrMatch [1];
            $sAlias = $arrMatch [2];
        } else {
            $sTable = $mixName;
            $sAlias = '';
        }
        
        // 确定 table_name 和 schema
        $arrTemp = explode ( '.', $sTable );
        if (isset ( $arrTemp [1] )) {
            $sSchema = $arrTemp [0];
            $sTableName = $arrTemp [1];
        } else {
            $sSchema = null;
            $sTableName = $sTable;
        }
        
        // 获得一个唯一的别名
        $sAlias = $this->uniqueAlias_ ( empty ( $sAlias ) ? $sTableName : $sAlias );
        
        // 查询条件
        $arrArgs = func_get_args ();
        if (count ( $arrArgs ) > 3) {
            for($nI = 0; $nI <= 2; $nI ++) {
                array_shift ( $arrArgs );
            }
            $objSelect = new self ( $this->objConnect );
            $objSelect->setCurrentTable_ ( $sAlias );
            call_user_func_array ( [ 
                    $objSelect,
                    'where' 
            ], $arrArgs );
            $mixCond = $objSelect->parseWhere_ ( true );
        }
        
        // 添加一个要查询的数据表
        $this->arrOption ['from'] [$sAlias] = [ 
                'join_type' => $sJoinType,
                'table_name' => $sTableName,
                'schema' => $sSchema,
                'join_cond' => $mixCond 
        ];
        
        // 添加查询字段
        $this->addCols_ ( $sAlias, $mixCols );
        
        return $this;
    }
    
    /**
     * 添加字段
     *
     * @param string $sTableName            
     * @param mixed $mixCols            
     * @return void
     */
    private function addCols_($sTableName, $mixCols) {
        // 处理条件表达式
        if (is_string ( $mixCols ) && strpos ( $mixCols, ',' ) !== false && strpos ( $mixCols, '{' ) !== false && preg_match_all ( '/{(.+?)}/', $mixCols, $arrRes )) {
            $mixCols = str_replace ( $arrRes [1] [0], base64_encode ( $arrRes [1] [0] ), $mixCols );
        }
        $mixCols = \Q::normalize ( $mixCols );
        // 还原
        if (! empty ( $arrRes )) {
            foreach ( $arrRes [1] as $strTemp ) {
                $mixCols [array_search ( '{' . base64_encode ( $strTemp ) . '}', $mixCols, true )] = '{' . $strTemp . '}';
            }
        }
        
        if (is_null ( $sTableName )) {
            $sTableName = '';
        }
        
        // 没有字段则退出
        if (empty ( $mixCols )) {
            return;
        }
        
        foreach ( $mixCols as $sAlias => $mixCol ) {
            if (is_string ( $mixCol )) {
                // 处理条件表达式
                if (is_string ( $mixCol ) && strpos ( $mixCol, ',' ) !== false && strpos ( $mixCol, '{' ) !== false && preg_match_all ( '/{(.+?)}/', $mixCol, $arrResTwo )) {
                    $mixCol = str_replace ( $arrResTwo [1] [0], base64_encode ( $arrResTwo [1] [0] ), $mixCol );
                }
                $mixCol = \Q::normalize ( $mixCol );
                // 还原
                if (! empty ( $arrResTwo )) {
                    foreach ( $arrResTwo [1] as $strTemp ) {
                        $mixCol [array_search ( '{' . base64_encode ( $strTemp ) . '}', $mixCol, true )] = '{' . $strTemp . '}';
                    }
                }
                foreach ( \Q::normalize ( $mixCol ) as $sCol ) { // 将包含多个字段的字符串打散
                    $strThisTableName = $sTableName;
                    
                    if (preg_match ( '/^(.+)\s+' . 'AS' . '\s+(.+)$/i', $sCol, $arrMatch )) { // 检查是不是 "字段名 AS 别名"这样的形式
                        $sCol = $arrMatch [1];
                        $sAlias = $arrMatch [2];
                    }
                    
                    if (preg_match ( '/(.+)\.(.+)/', $sCol, $arrMatch )) { // 检查字段名是否包含表名称
                        $strThisTableName = $arrMatch [1];
                        $sCol = $arrMatch [2];
                    }
                    
                    if (isset ( $this->arrColumnsMapping [$sCol] )) {
                        $sCol = $this->arrColumnsMapping [$sCol];
                    }
                    
                    $this->arrOption ['columns'] [] = [ 
                            $strThisTableName,
                            $sCol,
                            is_string ( $sAlias ) ? $sAlias : null 
                    ];
                }
            } else {
                $this->arrOption ['columns'] [] = [ 
                        $sTableName,
                        $mixCol,
                        is_string ( $sAlias ) ? $sAlias : null 
                ];
            }
        }
    }
    
    /**
     * 添加一个集合查询
     *
     * @param string $sType
     *            类型
     * @param string $strField
     *            字段
     * @param string $sAlias
     *            别名
     * @return DbRecordSet
     */
    private function addAggregate_($sType, $strField, $sAlias) {
        $this->arrOption ['columns'] = [ ];
        $strTableName = $this->getCurrentTable_ ();
        
        // 表达式支持
        if (strpos ( $strField, '{' ) !== false && preg_match ( '/^{(.+?)}$/', $strField, $arrRes )) {
            $strField = $this->objConnect->qualifyExpression ( $arrRes [1], $strTableName, $this->arrColumnsMapping );
        } else {
            if (isset ( $this->arrColumnsMapping [$strField] )) {
                $strField = $this->arrColumnsMapping [$strField];
            }
            if (preg_match ( '/(.+)\.(.+)/', $strField, $arrMatch )) { // 检查字段名是否包含表名称
                $strTableName = $arrMatch [1];
                $strField = $arrMatch [2];
            }
            if ($strField == '*') {
                $strTableName = '';
            }
            $strField = $this->objConnect->qualifyColumn ( $strField, $strTableName );
        }
        $strField = "{$sType}($strField)";
        
        $this->arrOption ['aggregate'] [] = [ 
                $sType,
                $strField,
                $sAlias 
        ];
        
        $this->one ();
        $this->arrQueryParam ['as_default'] = true;
        return $this;
    }
    
    // ######################################################
    // ------------------ sql 语句分析 end -------------------
    // ######################################################
    
    // ######################################################
    // ------------------- 私有方法 start --------------------
    // ######################################################
    
    /**
     * 查询获得结果
     *
     * @return mixed
     */
    private function query_() {
        $strSql = $this->makeSql ();
        echo $strSql;
        $arrData = call_user_func_array ( [ 
                $this->objConnect,
                'query' 
        ], [ 
                $strSql,
                $this->arrBindParams,
                $this->arrQueryParams ['master'],
                $this->arrQueryParams ['fetch_type'] ['fetch_type'],
                $this->arrQueryParams ['fetch_type'] ['fetch_argument'],
                $this->arrQueryParams ['fetch_type'] ['ctor_args'] 
        ] );
        
        if ($this->arrQueryParams ['as_default']) {
            $this->queryDefault_ ( $arrData );
        } else {
            $this->queryClass_ ( $arrData );
        }
        
        return $arrData;
    }
    
    /**
     * 以数组返回结果
     *
     * @param array $arrData            
     * @return void
     */
    private function queryDefault_(&$arrData) {
        if (empty ( $arrData )) {
            return;
        }
        
        // 返回一条记录
        if (! $this->arrOption ['limitquery']) {
            $arrData = reset ( $arrData );
        }
    }
    
    /**
     * 以 class 返回结果
     *
     * @param array $arrData            
     * @return void
     */
    private function queryClass_(&$arrData) {
        if (empty ( $arrData )) {
            return;
        }
        
        // 模型类不存在，直接以数组结果返回
        $sClassName = $this->arrQueryParams ['as_class'];
        if (! \Q::classExists ( $sClassName )) {
            $this->queryDefault_ ( $arrData );
        }
        
        foreach ( $arrData as &$mixTemp ) {
            $mixTemp = ( array ) $mixTemp;
            $mixTemp = new $sClassName ( $mixTemp );
        }
        
        // 创建一个单独的对象
        if (! $this->arrOption ['limitquery']) {
            $arrData = reset ( $arrData );
        } else {
            if ($this->arrQueryParams ['as_collection']) {
                $arrData = new collection ( $arrData, $sClassName );
            }
        }
    }
    
    /**
     * 原生 sql 执行方法
     *
     * @param null|string $mixData            
     * @return mixed
     */
    private function runNativeSql_($mixData = null) {
        $strNativeSql = $this->getNativeSql_ ();
        
        // 空参数返回当前对象
        if (is_null ( $mixData )) {
            return $this;
        } elseif (is_string ( $mixData )) {
            // 验证参数
            if ($this->objConnect->getSqlType ( $mixData ) != $strNativeSql) {
                \Q::throwException ( \Q::i18n ( '%s 方法只允许运行 %s sql 语句', $strNativeSql, $strNativeSql ), 'Q\database\exception' );
            }
            
            return (call_user_func_array ( [ 
                    $this->objConnect,
                    $strNativeSql == 'select' ? 'query' : 'execute' 
            ], func_get_args () ));
        } else {
            \Q::throwException ( \Q::i18n ( '%s 方法第一个参数只允许是 null 或者字符串', $strNativeSql ), 'Q\database\exception' );
        }
    }
    
    /**
     * 设置原生 sql 类型
     *
     * @param string $strNativeSql            
     * @return void
     */
    private function setNativeSql_($strNativeSql) {
        $this->strNativeSql = $strNativeSql;
    }
    
    /**
     * 返回原生 sql 类型
     *
     * @return string
     */
    private function getNativeSql_() {
        return $this->strNativeSql;
    }
    
    /**
     * 设置当前表名字
     *
     * @param mixed $mixTable            
     * @return void
     */
    private function setCurrentTable_($mixTable) {
        $this->strCurrentTable = $mixTable;
    }
    
    /**
     * 获取当前表名字
     *
     * @return string
     */
    private function getCurrentTable_() {
        if (is_array ( $this->strCurrentTable )) { // 数组
            while ( (list ( $sAlias, ) = each ( $this->strCurrentTable )) !== false ) {
                return $this->strCurrentTable = $sAlias;
            }
        } else {
            return $this->strCurrentTable;
        }
    }
    
    /**
     * 别名唯一
     *
     * @param mixed $mixName            
     * @return string
     */
    private function uniqueAlias_($mixName) {
        if (empty ( $mixName )) {
            return '';
        }
        // 数组，返回最后一个元素
        if (is_array ( $mixName )) {
            $strAliasReturn = end ( $mixName );
        }         

        // 字符串
        else {
            $nDot = strrpos ( $mixName, '.' );
            $strAliasReturn = $nDot === false ? $mixName : substr ( $mixName, $nDot + 1 );
        }
        
        for($nI = 2; array_key_exists ( $strAliasReturn, $this->arrOption ['from'] ); ++ $nI) {
            $strAliasReturn = $mixName . '_' . ( string ) $nI;
        }
        
        return $strAliasReturn;
    }
    
    /**
     * 初始化查询条件
     *
     * @return void
     */
    private function initOption_() {
        $this->arrOption = self::$arrOptionDefault;
        $this->arrQueryParams = self::$arrQueryParamsDefault;
    }
    
    // ######################################################
    // -------------------- 私有方法 end ---------------------
    // ######################################################
}
