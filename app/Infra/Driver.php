<?php
declare(strict_types=1);

namespace App\Infra;

use Apps\Common\Logger\CustomLogger;
use Closure;
use Leevel\Database\Ddd\Entity;
use PDO;
use Think\Config;
use Think\Debug;
use Think\Log;

class Driver
{
    // PDO操作实例
    protected $PDOStatement = null;
    // 当前操作所属的模型名
    protected $model = '_think_';
    // 当前SQL指令
    protected $queryStr = '';
    protected $modelSql = array();
    // 最后插入ID
    protected $lastInsID = null;
    // 返回或者影响记录数
    protected $numRows = 0;
    // 错误信息
    protected $error = '';
    // 数据库连接参数配置
    protected $config = array(
        'type' => '',     // 数据库类型
        'hostname' => '127.0.0.1', // 服务器地址
        'database' => '',          // 数据库名
        'username' => '',      // 用户名
        'password' => '',          // 密码
        'hostport' => '',        // 端口
        'dsn' => '', //
        'params' => array(), // 数据库连接参数
        'charset' => 'utf8',      // 数据库编码默认采用utf8
        'prefix' => '',    // 数据库表前缀
        'debug' => false, // 数据库调试模式
        'deploy' => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
        'rw_separate' => false,       // 数据库读写是否分离 主从式有效
        'master_num' => 1, // 读写分离后 主服务器数量
        'slave_no' => '', // 指定从服务器序号
        'db_like_fields' => '',
    );
    // 数据库表达式
    protected $exp = array('eq' => '=', 'neq' => '<>', 'gt' => '>', 'egt' => '>=', 'lt' => '<', 'elt' => '<=', 'notlike' => 'NOT LIKE', 'like' => 'LIKE', 'in' => 'IN', 'notin' => 'NOT IN', 'not in' => 'NOT IN', 'between' => 'BETWEEN', 'not between' => 'NOT BETWEEN', 'notbetween' => 'NOT BETWEEN');
    // 查询表达式
    // 注释实现阿里云走主库 @see https://help.aliyun.com/document_detail/51225.html
    protected $selectSql = '%FORCE_MASTER%SELECT %FOUND_ROWS% %DISTINCT% %FIELD% FROM %TABLE%%FORCE%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%%LIMIT% %UNION%%LOCK%%COMMENT%';
    // 查询次数
    protected $queryTimes = 0;
    // 执行次数
    protected $executeTimes = 0;
    // PDO连接参数
    protected $options = array(
        PDO::ATTR_CASE => PDO::CASE_LOWER,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_TIMEOUT => 7200,
    );
    protected $bind = array(); // 参数绑定
    protected $totalCount = 0;
    protected Entity $entity;

