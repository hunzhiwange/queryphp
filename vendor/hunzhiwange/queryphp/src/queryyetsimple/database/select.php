<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\database;

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

use PDO;
use queryyetsimple\traits\flow\control as flow_control;
use queryyetsimple\datastruct\collection\collection;
use queryyetsimple\exception\exceptions;
use queryyetsimple\assert\assert;
use queryyetsimple\helper\helper;

/**
 * 数据库查询器
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.03.09
 * @version 1.0
 */
class select {
    
    use flow_control;
    
    /**
     * 数据库连接
     *
     * @var queryyetsimple\database\connect
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
            'from' => [ ],
            'using' => [ ],
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
     * 是否为表操作
     *
     * @var boolean
     */
    private $booIsTable = false;
    
    /**
     * 子表达式默认别名
     *
     * @var string
     */
    const DEFAULT_SUBEXPRESSION_ALIAS = 'a';
    
    /**
     * 不查询直接返回 SQL
     *
     * @var boolean
     */
    private $booOnlyMakeSql = false;
    
    /**
     * 是否处于时间功能状态
     *
     * @var string
     */
    private $strInTimeCondition = null;
    
    /**
     * 构造函数
     *
     * @param queryyetsimple\database\connect $objConnect            
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
        // 动态查询支持
        if (strncasecmp ( $sMethod, 'get', 3 ) === 0) {
            $sMethod = substr ( $sMethod, 3 );
            if (strpos ( strtolower ( $sMethod ), 'start' ) !== false) { // support get10start3 etc.
                $arrValue = explode ( 'start', strtolower ( $sMethod ) );
                $nNum = intval ( array_shift ( $arrValue ) );
                $nOffset = intval ( array_shift ( $arrValue ) );
                return $this->limit ( $nOffset, $nNum )->get ();
            } elseif (strncasecmp ( $sMethod, 'By', 2 ) === 0) { // support getByName getByNameAndSex etc.
                $sMethod = substr ( $sMethod, 2 );
                $arrKeys = explode ( 'And', $sMethod );
                if (count ( $arrKeys ) != count ( $arrArgs )) {
                    exceptions::throwException ( __ ( 'getBy 参数数量不对应' ), 'queryyetsimple\database\exception' );
                }
                return $this->where ( array_combine ( $arrKeys, $arrArgs ) )->getOne ();
            } elseif (strncasecmp ( $sMethod, 'AllBy', 5 ) === 0) { // support getAllByNameAndSex etc.
                $sMethod = substr ( $sMethod, 5 );
                $arrKeys = explode ( 'And', $sMethod );
                if (count ( $arrKeys ) != count ( $arrArgs )) {
                    exceptions::throwException ( __ ( 'getAllBy 参数数量不对应' ), 'queryyetsimple\database\exception' );
                }
                return $this->where ( array_combine ( $arrKeys, $arrArgs ) )->getAll ();
            }
            return $this->top ( intval ( substr ( $sMethod, 3 ) ) );
        }
        
        exceptions::throwException ( __ ( 'select 没有实现魔法方法 %s.', $sMethod ), 'queryyetsimple\database\exception' );
    }
    
    // ######################################################
    // ------------------ 返回查询结果 start -------------------
    // ######################################################
    
    /**
     * 原生 sql 查询数据 select
     *
     * @param string|null|callback|select $mixData            
     * @param array $arrBind            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return mixed
     */
    public function select($mixData = null, $arrBind = [], $bFlag = false) {
        if (! helper::isThese ( $mixData, [ 
                'string',
                'null',
                'callback' 
        ] ) && ! $mixData instanceof select) {
            exceptions::throwException ( __ ( 'select 查询数据第一个参数只能为 null、callback、select 或者 string' ), 'queryyetsimple\database\exception' );
        }
        
        // 查询对象直接查询
        if ($mixData instanceof select) {
            return $mixData->select ( null, $arrBind, $bFlag );
        }        

        // 回调
        elseif (is_callable ( $mixData )) {
            call_user_func_array ( $mixData, [ 
                    & $this 
            ] );
            $mixData = null;
        }
        
        // 调用查询
        if (is_null ( $mixData )) {
            return $this->get ( null, $bFlag );
        }
        
        $this->sql ( $bFlag )->setNativeSql_ ( 'select' );
        return call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], [ 
                $mixData,
                $arrBind 
        ] );
    }
    
    /**
     * 插入数据 insert (支持原生 sql)
     *
     * @param array|string $mixData            
     * @param array $arrBind            
     * @param boolean $booReplace            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return int 最后插入ID
     */
    public function insert($mixData, $arrBind = [], $booReplace = false, $bFlag = false) {
        if (! helper::isThese ( $mixData, [ 
                'string',
                'array' 
        ] )) {
            exceptions::throwException ( __ ( 'insert 插入数据第一个参数只能为 string 或者 array' ), 'queryyetsimple\database\exception' );
        }
        
        // 绑定参数
        $arrBind = array_merge ( $this->getBindParams_ (), $arrBind );
        
        // 构造数据插入
        if (is_array ( $mixData )) {
            $intQuestionMark = 0;
            $arrBindData = $this->getBindData_ ( $mixData, $arrBind, $intQuestionMark );
            $arrField = $arrBindData [0];
            $arrValue = $arrBindData [1];
            $sTableName = $this->getCurrentTable_ ();
            
            foreach ( $arrField as &$strField ) {
                $strField = $this->qualifyOneColumn_ ( $strField, $sTableName );
            }
            
            // 构造 insert 语句
            if ($arrValue) {
                $arrSql = [ ];
                $arrSql [] = ($booReplace ? 'REPLACE' : 'INSERT') . ' INTO';
                $arrSql [] = $this->parseTable_ ();
                $arrSql [] = '(' . implode ( ',', $arrField ) . ')';
                $arrSql [] = 'VALUES';
                $arrSql [] = '(' . implode ( ',', $arrValue ) . ')';
                $mixData = implode ( ' ', $arrSql );
                unset ( $arrBindData, $arrField, $arrValue, $arrSql );
            }
        }
        $arrBind = array_merge ( $this->getBindParams_ (), $arrBind );
        
        // 执行查询
        $this->sql ( $bFlag )->setNativeSql_ ( $booReplace === false ? 'insert' : 'replace' );
        return call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], [ 
                $mixData,
                $arrBind 
        ] );
    }
    
    /**
     * 批量插入数据 insertAll
     *
     * @param array $arrData            
     * @param array $arrBind            
     * @param boolean $booReplace            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return int 最后插入ID
     */
    public function insertAll($arrData, $arrBind = [], $booReplace = false, $bFlag = false) {
        if (! is_array ( $arrData )) {
            exceptions::throwException ( __ ( 'insertAll 批量插入数据第一个参数必须为数组' ), 'queryyetsimple\database\exception' );
        }
        
        // 绑定参数
        $arrBind = array_merge ( $this->getBindParams_ (), $arrBind );
        
        // 构造数据批量插入
        if (is_array ( $arrData )) {
            $arrDataResult = [ ];
            $intQuestionMark = 0;
            $sTableName = $this->getCurrentTable_ ();
            foreach ( $arrData as $intKey => $arrTemp ) {
                if (! is_array ( $arrTemp )) {
                    continue;
                }
                $arrBindData = $this->getBindData_ ( $arrTemp, $arrBind, $intQuestionMark, $intKey );
                if ($intKey === 0) {
                    $arrField = $arrBindData [0];
                    foreach ( $arrField as &$strField ) {
                        $strField = $this->qualifyOneColumn_ ( $strField, $sTableName );
                    }
                }
                $arrValue = $arrBindData [1];
                if ($arrValue) {
                    $arrDataResult [] = '(' . implode ( ',', $arrValue ) . ')';
                }
            }
            
            // 构造 insertAll 语句
            if ($arrDataResult) {
                $arrSql = [ ];
                $arrSql [] = ($booReplace ? 'REPLACE' : 'INSERT') . ' INTO';
                $arrSql [] = $this->parseTable_ ();
                $arrSql [] = '(' . implode ( ',', $arrField ) . ')';
                $arrSql [] = 'VALUES';
                $arrSql [] = implode ( ',', $arrDataResult );
                $mixData = implode ( ' ', $arrSql );
                unset ( $arrField, $arrValue, $arrSql, $arrDataResult );
            }
        }
        $arrBind = array_merge ( $this->getBindParams_ (), $arrBind );
        
        // 执行查询
        $this->sql ( $bFlag )->setNativeSql_ ( $booReplace === false ? 'insert' : 'replace' );
        return call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], [ 
                $mixData,
                $arrBind 
        ] );
    }
    
    /**
     * 更新数据 update (支持原生 sql)
     *
     * @param array|string $mixData            
     * @param array $arrBind            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return int 影响记录
     */
    public function update($mixData, $arrBind = [], $bFlag = false) {
        if (! helper::isThese ( $mixData, [ 
                'string',
                'array' 
        ] )) {
            exceptions::throwException ( __ ( 'update 更新数据第一个参数只能为 string 或者 array' ), 'queryyetsimple\database\exception' );
        }
        
        // 绑定参数
        $arrBind = array_merge ( $this->getBindParams_ (), $arrBind );
        
        // 构造数据更新
        if (is_array ( $mixData )) {
            $intQuestionMark = 0;
            $arrBindData = $this->getBindData_ ( $mixData, $arrBind, $intQuestionMark );
            $arrField = $arrBindData [0];
            $arrValue = $arrBindData [1];
            $sTableName = $this->getCurrentTable_ ();
            
            // SET 语句
            $arrSetData = [ ];
            foreach ( $arrField as $intKey => $strField ) {
                $strField = $this->qualifyOneColumn_ ( $strField, $sTableName );
                $arrSetData [] = $strField . ' = ' . $arrValue [$intKey];
            }
            
            // 构造 update 语句
            if ($arrValue) {
                $arrSql = [ ];
                $arrSql [] = 'UPDATE';
                $arrSql [] = ltrim ( $this->parseFrom_ (), 'FROM ' );
                $arrSql [] = 'SET ' . implode ( ',', $arrSetData );
                $arrSql [] = $this->parseWhere_ ();
                $arrSql [] = $this->parseOrder_ ();
                $arrSql [] = $this->parseLimitcount_ ();
                $arrSql [] = $this->parseForUpdate_ ();
                $mixData = implode ( ' ', $arrSql );
                unset ( $arrBindData, $arrField, $arrValue, $arrSetData, $arrSql );
            }
        }
        $arrBind = array_merge ( $this->getBindParams_ (), $arrBind );
        
        $this->sql ( $bFlag )->setNativeSql_ ( 'update' );
        return call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], [ 
                $mixData,
                $arrBind 
        ] );
    }
    
    /**
     * 更新某个字段的值
     *
     * @param string $strColumn            
     * @param mixed $mixValue            
     * @param array $arrBind            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return int
     */
    public function updateColumn($strColumn, $mixValue, $arrBind = [], $bFlag = false) {
        if (! is_string ( $strColumn )) {
            exceptions::throwException ( __ ( 'updateColumn 第一个参数必须为字符串' ), 'queryyetsimple\database\exception' );
        }
        
        return $this->sql ( $bFlag )->update ( [ 
                $strColumn => $mixValue 
        ], $arrBind );
    }
    
    /**
     * 字段递增
     *
     * @param string $strColumn            
     * @param int $intStep            
     * @param array $arrBind            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return int
     */
    public function updateIncrease($strColumn, $intStep = 1, $arrBind = [], $bFlag = false) {
        return $this->sql ( $bFlag )->updateColumn ( $strColumn, '{[' . $strColumn . ']+' . $intStep . '}', $arrBind );
    }
    
    /**
     * 字段减少
     *
     * @param string $strColumn            
     * @param int $intStep            
     * @param array $arrBind            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return int
     */
    public function updateDecrease($strColumn, $intStep = 1, $arrBind = [], $bFlag = false) {
        return $this->sql ( $bFlag )->updateColumn ( $strColumn, '{[' . $strColumn . ']-' . $intStep . '}', $arrBind );
    }
    
    /**
     * 删除数据 delete (支持原生 sql)
     *
     * @param null|string $mixData            
     * @param array $arrBind            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return int 影响记录
     */
    public function delete($mixData = null, $arrBind = [], $bFlag = false) {
        if (! helper::isThese ( $mixData, [ 
                'string',
                'null' 
        ] )) {
            exceptions::throwException ( __ ( 'delete 删除数据第一个参数只能为 null 或者 string' ), 'queryyetsimple\database\exception' );
        }
        
        // 构造数据删除
        if (is_null ( $mixData )) {
            // 构造 delete 语句
            $arrSql = [ ];
            $arrSql [] = 'DELETE';
            if (empty ( $this->arrOption ['using'] )) { // join 方式关联删除
                $arrSql [] = $this->parseTable_ ( true, true );
                $arrSql [] = $this->parseFrom_ ();
            } else { // using 方式关联删除
                $arrSql [] = 'FROM ' . $this->parseTable_ ( true );
                $arrSql [] = $this->parseUsing_ ( true );
            }
            $arrSql [] = $this->parseWhere_ ();
            $arrSql [] = $this->parseOrder_ ( true );
            $arrSql [] = $this->parseLimitcount_ ( true, true );
            $mixData = implode ( ' ', $arrSql );
            unset ( $arrSql );
        }
        $arrBind = array_merge ( $this->getBindParams_ (), $arrBind );
        
        $this->sql ( $bFlag )->setNativeSql_ ( 'delete' );
        return call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], [ 
                $mixData,
                $arrBind 
        ] );
    }
    
    /**
     * 清空表重置自增 ID
     *
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return void
     */
    public function truncate($bFlag = false) {
        // 构造 truncate 语句
        $arrSql = [ ];
        $arrSql [] = 'TRUNCATE TABLE';
        $arrSql [] = $this->parseTable_ ( true );
        $arrSql = implode ( ' ', $arrSql );
        
        $this->sql ( $bFlag )->setNativeSql_ ( 'statement' );
        call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], [ 
                $arrSql 
        ] );
    }
    
    /**
     * 声明 statement 运行一般 sql,无返回
     *
     * @param string $strData            
     * @param array $arrBind            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return void
     */
    public function statement($strData, $arrBind = [], $bFlag = false) {
        assert::string ( $strData );
        $this->sql ( $bFlag )->setNativeSql_ ( 'statement' );
        call_user_func_array ( [ 
                $this,
                'runNativeSql_' 
        ], [ 
                $strData,
                $arrBind 
        ] );
    }
    
    /**
     * 返回一条记录
     *
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return mixed
     */
    public function getOne($bFlag = false) {
        return $this->sql ( $bFlag, true )->one ()->query_ ();
    }
    
    /**
     * 返回所有记录
     *
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return mixed
     */
    public function getAll($bFlag = false) {
        if ($this->arrOption ['limitquery']) {
            return $this->sql ( $bFlag, true )->query_ ();
        } else {
            return $this->sql ( $bFlag, true )->all ()->query_ ();
        }
    }
    
    /**
     * 返回最后几条记录
     *
     * @param mixed $nNum            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return mixed
     */
    public function get($nNum = null, $bFlag = false) {
        if (! is_null ( $nNum )) {
            return $this->sql ( $bFlag, true )->top ( $nNum )->query_ ();
        } else {
            return $this->sql ( $bFlag, true )->query_ ();
        }
    }
    
    /**
     * 返回一个字段的值
     *
     * @param string $strField            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return mixed
     */
    public function value($strField, $bFlag = false) {
        $arrRow = ( array ) $this->sql ( $bFlag, true )->setColumns ( $strField )->getOne ();
        if ($bFlag === true) {
            return $arrRow;
        }
        return isset ( $arrRow [$strField] ) ? $arrRow [$strField] : null;
    }
    
    /**
     * 返回一列数据
     *
     * @param mixed $mixFieldValue            
     * @param string $strFieldKey            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return array
     */
    public function lists($mixFieldValue, $strFieldKey = null, $bFlag = false) {
        // 纵然有弱水三千，我也只取一瓢 (第一个字段为值，第二个字段为键值，多余的字段丢弃)
        $arrField = [ ];
        if (is_array ( $mixFieldValue )) {
            $arrField = $mixFieldValue;
        } else {
            $arrField [] = $mixFieldValue;
        }
        if (is_string ( $strFieldKey )) {
            $arrField [] = $strFieldKey;
        }
        
        // 解析结果
        $arrResult = [ ];
        foreach ( ( array ) $this->sql ( $bFlag, true )->setColumns ( $arrField )->getAll () as $arrTemp ) {
            if ($bFlag === true) {
                $arrResult [] = $arrTemp;
                continue;
            }
            
            $arrTemp = ( array ) $arrTemp;
            if (count ( $arrTemp ) == 1) {
                $arrResult [] = reset ( $arrTemp );
            } else {
                $mixValue = array_shift ( $arrTemp );
                $mixKey = array_shift ( $arrTemp );
                $arrResult [$mixKey] = $mixValue;
            }
        }
        return $arrResult;
    }
    
    /**
     * 总记录数
     *
     * @param string $strField            
     * @param string $sAlias            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return int
     */
    public function getCount($strField = '*', $sAlias = 'row_count', $bFlag = false) {
        $arrRow = ( array ) $this->sql ( $bFlag, true )->count ( $strField, $sAlias )->get ();
        if ($bFlag === true) {
            return $arrRow;
        }
        return intval ( $arrRow [$sAlias] );
    }
    
    /**
     * 平均数
     *
     * @param string $strField            
     * @param string $sAlias            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return number
     */
    public function getAvg($strField, $sAlias = 'avg_value', $bFlag = false) {
        $arrRow = ( array ) $this->sql ( $bFlag, true )->avg ( $strField, $sAlias )->get ();
        if ($bFlag === true) {
            return $arrRow;
        }
        return ( float ) $arrRow [$sAlias];
    }
    
    /**
     * 最大值
     *
     * @param string $strField            
     * @param string $sAlias            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return number
     */
    public function getMax($strField, $sAlias = 'max_value', $bFlag = false) {
        $arrRow = ( array ) $this->sql ( $bFlag, true )->max ( $strField, $sAlias )->get ();
        if ($bFlag === true) {
            return $arrRow;
        }
        return ( float ) $arrRow [$sAlias];
    }
    
    /**
     * 最小值
     *
     * @param string $strField            
     * @param string $sAlias            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return number
     */
    public function getMin($strField, $sAlias = 'min_value', $bFlag = false) {
        $arrRow = ( array ) $this->sql ( $bFlag, true )->min ( $strField, $sAlias )->get ();
        if ($bFlag === true) {
            return $arrRow;
        }
        return ( float ) $arrRow [$sAlias];
    }
    
    /**
     * 合计
     *
     * @param string $strField            
     * @param string $sAlias            
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @return number
     */
    public function getSum($strField, $sAlias = 'sum_value', $bFlag = false) {
        $arrRow = ( array ) $this->sql ( $bFlag, true )->sum ( $strField, $sAlias )->get ();
        if ($bFlag === true) {
            return $arrRow;
        }
        return $arrRow [$sAlias];
    }
    
    // ######################################################
    // ------------------- 返回查询结果 end --------------------
    // ######################################################
    
    // ######################################################
    // ------------------ 构造查询条件 start -------------------
    // ######################################################
    
    /**
     * 时间控制语句开始
     *
     * @return void
     */
    public function time() {
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        $this->setInTimeCondition_ ( isset ( $arrArgs [0] ) && in_array ( $arrArgs [0], [ 
                'date',
                'month',
                'year',
                'day' 
        ] ) ? $arrArgs [0] : null );
    }
    
    /**
     * 时间控制语句结束
     *
     * @return void
     */
    public function endTime() {
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setInTimeCondition_ ( null );
    }
    
    /**
     * 指定返回 SQL 不做任何操作
     *
     * @param bool $bFlag
     *            指示是否不做任何操作只返回 SQL
     * @param bool $bQuickSql
     *            如果快捷为 true,而原来的 $booOnlyMakeSql 为 true，则不做任何修改，只能通过手动方式修改
     * @return $this
     */
    public function sql($bFlag = true, $bQuickSql = false) {
        if ($this->checkFlowControl_ ())
            return $this;
        if ($bFlag === false && $bQuickSql === true && $this->booOnlyMakeSql === true) { // 优先级最高 $this->sql(true, false)
            return $this;
        }
        $this->booOnlyMakeSql = ( bool ) $bFlag;
        return $this;
    }
    
    /**
     * 设置是否查询主服务器
     *
     * @param boolean $booMaster            
     * @return $this
     */
    public function asMaster($booMaster = false) {
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
        if ($sOption == null) {
            $this->initOption_ ();
        } elseif (array_key_exists ( $sOption, static::$arrOptionDefault )) {
            $this->arrOption [$sOption] = static::$arrOptionDefault [$sOption];
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
        if ($this->checkFlowControl_ ())
            return $this;
        $mixPrefix = helper::arrays ( $mixPrefix );
        foreach ( $mixPrefix as $strValue ) {
            $strValue = helper::arrays ( $strValue );
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
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setIsTable_ ( true );
        $this->join_ ( 'inner join', $mixTable, $mixCols );
        $this->setIsTable_ ( false );
        return $this;
    }
    
    /**
     * 添加一个 using 用于删除操作
     *
     * @param string|array $mixName            
     * @return $this
     */
    public function using($mixName) {
        if ($this->checkFlowControl_ ())
            return $this;
        $mixName = helper::arrays ( $mixName );
        foreach ( $mixName as $sAlias => $sTable ) {
            // 字符串指定别名
            if (preg_match ( '/^(.+)\s+AS\s+(.+)$/i', $sTable, $arrMatch )) {
                $sAlias = $arrMatch [2];
                $sTable = $arrMatch [1];
            }
            
            if (! is_string ( $sAlias )) {
                $sAlias = $sTable;
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
            
            $this->arrOption ['using'] [$sAlias] = [ 
                    'table_name' => $sTable,
                    'schema' => $sSchema 
            ];
        }
        
        return $this;
    }
    
    /**
     * 添加字段
     *
     * @param mixed $mixCols            
     * @param string $strTable            
     * @return $this
     */
    public function columns($mixCols = '*', $strTable = null) {
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, static::LOGIC_AND );
        array_unshift ( $arrArgs, 'where' );
        return call_user_func_array ( [ 
                $this,
                'aliasTypeAndLogic_' 
        ], $arrArgs );
    }
    
    /**
     * whereBetween 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereBetween($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'where', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'between' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * whereNotBetween 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereNotBetween($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'where', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'not between' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * whereIn 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereIn($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'where', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'in' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * whereNotIn 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereNotIn($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'where', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'not in' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * whereNull 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereNull($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'where', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'null' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * whereNotNull 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereNotNull($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'where', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'not null' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * whereLike 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereLike($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'where', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'like' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * whereNotLike 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereNotLike($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'where', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'not like' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * whereDate 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereDate($mixCond /* args */){
        $this->setInTimeCondition_ ( 'date' );
        call_user_func_array ( [ 
                $this,
                'where' 
        ], func_get_args () );
        $this->setInTimeCondition_ ( null );
        return $this;
    }
    
    /**
     * whereMonth 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereMonth($mixCond /* args */){
        $this->setInTimeCondition_ ( 'month' );
        call_user_func_array ( [ 
                $this,
                'where' 
        ], func_get_args () );
        $this->setInTimeCondition_ ( null );
        return $this;
    }
    
    /**
     * whereDay 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereDay($mixCond /* args */){
        $this->setInTimeCondition_ ( 'day' );
        call_user_func_array ( [ 
                $this,
                'where' 
        ], func_get_args () );
        $this->setInTimeCondition_ ( null );
        return $this;
    }
    
    /**
     * whereYear 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function whereYear($mixCond /* args */){
        $this->setInTimeCondition_ ( 'year' );
        call_user_func_array ( [ 
                $this,
                'where' 
        ], func_get_args () );
        $this->setInTimeCondition_ ( null );
        return $this;
    }
    
    /**
     * orWhere 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function orWhere($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, static::LOGIC_OR );
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
        if ($this->checkFlowControl_ ())
            return $this;
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
     * not exists 方法支持
     *
     * @return $this
     */
    public function whereNotExists(/* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        return call_user_func_array ( [ 
                $this,
                'addConditions_' 
        ], [ 
                [ 
                        'notexists__' => $arrArgs [0] 
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
        if ($this->checkFlowControl_ ())
            return $this;
        if (is_array ( $mixName )) {
            foreach ( $mixName as $mixKey => $mixValue ) {
                if (! is_array ( $mixValue )) {
                    $mixValue = [ 
                            $mixValue,
                            $intType 
                    ];
                }
                $this->arrBindParams [$mixKey] = $mixValue;
            }
        } else {
            if (is_null ( $mixValue )) {
                $mixValue = [ 
                        $mixName,
                        $intType 
                ];
                $this->arrBindParams [] = $mixValue;
            } else {
                if (! is_array ( $mixValue )) {
                    $mixValue = [ 
                            $mixValue,
                            $intType 
                    ];
                }
                
                $this->arrBindParams [$mixName] = $mixValue;
            }
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
        if ($this->checkFlowControl_ ())
            return $this;
        if (! isset ( static::$arrIndexTypes [$sType] )) {
            exceptions::throwException ( __ ( '无效的 Index 类型 %s', $sType ), 'queryyetsimple\database\exception' );
        }
        $sType = strtoupper ( $sType );
        $mixIndex = helper::arrays ( $mixIndex );
        foreach ( $mixIndex as $strValue ) {
            $strValue = helper::arrays ( $strValue );
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
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'inner join' );
        return call_user_func_array ( [ 
                $this,
                'join_' 
        ], $arrArgs );
    }
    
    /**
     * innerJoin 查询
     *
     * @param mixed $mixTable
     *            同 table $mixTable
     * @param string|array $mixCols
     *            同 table $mixCols
     * @param mixed $mixCond
     *            同 where $mixCond
     * @return $this
     */
    public function innerJoin($mixTable, $mixCols = '*', $mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'inner join' );
        return call_user_func_array ( [ 
                $this,
                'join_' 
        ], $arrArgs );
    }
    
    /**
     * leftJoin 查询
     *
     * @param mixed $mixTable
     *            同 table $mixTable
     * @param string|array $mixCols
     *            同 table $mixCols
     * @param mixed $mixCond
     *            同 where $mixCond
     * @return $this
     */
    public function leftJoin($mixTable, $mixCols = '*', $mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'left join' );
        return call_user_func_array ( [ 
                $this,
                'join_' 
        ], $arrArgs );
    }
    
    /**
     * rightJoin 查询
     *
     * @param mixed $mixTable
     *            同 table $mixTable
     * @param string|array $mixCols
     *            同 table $mixCols
     * @param mixed $mixCond
     *            同 where $mixCond
     * @return $this
     */
    public function rightJoin($mixTable, $mixCols = '*', $mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'right join' );
        return call_user_func_array ( [ 
                $this,
                'join_' 
        ], $arrArgs );
    }
    
    /**
     * fullJoin 查询
     *
     * @param mixed $mixTable
     *            同 table $mixTable
     * @param string|array $mixCols
     *            同 table $mixCols
     * @param mixed $mixCond
     *            同 where $mixCond
     * @return $this
     */
    public function fullJoin($mixTable, $mixCols = '*', $mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'full join' );
        return call_user_func_array ( [ 
                $this,
                'join_' 
        ], $arrArgs );
    }
    
    /**
     * crossJoin 查询
     *
     * @param mixed $mixTable
     *            同 table $mixTable
     * @param string|array $mixCols
     *            同 table $mixCols
     * @param mixed $mixCond
     *            同 where $mixCond
     * @return $this
     */
    public function crossJoin($mixTable, $mixCols = '*', $mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'cross join' );
        return call_user_func_array ( [ 
                $this,
                'join_' 
        ], $arrArgs );
    }
    
    /**
     * naturalJoin 查询
     *
     * @param mixed $mixTable
     *            同 table $mixTable
     * @param string|array $mixCols
     *            同 table $mixCols
     * @param mixed $mixCond
     *            同 where $mixCond
     * @return $this
     */
    public function naturalJoin($mixTable, $mixCols = '*', $mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'natural join' );
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
        if ($this->checkFlowControl_ ())
            return $this;
        if (! isset ( static::$arrUnionTypes [$sType] )) {
            exceptions::throwException ( __ ( '无效的 UNION 类型 %s', $sType ), 'queryyetsimple\database\exception' );
        }
        
        if (! is_array ( $mixSelect )) {
            $mixSelect = [ 
                    $mixSelect 
            ];
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
        if ($this->checkFlowControl_ ())
            return $this;
        return $this->union ( $mixSelect, 'UNION ALL' );
    }
    
    /**
     * 指定 GROUP BY 子句
     *
     * @param string|array $mixExpr            
     * @return $this
     */
    public function groupBy($mixExpr) {
        if ($this->checkFlowControl_ ())
            return $this;
            // 处理条件表达式
        if (is_string ( $mixExpr ) && strpos ( $mixExpr, ',' ) !== false && strpos ( $mixExpr, '{' ) !== false && preg_match_all ( '/{(.+?)}/', $mixExpr, $arrRes )) {
            $mixExpr = str_replace ( $arrRes [1] [0], base64_encode ( $arrRes [1] [0] ), $mixExpr );
        }
        $mixExpr = helper::arrays ( $mixExpr );
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
            $strValue = helper::arrays ( $strValue );
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
                $strTemp = $this->qualifyOneColumn_ ( $strTemp, $strTableName );
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
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, static::LOGIC_AND );
        array_unshift ( $arrArgs, 'having' );
        return call_user_func_array ( [ 
                $this,
                'aliasTypeAndLogic_' 
        ], $arrArgs );
    }
    
    /**
     * havingBetween 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingBetween($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'having', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'between' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * havingNotBetween 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingNotBetween($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'having', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'not between' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * havingIn 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingIn($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'having', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'in' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * havingNotIn 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingNotIn($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'having', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'not in' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * havingNull 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingNull($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'having', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'null' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * havingNotNull 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingNotNull($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'having', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'not null' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * havingLike 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingLike($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'having', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'like' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * havingNotLike 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingNotLike($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $this->setTypeAndLogic_ ( 'having', static::LOGIC_AND );
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, 'not like' );
        return call_user_func_array ( [ 
                $this,
                'aliasCondition_' 
        ], $arrArgs );
    }
    
    /**
     * havingDate 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingDate($mixCond /* args */){
        $this->setInTimeCondition_ ( 'date' );
        call_user_func_array ( [ 
                $this,
                'having' 
        ], func_get_args () );
        $this->setInTimeCondition_ ( null );
        return $this;
    }
    
    /**
     * havingMonth 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingMonth($mixCond /* args */){
        $this->setInTimeCondition_ ( 'month' );
        call_user_func_array ( [ 
                $this,
                'having' 
        ], func_get_args () );
        $this->setInTimeCondition_ ( null );
        return $this;
    }
    
    /**
     * havingDay 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingDay($mixCond /* args */){
        $this->setInTimeCondition_ ( 'day' );
        call_user_func_array ( [ 
                $this,
                'having' 
        ], func_get_args () );
        $this->setInTimeCondition_ ( null );
        return $this;
    }
    
    /**
     * havingYear 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function havingYear($mixCond /* args */){
        $this->setInTimeCondition_ ( 'year' );
        call_user_func_array ( [ 
                $this,
                'having' 
        ], func_get_args () );
        $this->setInTimeCondition_ ( null );
        return $this;
    }
    
    /**
     * orHaving 查询条件
     *
     * @param mixed $mixCond            
     * @return $this
     */
    public function orHaving($mixCond /* args */){
        if ($this->checkFlowControl_ ())
            return $this;
        $arrArgs = func_get_args ();
        array_unshift ( $arrArgs, static::LOGIC_OR );
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
        if ($this->checkFlowControl_ ())
            return $this;
        
        $sOrderDefault = strtoupper ( $sOrderDefault ); // 格式化为大写
                                                        
        // 处理条件表达式
        if (is_string ( $mixExpr ) && strpos ( $mixExpr, ',' ) !== false && strpos ( $mixExpr, '{' ) !== false && preg_match_all ( '/{(.+?)}/', $mixExpr, $arrRes )) {
            $mixExpr = str_replace ( $arrRes [1] [0], base64_encode ( $arrRes [1] [0] ), $mixExpr );
        }
        $mixExpr = helper::arrays ( $mixExpr );
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
            $strValue = helper::arrays ( $strValue );
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
     * 最近排序数据
     *
     * @param string $mixField            
     * @return $this
     */
    public function latest($mixField = 'create_at') {
        return $this->orderBy ( $mixField, 'DESC' );
    }
    
    /**
     * 最早排序数据
     *
     * @param string $mixField            
     * @return $this
     */
    public function oldest($mixField = 'create_at') {
        return $this->orderBy ( $mixField, 'ASC' );
    }
    
    /**
     * 创建一个 SELECT DISTINCT 查询
     *
     * @param bool $bFlag
     *            指示是否是一个 SELECT DISTINCT 查询（默认 true）
     * @return $this
     */
    public function distinct($bFlag = true) {
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
        return $this->addAggregate_ ( 'SUM', $strField, $sAlias );
    }
    
    /**
     * 指示仅查询第一个符合条件的记录
     *
     * @return $this
     */
    public function one() {
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
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
        if ($this->checkFlowControl_ ())
            return $this;
        return $this->limit ( 0, $nCount );
    }
    
    /**
     * limit 限制条数
     *
     * @param number $nOffset            
     * @param number $nCount            
     * @return $this
     */
    public function limit($nOffset = 0, $nCount = null) {
        if ($this->checkFlowControl_ ())
            return $this;
        if (is_null ( $nCount )) {
            return $this->top ( $nOffset );
        } else {
            $this->arrOption ['limitcount'] = abs ( intval ( $nCount ) );
            $this->arrOption ['limitoffset'] = abs ( intval ( $nOffset ) );
            $this->arrOption ['limitquery'] = true;
        }
        return $this;
    }
    
    /**
     * 是否构造一个 FOR UPDATE 查询
     *
     * @param boolean $bFlag            
     * @return $this
     */
    public function forUpdate($bFlag = true) {
        if ($this->checkFlowControl_ ())
            return $this;
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
     * @param
     *            $booWithLogicGroup
     * @return string
     */
    public function makeSql($booWithLogicGroup = false) {
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
        
        if ($booWithLogicGroup === true) {
            return static::LOGIC_GROUP_LEFT . $this->_sLastSql . static::LOGIC_GROUP_RIGHT;
        } else {
            return $this->_sLastSql;
        }
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
     * 解析 from 分析结果
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
            
            // 表名子表达式支持
            if (strpos ( $arrTable ['table_name'], '(' ) !== false) {
                $sTmp .= $arrTable ['table_name'] . ' ' . $sAlias;
            } elseif ($sAlias == $arrTable ['table_name']) {
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
     * 解析 table 分析结果
     *
     * @param boolean $booOnlyAlias            
     * @param Boolean $booForDelete            
     * @return string
     */
    private function parseTable_($booOnlyAlias = true, $booForDelete = false) {
        if (empty ( $this->arrOption ['from'] )) {
            return '';
        }
        
        // 如果为删除,没有 join 则返回为空
        if ($booForDelete === true && count ( $this->arrOption ['from'] ) == 1) {
            return '';
        }
        
        foreach ( $this->arrOption ['from'] as $sAlias => $arrTable ) {
            if ($sAlias == $arrTable ['table_name']) {
                return $this->objConnect->qualifyTableOrColumn ( "{$arrTable['schema']}.{$arrTable['table_name']}" );
            } else {
                if ($booOnlyAlias === true) {
                    return $sAlias;
                } else {
                    // 表名子表达式支持
                    if (strpos ( $arrTable ['table_name'], '(' ) !== false) {
                        return $arrTable ['table_name'] . ' ' . $sAlias;
                    } else {
                        return $this->objConnect->qualifyTableOrColumn ( "{$arrTable['schema']}.{$arrTable['table_name']}", $sAlias );
                    }
                }
            }
            break;
        }
    }
    
    /**
     * 解析 using 分析结果
     *
     * @param Boolean $booForDelete            
     * @return string
     */
    private function parseUsing_($booForDelete = false) {
        // parse using 只支持删除操作
        if ($booForDelete === false || empty ( $this->arrOption ['using'] )) {
            return '';
        }
        
        $arrUsing = [ ];
        $arrOptionUsing = $this->arrOption ['using'];
        foreach ( $this->arrOption ['from'] as $sAlias => $arrTable ) { // table 自动加入
            $arrOptionUsing [$sAlias] = $arrTable;
            break;
        }
        
        foreach ( $arrOptionUsing as $sAlias => $arrTable ) {
            if ($sAlias == $arrTable ['table_name']) {
                $arrUsing [] = $this->objConnect->qualifyTableOrColumn ( "{$arrTable['schema']}.{$arrTable['table_name']}" );
            } else {
                $arrUsing [] = $this->objConnect->qualifyTableOrColumn ( "{$arrTable['schema']}.{$arrTable['table_name']}", $sAlias );
            }
        }
        
        return 'USING ' . implode ( ',', array_unique ( $arrUsing ) );
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
     * @param boolean $booForDelete            
     * @return string
     */
    private function parseOrder_($booForDelete = false) {
        if (empty ( $this->arrOption ['order'] )) {
            return '';
        }
        // 删除存在 join, order 无效
        if ($booForDelete === true && (count ( $this->arrOption ['from'] ) > 1 || ! empty ( $this->arrOption ['using'] ))) {
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
     * @param boolean $booNullLimitOffset            
     * @param boolean $booForDelete            
     * @return string
     */
    private function parseLimitcount_($booNullLimitOffset = false, $booForDelete = false) {
        // 删除存在 join, limit 无效
        if ($booForDelete === true && (count ( $this->arrOption ['from'] ) > 1 || ! empty ( $this->arrOption ['using'] ))) {
            return '';
        }
        
        if ($booNullLimitOffset === true) {
            $this->arrOption ['limitoffset'] = null;
        }
        
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
                    static::LOGIC_AND,
                    static::LOGIC_OR 
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
                
                // 分析是否存在自动格式化时间标识
                $strFindTime = null;
                if (strpos ( $mixCond [1], '@' ) === 0) {
                    foreach ( [ 
                            'date',
                            'month',
                            'day',
                            'year' 
                    ] as $strTimeType ) {
                        if (stripos ( $mixCond [1], '@' . $strTimeType ) === 0) {
                            $strFindTime = $strTimeType;
                            $mixCond [1] = ltrim ( substr ( $mixCond [1], strlen ( $strTimeType ) + 1 ) );
                            break;
                        }
                    }
                    if ($strFindTime === null) {
                        exceptions::throwException ( __ ( '你正在尝试一个不受支持的时间处理语法' ), 'queryyetsimple\database\exception' );
                    }
                }
                
                // 格式化字段值，支持数组
                if (isset ( $mixCond [2] )) {
                    $booIsArray = true;
                    if (! is_array ( $mixCond [2] )) {
                        $mixCond [2] = [ 
                                $mixCond [2] 
                        ];
                        $booIsArray = false;
                    }
                    
                    foreach ( $mixCond [2] as &$strTemp ) {
                        // 对象子表达式支持
                        if ($strTemp instanceof select) {
                            $strTemp = $strTemp->makeSql ( true );
                        }                        

                        // 回调方法子表达式支持
                        elseif (is_callable ( $strTemp )) {
                            $objSelect = new self ( $this->objConnect );
                            $objSelect->setCurrentTable_ ( $this->getCurrentTable_ () );
                            $mixResultCallback = call_user_func_array ( $strTemp, [ 
                                    &$objSelect 
                            ] );
                            if (is_null ( $mixResultCallback )) {
                                $strTemp = $objSelect->makeSql ( true );
                            } else {
                                $strTemp = $mixResultCallback;
                            }
                        }                        

                        // 字符串子表达式支持
                        elseif (strpos ( trim ( $strTemp ), '(' ) === 0) {
                        }                        

                        // 表达式支持
                        elseif (strpos ( $strTemp, '{' ) !== false && preg_match ( '/^{(.+?)}$/', $strTemp, $arrRes )) {
                            $strTemp = $this->objConnect->qualifyExpression ( $arrRes [1], $strTable, $this->arrColumnsMapping );
                        } else {
                            // 自动格式化时间
                            if ($strFindTime !== null) {
                                $strTemp = $this->parseTime_ ( $mixCond [0], $strTemp, $strFindTime );
                            }
                            $strTemp = $this->objConnect->qualifyColumnValue ( $strTemp );
                        }
                    }
                    
                    if ($booIsArray === false || (count ( $mixCond [2] ) == 1 && strpos ( trim ( $mixCond [2] [0] ), '(' ) === 0)) {
                        $mixCond [2] = reset ( $mixCond [2] );
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
                    $arrSqlCond [] = $mixCond [0] . ' ' . strtoupper ( $mixCond [1] ) . ' ' . (is_array ( $mixCond [2] ) ? '(' . implode ( ',', $mixCond [2] ) . ')' : $mixCond [2]);
                } elseif (in_array ( $mixCond [1], [ 
                        'between',
                        'not between' 
                ] )) {
                    if (! is_array ( $mixCond [2] ) || count ( $mixCond [2] ) < 2) {
                        exceptions::throwException ( __ ( '[not] between 参数值必须是一个数组，不能少于 2 个元素' ), 'queryyetsimple\database\exception' );
                    }
                    $arrSqlCond [] = $mixCond [0] . ' ' . strtoupper ( $mixCond [1] ) . ' ' . $mixCond [2] [0] . ' AND ' . $mixCond [2] [1];
                } elseif (is_scalar ( $mixCond [2] )) {
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
        if (is_callable ( $mixCond )) {
            $objSelect = new self ( $this->objConnect );
            $objSelect->setCurrentTable_ ( $this->getCurrentTable_ () );
            $mixResultCallback = call_user_func_array ( $mixCond, [ 
                    &$objSelect 
            ] );
            if (is_null ( $mixResultCallback )) {
                $strParseType = 'parse' . ucwords ( $strType ) . '_';
                $strTemp = $objSelect->{$strParseType} ( true );
            } else {
                $strTemp = $mixResultCallback;
            }
            $this->setConditionItem_ ( static::LOGIC_GROUP_LEFT . $strTemp . static::LOGIC_GROUP_RIGHT, 'string__' );
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
            $arrArgs [0] = [ 
                    $arrArgs [0] 
            ];
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
                $arrArgs [0] = [ 
                        $arrArgs [0] 
                ];
            }
        }
        
        // 遍历数组拼接结果
        foreach ( $arrArgs [0] as $strKey => $arrTemp ) {
            if (! is_int ( $strKey )) {
                $strKey = trim ( $strKey );
            }
            
            // 字符串表达式
            if (is_string ( $strKey ) && $strKey == 'string__') {
                // 不符合规则抛出异常
                if (! is_string ( $arrTemp )) {
                    exceptions::throwException ( __ ( 'string__ 只支持字符串' ), 'queryyetsimple\database\exception' );
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
                    if (strtolower ( $arrTemp ['logic__'] ) == static::LOGIC_OR) {
                        $objSelect->setTypeAndLogic_ ( null, static::LOGIC_OR );
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
                $this->setTypeAndLogic_ ( null, 'subor__' ? static::LOGIC_OR : static::LOGIC_AND );
                $this->setConditionItem_ ( static::LOGIC_GROUP_LEFT . $objSelect->{$strParseType} ( true ) . static::LOGIC_GROUP_RIGHT, 'string__' );
                $this->setTypeAndLogic_ ( null, $strOldLogic );
            }            

            // exists 支持
            elseif (is_string ( $strKey ) && in_array ( $strKey, [ 
                    'exists__',
                    'notexists__' 
            ] )) {
                // having 不支持 [not] exists
                if ($this->getTypeAndLogic_ ()[0] == 'having') {
                    exceptions::throwException ( __ ( 'having 不支持 [not] exists  写法' ), 'queryyetsimple\database\exception' );
                }
                
                if ($arrTemp instanceof select) {
                    $arrTemp = $arrTemp->makeSql ();
                } elseif (is_callable ( $arrTemp )) {
                    $objSelect = new self ( $this->objConnect );
                    $objSelect->setCurrentTable_ ( $this->getCurrentTable_ () );
                    $mixResultCallback = call_user_func_array ( $arrTemp, [ 
                            &$objSelect 
                    ] );
                    if (is_null ( $mixResultCallback )) {
                        $strTemp = $arrTemp = $objSelect->makeSql ();
                    } else {
                        $strTemp = $mixResultCallback;
                    }
                }
                
                $arrTemp = ($strKey == 'notexists__' ? 'NOT EXISTS ' : 'EXISTS ') . static::LOGIC_GROUP_LEFT . ' ' . $arrTemp . ' ' . static::LOGIC_GROUP_RIGHT;
                $this->setConditionItem_ ( $arrTemp, 'string__' );
            }             

            // 其它
            else {
                // 处理字符串 "null"
                if (is_string ( $arrTemp )) {
                    $arrTemp = [ 
                            $arrTemp 
                    ];
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
                    $arrTemp [2] = $arrTemp [1];
                    $arrTemp [1] = '=';
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
                    if (isset ( $arrTemp [2] ) && is_string ( $arrTemp [2] )) {
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
        // 字符串类型
        if ($strType) {
            if (empty ( $this->arrOption [$arrTypeAndLogic [0]] [$strType] )) {
                $this->arrOption [$arrTypeAndLogic [0]] [] = $arrTypeAndLogic [1];
                $this->arrOption [$arrTypeAndLogic [0]] [$strType] = [ ];
            }
            $this->arrOption [$arrTypeAndLogic [0]] [$strType] [] = $arrItem;
        } else {
            // 格式化时间
            if (($strInTimeCondition = $this->getInTimeCondition_ ())) {
                $arrItem [1] = '@' . $strInTimeCondition . ' ' . $arrItem [1];
            }
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
     * 格式化一个字段
     *
     * @param string $strField            
     * @param string $sTableName            
     * @return string
     */
    private function qualifyOneColumn_($strField, $sTableName = null) {
        $strField = trim ( $strField );
        if (empty ( $strField )) {
            return '';
        }
        
        if (is_null ( $sTableName )) {
            $sTableName = $this->getCurrentTable_ ();
        }
        
        if (strpos ( $strField, '{' ) !== false && preg_match ( '/^{(.+?)}$/', $strField, $arrRes )) {
            $strField = $this->objConnect->qualifyExpression ( $arrRes [1], $sTableName, $this->arrColumnsMapping );
        } elseif (! preg_match ( '/\(.*\)/', $strField )) {
            if (preg_match ( '/(.+)\.(.+)/', $strField, $arrMatch )) {
                $sCurrentTableName = $arrMatch [1];
                $strTemp = $arrMatch [2];
            } else {
                $sCurrentTableName = $sTableName;
            }
            if (isset ( $this->arrColumnsMapping [$strField] )) {
                $strField = $this->arrColumnsMapping [$strField];
            }
            $strField = $this->objConnect->qualifyTableOrColumn ( "{$sCurrentTableName}.{$strField}" );
        }
        
        return $strField;
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
        if (! isset ( static::$arrJoinTypes [$sJoinType] )) {
            exceptions::throwException ( __ ( '无效的 JOIN 类型 %s', $sJoinType ), 'queryyetsimple\database\exception' );
        }
        
        // 不能在使用 UNION 查询的同时使用 JOIN 查询
        if (count ( $this->arrOption ['union'] )) {
            exceptions::throwException ( __ ( '不能在使用 UNION 查询的同时使用 JOIN 查询' ), 'queryyetsimple\database\exception' );
        }
        
        // 是否分析 schema，子表达式不支持
        $booParseSchema = true;
        
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
                
                // 对象子表达式
                if ($sTable instanceof select) {
                    $sTable = $sTable->makeSql ( true );
                    if (! $sAlias) {
                        $sAlias = static::DEFAULT_SUBEXPRESSION_ALIAS;
                    }
                    $booParseSchema = false;
                }                

                // 回调方法子表达式
                elseif (is_callable ( $sTable )) {
                    $objSelect = new self ( $this->objConnect );
                    $objSelect->setCurrentTable_ ( $this->getCurrentTable_ () );
                    $mixResultCallback = call_user_func_array ( $sTable, [ 
                            &$objSelect 
                    ] );
                    if (is_null ( $mixResultCallback )) {
                        $sTable = $objSelect->makeSql ( true );
                    } else {
                        $sTable = $mixResultCallback;
                    }
                    if (! $sAlias) {
                        $sAlias = static::DEFAULT_SUBEXPRESSION_ALIAS;
                    }
                    $booParseSchema = false;
                }
                break;
            }
        }        

        // 对象子表达式
        elseif ($mixName instanceof select) {
            $sTable = $mixName->makeSql ( true );
            $sAlias = static::DEFAULT_SUBEXPRESSION_ALIAS;
            $booParseSchema = false;
        }        

        // 回调方法
        elseif (is_callable ( $mixName )) {
            $objSelect = new self ( $this->objConnect );
            $objSelect->setCurrentTable_ ( $this->getCurrentTable_ () );
            $mixResultCallback = call_user_func_array ( $mixName, [ 
                    &$objSelect 
            ] );
            if (is_null ( $mixResultCallback )) {
                $sTable = $objSelect->makeSql ( true );
            } else {
                $sTable = $mixResultCallback;
            }
            $sAlias = static::DEFAULT_SUBEXPRESSION_ALIAS;
            $booParseSchema = false;
        }        

        // 字符串子表达式
        elseif (strpos ( trim ( $mixName ), '(' ) === 0) {
            if (($intAsPosition = strripos ( $mixName, 'as' )) !== false) {
                $sTable = trim ( substr ( $mixName, 0, $intAsPosition - 1 ) );
                $sAlias = trim ( substr ( $mixName, $intAsPosition + 2 ) );
            } else {
                $sTable = $mixName;
                $sAlias = static::DEFAULT_SUBEXPRESSION_ALIAS;
            }
            $booParseSchema = false;
        } else {
            // 字符串指定别名
            if (preg_match ( '/^(.+)\s+AS\s+(.+)$/i', $mixName, $arrMatch )) {
                $sTable = $arrMatch [1];
                $sAlias = $arrMatch [2];
            } else {
                $sTable = $mixName;
                $sAlias = '';
            }
        }
        
        // 确定 table_name 和 schema
        if ($booParseSchema === true) {
            $arrTemp = explode ( '.', $sTable );
            if (isset ( $arrTemp [1] )) {
                $sSchema = $arrTemp [0];
                $sTableName = $arrTemp [1];
            } else {
                $sSchema = null;
                $sTableName = $sTable;
            }
        } else {
            $sSchema = null;
            $sTableName = $sTable;
        }
        
        // 获得一个唯一的别名
        $sAlias = $this->uniqueAlias_ ( empty ( $sAlias ) ? $sTableName : $sAlias );
        
        // 只有表操作才设置当前表
        if ($this->getIsTable_ ()) {
            $this->setCurrentTable_ ( ($sSchema ? $sSchema . '.' : '') . $sAlias );
        }
        
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
        $mixCols = helper::arrays ( $mixCols );
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
                $mixCol = helper::arrays ( $mixCol );
                // 还原
                if (! empty ( $arrResTwo )) {
                    foreach ( $arrResTwo [1] as $strTemp ) {
                        $mixCol [array_search ( '{' . base64_encode ( $strTemp ) . '}', $mixCol, true )] = '{' . $strTemp . '}';
                    }
                }
                foreach ( helper::arrays ( $mixCol ) as $sCol ) { // 将包含多个字段的字符串打散
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
            if (preg_match ( '/(.+)\.(.+)/', $strField, $arrMatch )) { // 检查字段名是否包含表名称
                $strTableName = $arrMatch [1];
                $strField = $arrMatch [2];
            }
            if (isset ( $this->arrColumnsMapping [$strField] )) {
                $strField = $this->arrColumnsMapping [$strField];
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
        
        $arrArgs = [ 
                $strSql,
                $this->getBindParams_ (),
                $this->arrQueryParams ['master'],
                $this->arrQueryParams ['fetch_type'] ['fetch_type'],
                $this->arrQueryParams ['fetch_type'] ['fetch_argument'],
                $this->arrQueryParams ['fetch_type'] ['ctor_args'] 
        ];
        
        // 只返回 SQL，不做任何实际操作
        if ($this->booOnlyMakeSql === true) {
            return $arrArgs;
        }
        
        $arrData = call_user_func_array ( [ 
                $this->objConnect,
                'query' 
        ], $arrArgs );
        unset ( $arrArgs );
        
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
        if (! class_exists ( $sClassName )) {
            $this->queryDefault_ ( $arrData );
        }
        
        foreach ( $arrData as &$mixTemp ) {
            $mixTemp = new $sClassName ( ( array ) $mixTemp );
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
            $strSqlType = $this->objConnect->getSqlType ( $mixData );
            if ($strSqlType == 'procedure') {
                $strSqlType = 'select';
            }
            if ($strSqlType != $strNativeSql) {
                exceptions::throwException ( __ ( '%s 方法只允许运行 %s sql 语句', $strNativeSql, $strNativeSql ), 'queryyetsimple\database\exception' );
            }
            
            $arrArgs = func_get_args ();
            
            // 只返回 SQL，不做任何实际操作
            if ($this->booOnlyMakeSql === true) {
                return $arrArgs;
            }
            
            return call_user_func_array ( [ 
                    $this->objConnect,
                    $strNativeSql == 'select' ? 'query' : 'execute' 
            ], $arrArgs );
        } else {
            exceptions::throwException ( __ ( '%s 方法第一个参数只允许是 null 或者字符串', $strNativeSql ), 'queryyetsimple\database\exception' );
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
     * 返回参数绑定
     *
     * @param mixed $strBind            
     * @return array
     */
    private function getBindParams_($mixName = null) {
        if (is_null ( $mixName )) {
            return $this->arrBindParams;
        } else {
            return isset ( $this->arrBindParams [$mixName] ) ? $this->arrBindParams [$mixName] : null;
        }
    }
    
    /**
     * 判断是否有参数绑定支持
     *
     * @param mixed(int|string) $mixName            
     * @return boolean
     */
    private function isBindParams_($mixName) {
        return isset ( $this->arrBindParams [$mixName] );
    }
    
    /**
     * 删除参数绑定支持
     *
     * @param mixed(int|string) $mixName            
     * @return boolean
     */
    private function deleteBindParams_($mixName) {
        if (isset ( $this->arrBindParams [$mixName] )) {
            unset ( $this->arrBindParams [$mixName] );
        }
    }
    
    /**
     * 分析绑定参数数据
     *
     * @param array $arrData            
     * @param array $arrBind            
     * @param int $intQuestionMark            
     * @param int $intIndex            
     * @return void
     */
    private function getBindData_($arrData, &$arrBind = [], &$intQuestionMark = 0, $intIndex = 0) {
        $arrField = $arrValue = [ ];
        $strTableName = $this->getCurrentTable_ ();
        foreach ( $arrData as $sKey => $mixValue ) {
            if (is_null ( $mixValue )) {
                continue;
            }
            
            // 表达式支持
            $arrRes = null;
            if (strpos ( $mixValue, '{' ) !== false && preg_match ( '/^{(.+?)}$/', $mixValue, $arrRes )) {
                $mixValue = $this->objConnect->qualifyExpression ( $arrRes [1], $strTableName, $this->arrColumnsMapping );
            } else {
                $mixValue = $this->objConnect->qualifyColumnValue ( $mixValue, false );
            }
            
            // 字段
            if ($intIndex === 0) {
                $arrField [] = $sKey;
            }
            
            if (strpos ( $mixValue, ':' ) === 0 || ! empty ( $arrRes )) {
                $arrValue [] = $mixValue;
            } else {
                // 转换 ? 占位符至 : 占位符
                if ($mixValue == '?' && isset ( $arrBind [$intQuestionMark] )) {
                    $sKey = 'questionmark_' . $intQuestionMark;
                    $mixValue = $arrBind [$intQuestionMark];
                    unset ( $arrBind [$intQuestionMark] );
                    $this->deleteBindParams_ ( $intQuestionMark );
                    $intQuestionMark ++;
                }
                
                if ($intIndex > 0) {
                    $sKey = $sKey . '_' . $intIndex;
                }
                $arrValue [] = ':' . $sKey;
                $this->bind ( $sKey, $mixValue, $this->objConnect->getBindParamType ( $mixValue ) );
            }
        }
        
        return [ 
                $arrField,
                $arrValue 
        ];
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
     * 设置是否为表操作
     *
     * @param boolean $booIsTable            
     * @return void
     */
    private function setIsTable_($booIsTable = true) {
        $this->booIsTable = $booIsTable;
    }
    
    /**
     * 返回是否为表操作
     *
     * @return boolean
     */
    private function getIsTable_() {
        return $this->booIsTable;
    }
    
    /**
     * 解析时间信息
     *
     * @param string $sField            
     * @param mixed $mixValue            
     * @param string $strType            
     * @return mixed
     */
    private function parseTime_($sField, $mixValue, $strType) {
        static $arrDate = null, $arrColumns = [ ];
        
        // 获取时间和字段信息
        if ($arrDate === null) {
            $arrDate = getdate ();
        }
        $sField = str_replace ( '`', '', $sField );
        $strTable = $this->getCurrentTable_ ();
        if (! preg_match ( '/\(.*\)/', $sField )) {
            if (preg_match ( '/(.+)\.(.+)/', $sField, $arrMatch )) {
                $strTable = $arrMatch [1];
                $sField = $arrMatch [2];
            }
            if (isset ( $this->arrColumnsMapping [$sField] )) {
                $sField = $this->arrColumnsMapping [$sField];
            }
        }
        if ($sField == '*') {
            return '';
        }
        if (! isset ( $arrColumns [$strTable] )) {
            $arrColumns [$strTable] = $this->objConnect->getTableColumns ( $strTable )['list'];
        }
        
        // 支持类型
        switch ($strType) {
            case 'day' :
                $mixValue = mktime ( 0, 0, 0, $arrDate ['mon'], intval ( $mixValue ), $arrDate ['year'] );
                break;
            case 'month' :
                $mixValue = mktime ( 0, 0, 0, intval ( $mixValue ), 1, $arrDate ['year'] );
                break;
            case 'year' :
                $mixValue = mktime ( 0, 0, 0, 1, 1, intval ( $mixValue ) );
                break;
            case 'date' :
                $mixValue = strtotime ( $mixValue );
                if ($mixValue === false) {
                    exceptions::throwException ( __ ( '请输入一个支持 strtotime 正确的时间' ), 'queryyetsimple\database\exception' );
                }
                break;
            default :
                exceptions::throwException ( __ ( '不受支持的时间格式化类型 %s', $strType ), 'queryyetsimple\database\exception' );
                break;
        }
        
        // 自动格式化时间
        if (! empty ( $arrColumns [$strTable] [$sField] )) {
            $strFieldType = $arrColumns [$strTable] [$sField] ['type'];
            if (in_array ( $strFieldType, [ 
                    'datetime',
                    'timestamp' 
            ] )) {
                $mixValue = date ( 'Y-m-d H:i:s', $mixValue );
            } elseif ($strFieldType == 'date') {
                $mixValue = date ( 'Y-m-d', $mixValue );
            } elseif ($strFieldType == 'time') {
                $mixValue = date ( 'H:i:s', $mixValue );
            } elseif (strpos ( $strFieldType, 'year' ) === 0) {
                $mixValue = date ( 'Y', $mixValue );
            }
        }
        
        return $mixValue;
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
        
        if (is_array ( $mixName )) { // 数组，返回最后一个元素
            $strAliasReturn = end ( $mixName );
        } else { // 字符串
            $nDot = strrpos ( $mixName, '.' );
            $strAliasReturn = $nDot === false ? $mixName : substr ( $mixName, $nDot + 1 );
        }
        for($nI = 2; array_key_exists ( $strAliasReturn, $this->arrOption ['from'] ); ++ $nI) {
            $strAliasReturn = $mixName . '_' . ( string ) $nI;
        }
        
        return $strAliasReturn;
    }
    
    /**
     * 设置当前是否处于时间条件状态
     *
     * @param string $strInTimeCondition            
     * @return void
     */
    private function setInTimeCondition_($strInTimeCondition = null) {
        $this->strInTimeCondition = $strInTimeCondition;
    }
    
    /**
     * 返回当前是否处于时间条件状态
     *
     * @return string|null
     */
    private function getInTimeCondition_() {
        return $this->strInTimeCondition;
    }
    
    /**
     * 初始化查询条件
     *
     * @return void
     */
    private function initOption_() {
        $this->arrOption = static::$arrOptionDefault;
        $this->arrQueryParams = static::$arrQueryParamsDefault;
    }
    
    // ######################################################
    // -------------------- 私有方法 end ---------------------
    // ######################################################
}