    /**
     * 架构函数 读取数据库配置信息
     * @access public
     * @param array $config 数据库配置数组
     *
     */
    public function __construct($config = '', Entity $entity = null)
    {
        $this->entity = $entity;
        if (!empty($config)) {
            $this->config = array_merge($this->config, $config);
            if (is_array($this->config['params'])) {
                $this->options = $this->config['params'] + $this->options;
            }
        }
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function parseWhereAlias($where)
    {
        return $this->parseWhere($where);
    }

    /**
     * where分析
     * @access protected
     * @param mixed $where
     * @return string
     */
    protected function parseWhere($where)
    {
        $whereStr = '';
        if (is_string($where)) {
            // 直接使用字符串条件
            $whereStr = $where;
        } else { // 使用数组表达式
            $operate = isset($where['_logic']) ? strtoupper($where['_logic']) : '';
            if (in_array($operate, array('AND', 'OR', 'XOR'))) {
                // 定义逻辑运算规则 例如 OR XOR AND NOT
                $operate = ' ' . $operate . ' ';
                unset($where['_logic']);
            } else {
                // 默认进行 AND 运算
                $operate = ' AND ';
            }
            foreach ($where as $key => $val) {
                if (is_numeric($key)) {
                    $key = '_complex';
                }
                if (0 === strpos($key, '_')) {
                    // 解析特殊条件表达式
                    $whereStr .= $this->parseThinkWhere($key, $val);
                } else {
                    // 查询字段的安全过滤
                    // if(!preg_match('/^[A-Z_\|\&\-.a-z0-9\(\)\,]+$/',trim($key))){
                    //     E(L('_EXPRESS_ERROR_').':'.$key);
                    // }
                    // 多条件支持
                    $multi = is_array($val) && isset($val['_multi']);
                    $key = trim($key);
                    if (strpos($key, '|')) { // 支持 name|title|nickname 方式定义查询字段
                        $array = explode('|', $key);
                        $str = array();
                        foreach ($array as $m => $k) {
                            $v = $multi ? $val[$m] : $val;
                            $str[] = $this->parseWhereItem($this->parseKey($k), $v);
                        }
                        $whereStr .= '( ' . implode(' OR ', $str) . ' )';
                    } elseif (strpos($key, '&')) {
                        $array = explode('&', $key);
                        $str = array();
                        foreach ($array as $m => $k) {
                            $v = $multi ? $val[$m] : $val;
                            $str[] = '(' . $this->parseWhereItem($this->parseKey($k), $v) . ')';
                        }
                        $whereStr .= '( ' . implode(' AND ', $str) . ' )';
                    } else {
                        $whereStr .= $this->parseWhereItem($this->parseKey($key), $val);
                    }
                }
                $whereStr .= $operate;
            }
            $whereStr = substr($whereStr, 0, -strlen($operate));
        }
        return empty($whereStr) ? '' : ' WHERE ' . $whereStr;
    }

    /**
     * 特殊条件分析
     * @access protected
     * @param string $key
     * @param mixed $val
     * @return string
     */
    protected function parseThinkWhere($key, $val)
    {
        $whereStr = '';
        switch ($key) {
            case '_string':
                // 字符串模式查询条件
                $whereStr = $val;
                break;
            case '_complex':
                // 复合查询条件
                $whereStr = substr($this->parseWhere($val), 6);
                break;
            case '_query':
                // 字符串模式查询条件
                parse_str($val, $where);
                if (isset($where['_logic'])) {
                    $op = ' ' . strtoupper($where['_logic']) . ' ';
                    unset($where['_logic']);
                } else {
                    $op = ' AND ';
                }
                $array = array();
                foreach ($where as $field => $data)
                    $array[] = $this->parseKey($field) . ' = ' . $this->parseValue($data);
                $whereStr = implode($op, $array);
                break;
        }
        return '( ' . $whereStr . ' )';
    }

    /**
     * 字段和表名处理
     * @access protected
     * @param string $key
     * @return string
     */
    protected function parseKey(&$key)
    {
        $key = trim($key);
        if (!is_numeric($key) && !preg_match('/[,\'\"\*\(\)`.\s]/', $key)) {
            $key = '`' . $key . '`';
        }
        return $key;
    }

    /**
     * value分析
     * @access protected
     * @param mixed $value
     * @return string
     */
    protected function parseValue($value)
    {
        if (is_string($value)) {
            $value = strpos($value, ':') === 0 && in_array($value, array_keys($this->bind)) ? $this->escapeString($value) : '\'' . $this->escapeString($value) . '\'';
        } elseif (isset($value[0]) && is_string($value[0]) && strtolower($value[0]) == 'exp') {
            $value = $this->escapeString($value[1]);
        } elseif (is_array($value)) {
            $value = array_map(array($this, 'parseValue'), $value);
        } elseif (is_bool($value)) {
            $value = $value ? '1' : '0';
        } elseif (is_null($value)) {
            $value = 'null';
        }
        return $value;
    }

    /**
     * SQL指令安全过滤
     * @access public
     * @param string $str SQL字符串
     * @return string
     */
    public function escapeString(string $str): string
    {
        return addslashes($str);
    }

    protected function parseWhereItem($key, $val)
    {
        $whereStr = '';
        if (is_array($val)) {
            if (is_string($val[0])) {
                $exp = strtolower($val[0]);
                if (preg_match('/^(eq|neq|gt|egt|lt|elt)$/', $exp)) { // 比较运算
                    $whereStr .= $key . ' ' . $this->exp[$exp] . ' ' . $this->parseValue($val[1]);
                } elseif (preg_match('/^(notlike|like)$/', $exp)) {// 模糊查找
                    if (is_array($val[1])) {
                        $likeLogic = isset($val[2]) ? strtoupper($val[2]) : 'OR';
                        if (in_array($likeLogic, array('AND', 'OR', 'XOR'))) {
                            $like = array();
                            foreach ($val[1] as $item) {
                                $like[] = $key . ' ' . $this->exp[$exp] . ' ' . $this->parseValue($item);
                            }
                            $whereStr .= '(' . implode(' ' . $likeLogic . ' ', $like) . ')';
                        }
                    } else {
                        $whereStr .= $key . ' ' . $this->exp[$exp] . ' ' . $this->parseValue($val[1]);
                    }
                } elseif ('bind' == $exp) { // 使用表达式
                    $whereStr .= $key . ' = :' . $val[1];
                } elseif ('exp' == $exp) { // 使用表达式
                    $whereStr .= $key . ' ' . $val[1];
                } elseif (preg_match('/^(notin|not in|in)$/', $exp)) { // IN 运算
                    if (isset($val[2]) && 'exp' == $val[2]) {
                        $whereStr .= $key . ' ' . $this->exp[$exp] . ' ' . $val[1];
                    } else {
                        if (is_string($val[1])) {
                            $val[1] = explode(',', $val[1]);
                        }
                        $zone = implode(',', $this->parseValue($val[1]));
                        $whereStr .= $key . ' ' . $this->exp[$exp] . ' (' . $zone . ')';
                    }
                } elseif (preg_match('/^(notbetween|not between|between)$/', $exp)) { // BETWEEN运算
                    $data = is_string($val[1]) ? explode(',', $val[1]) : $val[1];
                    $whereStr .= $key . ' ' . $this->exp[$exp] . ' ' . $this->parseValue($data[0]) . ' AND ' . $this->parseValue($data[1]);
                } else {
                    E(L('_EXPRESS_ERROR_') . ':' . $val[0]);
                }
            } else {
                $count = count($val);
                $rule = isset($val[$count - 1]) ? (is_array($val[$count - 1]) ? strtoupper($val[$count - 1][0]) : strtoupper($val[$count - 1])) : '';
                if (in_array($rule, array('AND', 'OR', 'XOR'))) {
                    $count = $count - 1;
                } else {
                    $rule = 'AND';
                }
                for ($i = 0; $i < $count; $i++) {
                    $data = is_array($val[$i]) ? $val[$i][1] : $val[$i];
                    if ('exp' == strtolower($val[$i][0])) {
                        $whereStr .= $key . ' ' . $data . ' ' . $rule . ' ';
                    } else {
                        $whereStr .= $this->parseWhereItem($key, $val[$i]) . ' ' . $rule . ' ';
                    }
                }
                $whereStr = '( ' . substr($whereStr, 0, -4) . ' )';
            }
        } else {
            //对字符串类型字段采用模糊匹配
            $likeFields = $this->config['db_like_fields'];
            if ($likeFields && preg_match('/^(' . $likeFields . ')$/i', $key)) {
                $whereStr .= $key . ' LIKE ' . $this->parseValue('%' . $val . '%');
            } else {
                $whereStr .= $key . ' = ' . $this->parseValue($val);
            }
        }
        return $whereStr;
    }

    /**
     * 启动事务.
     */
    public function startTrans(): void
    {
        $this->entity::select()->beginTransaction();
    }

    /**
     * 用于非自动提交状态下面的查询提交.
     */
    public function commit(): void
    {
        $this->entity::select()->commit();
    }

    /**
     * 事务回滚.
     */
    public function rollback(): void
    {
        $this->entity::select()->rollBack();
    }

    /**
     * 事务处理
     *
     * - 大多数框架都封装这种用法，简化调用
     */
    public function transaction(Closure $businessLogic): mixed
    {
        return $this->entity::select()->transaction($businessLogic);
    }

    /**
     * 数据库错误信息
     * 并显示当前的SQL语句
     * @access public
     * @return string
     */
    public function error()
    {
        $this->error = !empty($this->PDOStatement) ? $this->PDOStatement->errorInfo()[1] . ':' . $this->PDOStatement->errorInfo()[2] : '';
        $this->error .= !empty($this->queryStr) ? "\n [ SQL语句 ] : " . $this->queryStr : '';
        // 记录错误日志
        trace($this->error, '', 'ERR');
        return true == $this->config['debug'] ? E($this->error) : $this->error;
    }

    /**
     * 插入记录
     * @access public
     * @param mixed $data 数据
     * @param array $options 参数表达式
     * @param boolean $replace 是否replace
     * @return false | integer
     */
    public function insert($data, $options = array(), $replace = false)
    {
        $values = $fields = array();
        $this->model = $options['model'];
        $this->parseBind(!empty($options['bind']) ? $options['bind'] : array());
        foreach ($data as $key => $val) {
            if (is_array($val) && 'exp' == $val[0]) {
                $fields[] = $this->parseKey($key);
                $values[] = $val[1];
            } elseif (is_scalar($val)) { // 过滤非标量数据
                $fields[] = $this->parseKey($key);
                if (is_string($val) && 0 === strpos($val, ':') && in_array($val, array_keys($this->bind))) {
                    $values[] = $this->parseValue($val);
                } else {
                    $name = count($this->bind);
                    $values[] = ':' . $name;
                    $this->bindParam($name, $val);
                }
            }
        }
        // 兼容数字传入方式
        $replace = (is_numeric($replace) && $replace > 0) ? true : $replace;
        $sql = (true === $replace ? 'REPLACE' : 'INSERT') . ' INTO ' . $this->parseTable($options['table']) . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')' . $this->parseDuplicate($replace);
        $sql .= $this->parseComment(!empty($options['comment']) ? $options['comment'] : '');
        return $this->execute($sql, !empty($options['fetch_sql']) ? true : false);
    }

    /**
     * 参数绑定分析
     * @access protected
     * @param array $bind
     * @return array
     */
    protected function parseBind($bind)
    {
        $this->bind = array_merge($this->bind, $bind);
    }

    /**
     * 参数绑定
     * @access protected
     * @param string $name 绑定参数名
     * @param mixed $value 绑定值
     * @return void
     */
    protected function bindParam($name, $value)
    {
        $this->bind[':' . $name] = $value;
    }

    /**
     * ON DUPLICATE KEY UPDATE 分析
     * @access protected
     * @param mixed $duplicate
     * @return string
     */
    protected function parseDuplicate($duplicate){
        // 布尔值或空则返回空字符串
        if(is_bool($duplicate) || empty($duplicate)) return '';

        if(is_string($duplicate)){
            // field1,field2 转数组
            $duplicate = explode(',', $duplicate);
        }elseif(is_object($duplicate)){
            // 对象转数组
            $duplicate = get_class_vars($duplicate);
        }
        $updates                    = array();
        foreach((array) $duplicate as $key=>$val){
            if(is_numeric($key)){ // array('field1', 'field2', 'field3') 解析为 ON DUPLICATE KEY UPDATE field1=VALUES(field1), field2=VALUES(field2), field3=VALUES(field3)
                $updates[]          = $this->parseKey($val)."=VALUES(".$this->parseKey($val).")";
            }else{
                if(is_scalar($val)) // 兼容标量传值方式
                    $val            = array('value', $val);
                if(!isset($val[1])) continue;
                switch($val[0]){
                    case 'exp': // 表达式
                        $updates[]  = $this->parseKey($key)."=($val[1])";
                        break;
                    case 'value': // 值
                    default:
                        $name       = count($this->bind);
                        $updates[]  = $this->parseKey($key)."=:".$name;
                        $this->bindParam($name, $val[1]);
                        break;
                }
            }
        }
        if(empty($updates)) return '';
        return " ON DUPLICATE KEY UPDATE ".join(', ', $updates);
    }

    /**
     * 执行语句
     * @access public
     * @param string $str sql指令
     * @param boolean $fetchSql 不执行只是获取SQL
     * @return mixed
     */
    public function execute($str, $fetchSql = false)
    {
        $this->queryStr = $str;
        if (!empty($this->bind)) {
            $that = $this;
            $this->queryStr = strtr($this->queryStr, array_map(function ($val) use ($that) {
                return '\'' . (is_string($val) ? $that->escapeString($val) : $val) . '\'';
            }, $this->bind));
        }

        if ($fetchSql) {
            return $this->queryStr;
        }
        $this->executeTimes++;
        // foreach ($this->bind as $key => $val) {
        //     if(is_array($val)){
        //         $this->PDOStatement->bindValue($key, $val[0], $val[1]);
        //     }else{
        //         $this->PDOStatement->bindValue($key, $val);
        //     }
        // }

        $this->bind = array();
        return $this->entity::select()->execute($this->queryStr);

        // // $result =   $this->PDOStatement->execute();
        //  if ( false === $result) {
        //      $this->error();
        //      return false;
        //  } else {
        //      $this->numRows = $this->PDOStatement->rowCount();
        //      if(preg_match("/^\s*(INSERT\s+INTO|REPLACE\s+INTO)\s+/i", $str)) {
        //          $this->lastInsID = $this->_linkID->lastInsertId();
        //      }
        //      return $this->numRows;
        //  }
    }

    /**
     * 批量插入记录
     * @access public
     * @param mixed $dataSet 数据集
     * @param array $options 参数表达式
     * @param boolean $replace 是否replace
     * @return false | integer
     */
    public function insertAll($dataSet,$options=array(),$replace=false) {
        $values  =  array();
        $this->model  =   $options['model'];
        if(!is_array($dataSet[0])) return false;
        $this->parseBind(!empty($options['bind'])?$options['bind']:array());
        $fields =  array_keys($dataSet[0]);
        array_walk($fields, array($this, 'parseKey'));
        foreach ($dataSet as $data){
            $value   =  array();
            foreach ($data as $key=>$val){
                if(is_array($val) && 'exp' == $val[0]){
                    $value[]   =  $val[1];
                }elseif(is_scalar($val) || is_null($val)){
                    if(0===strpos($val,':') && in_array($val,array_keys($this->bind))){
                        $value[]   =   $this->parseValue($val);
                    }else{
                        $name       =   count($this->bind);
                        $value[]   =   ':'.$name;
                        $this->bindParam($name,$val);
                    }
                }
            }
            $values[]    = '('.implode(',', $value).')';
        }
        // 兼容数字传入方式
        $replace= (is_numeric($replace) && $replace>0)?true:$replace;
        $sql    =  (true===$replace?'REPLACE':'INSERT').' INTO '.$this->parseTable($options['table']).' ('.implode(',', $fields).') VALUES '.implode(',',$values).$this->parseDuplicate($replace);
        $sql    .= $this->parseComment(!empty($options['comment'])?$options['comment']:'');

        return $this->execute($sql,!empty($options['fetch_sql']) ? true : false);
    }

    // where子单元分析

    /**
     * 通过Select方式插入记录
     * @access public
     * @param string $fields 要插入的数据表字段名
     * @param string $table 要插入的数据表名
     * @param array $option 查询数据参数
     * @return false | integer
     */
    public function selectInsert($fields, $table, $options = array())
    {
        $this->model = $options['model'];
        $this->parseBind(!empty($options['bind']) ? $options['bind'] : array());
        if (is_string($fields)) $fields = explode(',', $fields);
        array_walk($fields, array($this, 'parseKey'));
        $sql = 'INSERT INTO ' . $this->parseTable($table) . ' (' . implode(',', $fields) . ') ';
        $sql .= $this->buildSelectSql($options);
        return $this->execute($sql, !empty($options['fetch_sql']) ? true : false);
    }

    /**
     * 更新记录
     * @access public
     * @param mixed $data 数据
     * @param array $options 表达式
     * @return false | integer
     */
    public function update($data, $options)
    {
        $this->model = $options['model'];
        $this->parseBind(!empty($options['bind']) ? $options['bind'] : array());
        $table = $this->parseTable($options['table']);
        $sql = 'UPDATE ' . $table . $this->parseSet($data);
        if (strpos($table, ',')) {// 多表更新支持JOIN操作
            $sql .= $this->parseJoin(!empty($options['join']) ? $options['join'] : '');
        }
        $sql .= $this->parseWhere(!empty($options['where']) ? $options['where'] : '');
        if (!strpos($table, ',')) {
            //  单表更新支持order和lmit
            $sql .= $this->parseOrder(!empty($options['order']) ? $options['order'] : '')
                . $this->parseLimit(!empty($options['limit']) ? $options['limit'] : '');
        }
        $sql .= $this->parseComment(!empty($options['comment']) ? $options['comment'] : '');
        return $this->execute($sql, !empty($options['fetch_sql']) ? true : false);
    }

    /**
     * set分析
     * @access protected
     * @param array $data
     * @return string
     */
    protected function parseSet($data)
    {
        foreach ($data as $key => $val) {
            if (is_array($val) && 'exp' == $val[0]) {
                $set[] = $this->parseKey($key) . '=' . $val[1];
            } elseif (is_null($val)) {
                $set[] = $this->parseKey($key) . '=NULL';
            } elseif (is_scalar($val)) {// 过滤非标量数据
                if (is_string($val) && 0 === strpos($val, ':') && in_array($val, array_keys($this->bind))) {
                    $set[] = $this->parseKey($key) . '=' . $this->escapeString($val);
                } else {
                    $name = count($this->bind);
                    $set[] = $this->parseKey($key) . '=:' . $name;
                    $this->bindParam($name, $val);
                }
            }
        }
        return ' SET ' . implode(',', $set);
    }

    /**
     * 删除记录
     * @access public
     * @param array $options 表达式
     * @return false | integer
     */
    public function delete($options = array())
    {
        $this->model = $options['model'];
        $this->parseBind(!empty($options['bind']) ? $options['bind'] : array());
        $table = $this->parseTable($options['table']);
        $sql = 'DELETE FROM ' . $table;
        if (strpos($table, ',')) {// 多表删除支持USING和JOIN操作
            if (!empty($options['using'])) {
                $sql .= ' USING ' . $this->parseTable($options['using']) . ' ';
            }
            $sql .= $this->parseJoin(!empty($options['join']) ? $options['join'] : '');
        }
        $sql .= $this->parseWhere(!empty($options['where']) ? $options['where'] : '');
        if (!strpos($table, ',')) {
            // 单表删除支持order和limit
            $sql .= $this->parseOrder(!empty($options['order']) ? $options['order'] : '')
                . $this->parseLimit(!empty($options['limit']) ? $options['limit'] : '');
        }
        $sql .= $this->parseComment(!empty($options['comment']) ? $options['comment'] : '');
        return $this->execute($sql, !empty($options['fetch_sql']) ? true : false);
    }

    public function getFields()
    {
        $fields = array_keys($this->entity->fields());
        $primaryKey = $this->entity->primaryKey();

        return [
            'fields' => $fields,
            'primaryKey' => $primaryKey,
            'auto' => $this->entity->autoIncrement(),
        ];
    }

    /**
     * 查找记录
     * @access public
     * @param array $options 表达式
     * @return mixed
     */
    public function select($options = array())
    {
        $this->model = $options['model'];
        $this->parseBind(!empty($options['bind']) ? $options['bind'] : array());
        $sql = $this->buildSelectSql($options);
        $result = $this->query($sql, !empty($options['fetch_sql']) ? true : false, $options['cache'] ?? []);
        return $result;
    }

    /**
     * 执行查询 返回数据集
     * @access public
     * @param string $str sql指令
     * @param boolean $fetchSql 不执行只是获取SQL
     * @return mixed
     */
    public function query($str, $fetchSql = false, $cacheOptions = [])
    {
        $this->queryStr = $str;
        if (!empty($this->bind)) {
            $that = $this;
            $this->queryStr = strtr($this->queryStr, array_map(function ($val) use ($that) {
                return '\'' . $that->escapeString($val) . '\'';
            }, $this->bind));
        }

        if (preg_match('/SQL_CALC_FOUND_ROWS/i', $this->queryStr)) {
            $countSql = $this->queryStr;
            //移除最后一个的ORDER BY(理想情况是移除最外层的)
            if (preg_match('/\s+ORDER\s+BY\s+/i', $countSql, $matches)) {
                $countSql = removeLastStr($countSql, $matches[0]);
            }
            //移除最后一个的LIMIT(理想情况是移除最外层的)
            if (preg_match('/\s+LIMIT\s+/i', $countSql, $matches)) {
                $countSql = removeLastStr($countSql, $matches[0]);
            }
            //移除关键词：SQL_CALC_FOUND_ROWS
            $countSql = sprintf("SELECT count(*) as count FROM (%s) t", preg_replace('/SQL_CALC_FOUND_ROWS/i', ' ', $countSql));
            $count = $this->query($countSql);
            if ($count === false) {
                $this->totalCount = false;
            } else {
                $this->totalCount = $count['0']['count'];
            }
        }

        if ($fetchSql) {
            return $this->queryStr;
        }
        //释放前次的查询结果
        $this->queryTimes++;

        $this->bind = array();

        $result = $this->entity::select()
            ->query(
                $this->queryStr,
                [],
                false,
                $cacheOptions['key'] ?? null,
                $cacheOptions['expire'] ?? null,
            );
        foreach ($result as &$v) {
            $v = (array)$v;
        }

        return $result;
    }

    /**
     * 获取最近一次查询的sql语句
     * @param string $model 模型名
     * @access public
     * @return string
     */
    public function getLastSql($model = '')
    {
        return $model && isset($this->modelSql[$model]) ? $this->modelSql[$model] : $this->queryStr;
    }

    /**
     * 获取最近插入的ID
     * @access public
     * @return string
     */
    public function getLastInsID()
    {
        return $this->lastInsID;
    }

    /**
     * 获取最近的错误信息
     * @access public
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 设置当前操作模型
     * @access public
     * @param string $model 模型名
     * @return void
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * 析构方法
     * @access public
     */
    public function __destruct()
    {
    }

    /**
     * You can not serialize objects that can not be serialized. But you tried, so you got the exception. That's basically the whole issue. Just don't tell PHP to serialize objects that can't be serialized.
     */
    public function __sleep()
    {
        return array();
    }

    public function __wakeup()
    {
        return array();
    }

    public function getTotalCount()
    {
        if ($this->totalCount === false) {
            $data = $this->query('SELECT FOUND_ROWS() AS count');
            $this->totalCount = $data[0]['count'];
        }

        return $this->totalCount;
    }

    /**
     * union分析
     * @access protected
     * @param mixed $union
     * @return string
     */
    protected function parseUnion($union)
    {
        if (empty($union)) return '';
        if (isset($union['_all'])) {
            $str = 'UNION ALL ';
            unset($union['_all']);
        } else {
            $str = 'UNION ';
        }
        foreach ($union as $u) {
            $sql[] = $str . (is_array($u) ? $this->buildSelectSql($u) : $u);
        }
        return implode(' ', $sql);
    }

    /**
     * 生成查询SQL
     * @access public
     * @param array $options 表达式
     * @return string
     */
    public function buildSelectSql($options = array())
    {
        if (isset($options['page'])) {
            // 根据页数计算limit
            list($page, $listRows) = $options['page'];
            $page = $page > 0 ? $page : 1;
            $listRows = $listRows > 0 ? $listRows : (is_numeric($options['limit']) ? $options['limit'] : 20);
            $offset = $listRows * ($page - 1);
            $options['limit'] = $offset . ',' . $listRows;
        }
        $sql = $this->parseSql($this->selectSql, $options);
        return $sql;
    }

    /**
     * 替换SQL语句中表达式
     * @access public
     * @param array $options 表达式
     * @return string
     */
    public function parseSql($sql, $options = array())
    {
        $sql = str_replace(
            array('%FORCE_MASTER%', '%TABLE%', '%FOUND_ROWS%', '%DISTINCT%', '%FIELD%', '%JOIN%', '%WHERE%', '%GROUP%', '%HAVING%', '%ORDER%', '%LIMIT%', '%UNION%', '%LOCK%', '%COMMENT%', '%FORCE%'),
            array(
                $this->parseForceMaster(!empty($options['force_master'])),
                $this->parseTable($options['table']),
                $this->parseFoundRows(isset($options['found_rows']) ? $options['found_rows'] : false),
                $this->parseDistinct(isset($options['distinct']) ? $options['distinct'] : false),
                $this->parseField(!empty($options['field']) ? $options['field'] : '*'),
                $this->parseJoin(!empty($options['join']) ? $options['join'] : ''),
                $this->parseWhere(!empty($options['where']) ? $options['where'] : ''),
                $this->parseGroup(!empty($options['group']) ? $options['group'] : ''),
                $this->parseHaving(!empty($options['having']) ? $options['having'] : ''),
                $this->parseOrder(!empty($options['order']) ? $options['order'] : ''),
                $this->parseLimit(!empty($options['limit']) ? $options['limit'] : ''),
                $this->parseUnion(!empty($options['union']) ? $options['union'] : ''),
                $this->parseLock(isset($options['lock']) ? $options['lock'] : false),
                $this->parseComment(!empty($options['comment']) ? $options['comment'] : ''),
                $this->parseForce(!empty($options['force']) ? $options['force'] : '')
            ), $sql);
        return $sql;
    }

    protected function parseForceMaster($forceMaster)
    {
        return $forceMaster ? '/*FORCE_MASTER*/ ' : '';
    }

    /**
     * table分析
     * @access protected
     * @param mixed $table
     * @return string
     */
    protected function parseTable($tables)
    {
        if (is_array($tables)) {// 支持别名定义
            $array = array();
            foreach ($tables as $table => $alias) {
                if (!is_numeric($table))
                    $array[] = $this->parseKey($table) . ' ' . $this->parseKey($alias);
                else
                    $array[] = $this->parseKey($alias);
            }
            $tables = $array;
        } elseif (is_string($tables)) {
            $tables = explode(',', $tables);
            array_walk($tables, array(&$this, 'parseKey'));
        }
        return implode(',', $tables);
    }

    /**
     * found_rows分析
     * @access protected
     * @param mixed $foundRows
     * @return string
     */
    protected function parseFoundRows($foundRows)
    {
        return !empty($foundRows) ? ' SQL_CALC_FOUND_ROWS ' : '';
    }

    /**
     * distinct分析
     * @access protected
     * @param mixed $distinct
     * @return string
     */
    protected function parseDistinct($distinct)
    {
        return !empty($distinct) ? ' DISTINCT ' : '';
    }

    /**
     * field分析
     * @access protected
     * @param mixed $fields
     * @return string
     */
    protected function parseField($fields)
    {
        if (is_string($fields) && '' !== $fields) {
            $fields = explode(',', $fields);
        }
        if (is_array($fields)) {
            // 完善数组方式传字段名的支持
            // 支持 'field1'=>'field2' 这样的字段别名定义
            $array = array();
            foreach ($fields as $key => $field) {
                if (!is_numeric($key))
                    $array[] = $this->parseKey($key) . ' AS ' . $this->parseKey($field);
                else
                    $array[] = $this->parseKey($field);
            }
            $fieldsStr = implode(',', $array);
        } else {
            $fieldsStr = '*';
        }
        //TODO 如果是查询全部字段，并且是join的方式，那么就把要查的表加个别名，以免字段被覆盖
        return $fieldsStr;
    }

    /**
     * join分析
     * @access protected
     * @param mixed $join
     * @return string
     */
    protected function parseJoin($join)
    {
        $joinStr = '';
        if (!empty($join)) {
            $joinStr = ' ' . implode(' ', $join) . ' ';
        }
        return $joinStr;
    }

    /**
     * group分析
     * @access protected
     * @param mixed $group
     * @return string
     */
    protected function parseGroup($group)
    {
        return !empty($group) ? ' GROUP BY ' . $group : '';
    }

    /**
     * having分析
     * @access protected
     * @param string $having
     * @return string
     */
    protected function parseHaving($having)
    {
        return !empty($having) ? ' HAVING ' . $having : '';
    }

    /**
     * order分析
     * @access protected
     * @param mixed $order
     * @return string
     */
    protected function parseOrder($order)
    {
        if (is_array($order)) {
            $array = array();
            foreach ($order as $key => $val) {
                if (is_numeric($key)) {
                    $array[] = $this->parseKey($val);
                } else {
                    $array[] = $this->parseKey($key) . ' ' . $val;
                }
            }
            $order = implode(',', $array);
        }
        return !empty($order) ? ' ORDER BY ' . $order : '';
    }

    /**
     * limit 分析.
     */
    protected function parseLimit(int|string $limit): string
    {
        return !empty($limit) ? ' LIMIT ' . $limit . ' ' : '';
    }

    /**
     * 设置锁机制.
     */
    protected function parseLock(bool $lock = false): string
    {
        return $lock ? ' FOR UPDATE ' : '';
    }

    /**
     * comment 分析.
     */
    protected function parseComment(string $comment): string
    {
        return !empty($comment) ? '/*' . $comment . '*/' : '';
    }

    /**
     * index 分析，可在操作链中指定需要强制使用的索引.
     */
    protected function parseForce(mixed $index): string
    {
        if (empty($index)) {
            return '';
        }

        if (is_array($index)) {
            $index = join(",", $index);
        }

        return sprintf(" FORCE INDEX ( %s ) ", $index);
    }
}
