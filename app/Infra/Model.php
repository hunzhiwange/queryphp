<?php

declare(strict_types=1);

namespace App\Infra;

use Closure;
use Exception;
use Leevel\Cache\ICache;

/**
 * ThinkPHP Model 模型类兼容层
 *
 * - 基于 ThinkPHP 3.2.3 模型 \Think\Model 移植而来
 * - 实现了 ORM 和 ActiveRecords 模式
 */
abstract class Model
{
    // 操作状态
    const MODEL_INSERT = 1;      //  插入模型数据
    const MODEL_UPDATE = 2;      //  更新模型数据
    const MODEL_BOTH = 3;      //  包含上面两种方式
    const MUST_VALIDATE = 1;      // 必须验证
    const EXISTS_VALIDATE = 0;      // 表单存在字段则验证
    const VALUE_VALIDATE = 2;      // 表单值不为空则验证

    /**
     * Mysql 驱动兼容层.
     */
    protected Mysql $mysql;

    // 数据库对象池
    protected $pk = 'id';
    // 主键名称
    protected $autoinc = false;
    // 主键是否自动增长
    protected $tablePrefix = null;
    // 数据表前缀
    protected $name = '';
    // 模型名称
    protected $dbName = '';
    // 数据库名称
    protected $connection = '';
    //数据库配置
    protected $tableName = '';
    // 数据表名（不包含表前缀）
    protected $trueTableName = '';
    // 实际数据表名（包含表前缀）
    protected $error = '';
    // 最近错误信息
    protected $fields = array();
    // 字段信息
    protected $data = array();
    // 数据信息
    protected $options = array();
    // 查询表达式参数
    protected $_validate = array();
    protected $_auto = array();  // 自动验证定义
    protected $_map = array();  // 自动完成定义
    protected $_scope = array();  // 字段映射定义
    protected $autoCheckFields = true;  // 命名范围定义
    // 是否自动检测数据表字段信息
    protected $patchValidate = false;
    // 是否批处理验证
    /** 得到上一次分页查询的总条数
     * 2016-10-20 新增一个found_rows 用于查询分页和列表的数据 by 小牛
     * 在分页的前一句插入SQL_CALC_FOUND_ROWS;
     * Example: SELECT SQL_CALC_FOUND_ROWS id, time FROM table_name where conditions='**' LIMIT 0,50
     * refer: http://www.codesec.net/view/192841.html
     */
    protected $methods = array('strict', 'order', 'alias', 'having', 'group', 'lock', 'distinct', 'auto', 'filter', 'validate', 'result', 'token', 'index', 'force');

    /**
     * 架构函数
     * 取得DB类的实例对象 字段检查
     * @access public
     * @param string $name 模型名称
     * @param string $tablePrefix 表前缀
     * @param mixed $connection 数据库连接信息
     */
    public function __construct($name = '', $tablePrefix = '', $connection = '')
    {
        // 模型初始化
        $this->_initialize();
        // 获取模型名称
        if (!empty($name)) {
            if (strpos($name, '.')) { // 支持 数据库名.模型名的 定义
                list($this->dbName, $this->name) = explode('.', $name);
            } else {
                $this->name = $name;
            }
        } elseif (empty($this->name)) {
            $this->name = $this->getModelName();
        }
        // 设置表前缀
        if (is_null($tablePrefix)) {// 前缀为Null表示没有前缀
            $this->tablePrefix = '';
        } elseif ('' != $tablePrefix) {
            $this->tablePrefix = $tablePrefix;
        } elseif (!isset($this->tablePrefix)) {
            $this->tablePrefix = '';
        }

        // 数据库初始化操作
        // 获取数据库操作对象
        // 当前模型有独立的数据库连接信息
        $this->db(0, empty($this->connection) ? $connection : $this->connection, true);
    }

    protected function _initialize()
    {
    }

    /**
     * 得到当前的数据对象名称
     * @access public
     * @return string
     */
    public function getModelName()
    {
        if (empty($this->name)) {
            $name = substr(get_class($this), 0, -strlen('Model'));
            if ($pos = strrpos($name, '\\')) {//有命名空间
                $this->name = substr($name, $pos + 1);
            } else {
                $this->name = $name;
            }
        }
        return $this->name;
    }

    /**
     * 切换当前的数据库连接
     * @access public
     * @param integer $linkNum 连接序号
     * @param mixed $config 数据库连接信息
     * @param boolean $force 强制重新连接
     * @return Model
     */
    public function db($linkNum = '', $config = '', $force = false)
    {
        $entity = static::ENTITY;
        $entity = new $entity();
        $this->mysql = new Mysql($entity);
        $this->_checkTableInfo();
        return $this;
    }

    /**
     * 自动检测数据表信息
     * @access protected
     * @return void
     */
    protected function _checkTableInfo()
    {
        // 如果不是Model类 自动记录数据表信息
        // 只在第一次执行记录
        if (empty($this->fields)) {
            $this->flush();
        }
    }

    /**
     * 获取字段信息并缓存
     * @access public
     * @return void
     */
    public function flush()
    {
        // 缓存不存在则查询数据表信息
        $fields = $this->mysql->getFields($this->getTableName());
        if (!$fields) { // 无法获取字段信息
            return false;
        }
        $this->pk = $fields['primaryKey'];
        if (is_array($this->pk) && count($this->pk) === 1) {
            $this->pk = $this->pk[0];
        }
        $this->fields = $fields['fields'];
        $this->autoinc = !empty($fields['auto']);
    }

    /**
     * 得到完整的数据表名
     * @access public
     * @return string
     */
    public function getTableName()
    {
        if (empty($this->trueTableName)) {
            $tableName = !empty($this->tablePrefix) ? $this->tablePrefix : '';
            if (!empty($this->tableName)) {
                $tableName .= $this->tableName;
            } else {
                $tableName .= $this->parseName($this->name);
            }
            $this->trueTableName = strtolower($tableName);
        }
        return (!empty($this->dbName) ? $this->dbName . '.' : '') . $this->trueTableName;
    }

    /**
     * 创建一个对象.
     *
     * @param string $name
     * @param string $tablePrefix
     * @param string $connection
     * @return static
     */
    public static function make($name = '', $tablePrefix = '', $connection = '')
    {
        return new static($name, $tablePrefix, $connection);
    }

    /**
     * 获取数据对象的值
     * @access public
     * @param string $name 名称
     * @return mixed
     */
    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * 设置数据对象的值
     * @access public
     * @param string $name 名称
     * @param mixed $value 值
     * @return void
     */
    public function __set($name, $value)
    {
        // 设置数据对象属性
        $this->data[$name] = $value;
    }

    // 回调方法 初始化模型

    /**
     * 检测数据对象的值
     * @access public
     * @param string $name 名称
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * 销毁数据对象的值
     * @access public
     * @param string $name 名称
     * @return void
     */
    public function __unset($name)
    {
        unset($this->data[$name]);
    }

    // 写入数据前的回调方法 包括新增和更新

    /**
     * 利用__call方法实现一些特殊的Model方法
     * @access public
     * @param string $method 方法名称
     * @param array $args 调用参数
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (in_array(strtolower($method), $this->methods, true)) {
            // 连贯操作的实现
            $this->options[strtolower($method)] = $args[0];
            return $this;
        } elseif (in_array(strtolower($method), array('count', 'sum', 'min', 'max', 'avg'), true)) {
            // 统计查询的实现
            $field = isset($args[0]) ? $args[0] : '*';
            return $this->getField(strtoupper($method) . '(' . $field . ') AS tp_' . $method);
        } elseif (strtolower(substr($method, 0, 5)) == 'getby') {
            // 根据某个字段获取记录
            $field = $this->parseName(substr($method, 5));
            $where[$field] = $args[0];
            return $this->where($where)->find();
        } elseif (strtolower(substr($method, 0, 10)) == 'getfieldby') {
            // 根据某个字段获取记录的某个值
            $name = $this->parseName(substr($method, 10));
            $where[$name] = $args[0];
            return $this->where($where)->getField($args[1]);
        } elseif (isset($this->_scope[$method])) {// 命名范围的单独调用支持
            return $this->scope($method, $args[0]);
        } else {
            throw new Exception(__CLASS__ . ':' . $method . '_METHOD_NOT_EXIST_');
        }
    }

    /**
     * 获取一条记录的某个字段值
     * @access public
     * @param string $field 字段名
     * @param string $spea 字段数据间隔符号 NULL返回数组
     * @return mixed
     */
    public function getField($field, $sepa = null)
    {
        $options['field'] = $field;
        $options = $this->_parseOptions($options);
        // 判断查询缓存
        if (isset($options['cache'])) {
            $cache = $options['cache'];
            $key = is_string($cache['key']) ? $cache['key'] : md5($sepa . serialize($options));
            $data = S($key, '', $cache);
            if (false !== $data) {
                return $data;
            }
        }
        $field = trim($field);
        if (strpos($field, ',') && false !== $sepa) { // 多字段
            if (!isset($options['limit'])) {
                $options['limit'] = is_numeric($sepa) ? $sepa : '';
            }
            $resultSet = $this->mysql->select($options);
            if (!empty($resultSet)) {
                $_field = explode(',', $field);
                $field = array_keys($resultSet[0]);
                $key1 = array_shift($field);
                $key2 = array_shift($field);
                $cols = array();
                $count = count($_field);
                foreach ($resultSet as $result) {
                    $name = $result[$key1];
                    if (2 == $count) {
                        $cols[$name] = $result[$key2];
                    } else {
                        $cols[$name] = is_string($sepa) ? implode($sepa, array_slice($result, 1)) : $result;
                    }
                }
                if (isset($cache)) {
                    S($key, $cols, $cache);
                }
                return $cols;
            }
        } else {   // 查找一条记录
            // 返回数据个数
            if (true !== $sepa) {// 当sepa指定为true的时候 返回所有数据
                $options['limit'] = is_numeric($sepa) ? $sepa : 1;
            }
            $result = $this->mysql->select($options);
            if (!empty($result)) {
                if (true !== $sepa && 1 == $options['limit']) {
                    $data = reset($result[0]);
                    if (isset($cache)) {
                        S($key, $data, $cache);
                    }
                    return $data;
                }
                foreach ($result as $val) {
                    $array[] = $val[$field];
                }
                if (isset($cache)) {
                    S($key, $array, $cache);
                }
                return $array;
            }
        }
        return null;
    }

    // 插入数据前的回调方法

    /**
     * 分析表达式
     * @access protected
     * @param array $options 表达式参数
     * @return array
     */
    protected function _parseOptions($options = array())
    {
        if (is_array($options))
            $options = array_merge($this->options, $options);

        if (!isset($options['table'])) {
            // 自动获取表名
            $options['table'] = $this->getTableName();
            $fields = $this->fields;
        } else {
            // 指定数据表 则重新获取字段列表 但不支持类型检测
            $fields = $this->getDbFields();
        }

        // 数据表别名
        if (!empty($options['alias'])) {
            $options['table'] .= ' ' . $options['alias'];
        }
        // 记录操作的模型名称
        $options['model'] = $this->name;

        // 字段类型验证
        if (isset($options['where']) && is_array($options['where']) && !empty($fields) && !isset($options['join'])) {
            // 对数组查询条件进行字段类型检查
            foreach ($options['where'] as $key => $val) {
                $key = trim($key);
                if (in_array($key, $fields, true)) {
                    if (is_scalar($val)) {
                        $this->_parseType($options['where'], $key);
                    }
                } elseif (!is_numeric($key) && '_' != substr($key, 0, 1) && false === strpos($key, '.') && false === strpos($key, '(') && false === strpos($key, '|') && false === strpos($key, '&')) {
                    if (!empty($this->options['strict'])) {
                        throw new Exception(sprintf('Error query express:[%s=>%s]', $key, $val));
                    }
                    unset($options['where'][$key]);
                }
            }
        }
        // 查询过后清空sql表达式组装 避免影响下次查询
        $this->options = array();
        // 表达式过滤
        $this->_options_filter($options);
        return $options;
    }

    // 插入成功后的回调方法

    /**
     * 获取数据表字段信息
     * @access public
     * @return array
     */
    public function getDbFields()
    {
        if (isset($this->options['table'])) {// 动态指定表名
            if (is_array($this->options['table'])) {
                $table = key($this->options['table']);
            } else {
                $table = $this->options['table'];
                if (strpos($table, ')')) {
                    // 子查询
                    return false;
                }
            }
            $fields = $this->mysql->getFields($table);
            return $fields ? array_keys($fields) : false;
        }
        if ($this->fields) {
            $fields = $this->fields;
            return $fields;
        }
        return false;
    }

    /**
     * 数据类型检测
     * @access protected
     * @param mixed $data 数据
     * @param string $key 字段名
     * @return void
     */
    protected function _parseType(&$data, $key)
    {
        if (!isset($this->options['bind'][':' . $key]) && isset($this->fields['_type'][$key])) {
            $fieldType = strtolower($this->fields['_type'][$key]);
            if (false !== strpos($fieldType, 'enum')) {
                // 支持ENUM类型优先检测
            } elseif (false === strpos($fieldType, 'bigint') && false !== strpos($fieldType, 'int')) {
                $data[$key] = intval($data[$key]);
            } elseif (false !== strpos($fieldType, 'float') || false !== strpos($fieldType, 'double')) {
                $data[$key] = floatval($data[$key]);
            } elseif (false !== strpos($fieldType, 'bool')) {
                $data[$key] = (bool)$data[$key];
            }
        }
    }

    protected function _options_filter(&$options)
    {
    }

    /**
     * 查询数据
     * @access public
     * @param mixed $options 表达式参数
     * @return mixed
     */
    public function find($options = array())
    {
        if (is_numeric($options) || is_string($options)) {
            $where[$this->getPk()] = $options;
            $options = array();
            $options['where'] = $where;
        }
        // 根据复合主键查找记录
        $pk = $this->getPk();
        if (is_array($options) && (count($options) > 0) && is_array($pk)) {
            // 根据复合主键查询
            $count = 0;
            foreach (array_keys($options) as $key) {
                if (is_int($key)) $count++;
            }
            if ($count == count($pk)) {
                $i = 0;
                foreach ($pk as $field) {
                    $where[$field] = $options[$i];
                    unset($options[$i++]);
                }
                $options['where'] = $where;
            } else {
                return false;
            }
        }
        // 总是查找一条记录
        $options['limit'] = 1;
        // 分析表达式
        $options = $this->_parseOptions($options);
        // 判断查询缓存
        if (isset($options['cache'])) {
            $cache = $options['cache'];
            $key = is_string($cache['key']) ? $cache['key'] : 'sql:' . md5(serialize($options));
            $options['cache']['key'] = $key;
        }
        $resultSet = $this->mysql->select($options);
        if (false === $resultSet) {
            return false;
        }
        if (empty($resultSet)) {// 查询结果为空
            return null;
        }
        if (is_string($resultSet)) {
            return $resultSet;
        }

        // 读取数据后的处理
        $data = $this->_read_data($resultSet[0]);
        $this->_after_find($data, $options);
        if (!empty($this->options['result'])) {
            return $this->returnResult($data, $this->options['result']);
        }
        $this->data = $data;

        return $this->data;
    }

    // 更新数据前的回调方法

    /**
     * 获取主键名称
     * @access public
     * @return string
     */
    public function getPk()
    {
        return $this->pk;
    }

    // 更新成功后的回调方法

    /**
     * 数据读取后的处理
     * @access protected
     * @param array $data 当前数据
     * @return array
     */
    protected function _read_data($data)
    {
        // 检查字段映射
        if (!empty($this->_map) && C('READ_DATA_MAP')) {
            foreach ($this->_map as $key => $val) {
                if (isset($data[$val])) {
                    $data[$key] = $data[$val];
                    unset($data[$val]);
                }
            }
        }
        return $data;
    }

    protected function _after_find(&$result, $options)
    {
    }

    // 删除数据前的回调方法

    protected function returnResult($data, $type = '')
    {
        if ($type) {
            if (is_callable($type)) {
                return call_user_func($type, $data);
            }
            switch (strtolower($type)) {
                case 'json':
                    return json_encode($data);
                case 'xml':
                    return xml_encode($data);
            }
        }
        return $data;
    }

    // 删除成功后的回调方法

    /**
     * 指定查询条件 支持安全过滤
     * @access public
     * @param mixed $where 条件表达式
     * @param mixed $parse 预处理参数
     * @return Model
     */
    public function where($where, $parse = null)
    {
        if (!is_null($parse) && is_string($where)) {
            if (!is_array($parse)) {
                $parse = func_get_args();
                array_shift($parse);
            }
            $parse = array_map(array($this->mysql, 'escapeString'), $parse);
            $where = vsprintf($where, $parse);
        } elseif (is_object($where)) {
            $where = get_object_vars($where);
        }
        if (is_string($where) && '' != $where) {
            $map = array();
            $map['_string'] = $where;
            $where = $map;
        }
        if (isset($this->options['where'])) {
            $this->options['where'] = array_merge($this->options['where'], $where);
        } else {
            $this->options['where'] = $where;
        }

        return $this;
    }

    /**
     * 调用命名范围
     * @access public
     * @param mixed $scope 命名范围名称 支持多个 和直接定义
     * @param array $args 参数
     * @return Model
     */
    public function scope($scope = '', $args = NULL)
    {
        if ('' === $scope) {
            if (isset($this->_scope['default'])) {
                // 默认的命名范围
                $options = $this->_scope['default'];
            } else {
                return $this;
            }
        } elseif (is_string($scope)) { // 支持多个命名范围调用 用逗号分割
            $scopes = explode(',', $scope);
            $options = array();
            foreach ($scopes as $name) {
                if (!isset($this->_scope[$name])) continue;
                $options = array_merge($options, $this->_scope[$name]);
            }
            if (!empty($args) && is_array($args)) {
                $options = array_merge($options, $args);
            }
        } elseif (is_array($scope)) { // 直接传入命名范围定义
            $options = $scope;
        }

        if (is_array($options) && !empty($options)) {
            $this->options = array_merge($this->options, array_change_key_case($options));
        }
        return $this;
    }

    // 查询成功后的回调方法

    /**
     * 得到上一次分页查询的总条数
     * 在分页的前一句插入SQL_CALC_FOUND_ROWS;
     * Example: SELECT SQL_CALC_FOUND_ROWS id, time FROM table_name where conditions='**' LIMIT 0,50
     * refer: http://www.codesec.net/view/192841.html
     *
     * @return int 总条数
     * @author yangfan
     * @since 2016-01-07
     */
    public function fetchTotalCount()
    {
        return $this->mysql->getTotalCount();
    }

    /**
     * 新增数据
     * @access public
     * @param mixed $data 数据
     * @param array $options 表达式
     * @param boolean $replace 是否replace
     * @return mixed
     */
    public function add($data = '', $options = array(), $replace = false)
    {
        if (empty($data)) {
            // 没有传递数据，获取当前数据对象的值
            if (!empty($this->data)) {
                $data = $this->data;
                // 重置数据
                $this->data = array();
            } else {
                $this->error = '_DATA_TYPE_INVALID_';
                return false;
            }
        }
        // 数据处理
        $data = $this->_facade($data);
        // 分析表达式
        $options = $this->_parseOptions($options);
        if (false === $this->_before_insert($data, $options)) {
            return false;
        }
        // 写入数据到数据库
        $result = $this->mysql->insert($data, $options, $replace);
        if (false !== $result && is_numeric($result)) {
            $pk = $this->getPk();
            // 增加复合主键支持
            if (is_array($pk)) return $result;
            $insertId = $this->getLastInsID();
            if ($insertId) {
                // 自增主键返回插入ID
                $data[$pk] = $insertId;
                if (false === $this->_after_insert($data, $options)) {
                    return false;
                }
                return $insertId;
            }
            if (false === $this->_after_insert($data, $options)) {
                return false;
            }
        }
        return $result;
    }

    /**
     * 对保存到数据库的数据进行处理
     * @access protected
     * @param mixed $data 要操作的数据
     * @return boolean
     */
    protected function _facade($data)
    {
        // 检查数据字段合法性
        if (!empty($this->fields)) {
            if (!empty($this->options['field'])) {
                $fields = $this->options['field'];
                unset($this->options['field']);
                if (is_string($fields)) {
                    $fields = explode(',', $fields);
                }
            } else {
                $fields = $this->fields;
            }
            foreach ($data as $key => $val) {
                if (!in_array($key, $fields, true)) {
                    if (!empty($this->options['strict'])) {
                        E(L('_DATA_TYPE_INVALID_') . ':[' . $key . '=>' . $val . ']');
                    }
                    unset($data[$key]);
                } elseif (is_scalar($val)) {
                    // 字段类型检查 和 强制转换
                    $this->_parseType($data, $key);
                }
            }
        }

        // 安全过滤
        if (!empty($this->options['filter'])) {
            $data = array_map($this->options['filter'], $data);
            unset($this->options['filter']);
        }
        $this->_before_write($data);
        return $data;
    }

    // 表达式过滤回调方法

    protected function _before_write(&$data)
    {
    }

    protected function _before_insert(&$data, $options)
    {
    }

    /**
     * 返回最后插入的ID
     * @access public
     * @return string
     */
    public function getLastInsID()
    {
        return $this->mysql->getLastInsID();
    }

    protected function _after_insert($data, $options)
    {
    }

    // 查询成功的回调方法

    public function addAll($dataList, $options = array(), $replace = false)
    {
        if (empty($dataList)) {
            $this->error = L('_DATA_TYPE_INVALID_');
            return false;
        }
        // 数据处理
        foreach ($dataList as $key => $data) {
            $dataList[$key] = $this->_facade($data);
        }
        // 分析表达式
        $options = $this->_parseOptions($options);
        // 写入数据到数据库
        $result = $this->mysql->insertAll($dataList, $options, $replace);
        if (false !== $result) {
            $insertId = $this->getLastInsID();
            if ($insertId) {
                return $insertId;
            }
        }
        return $result;
    }

    /**
     * 通过Select方式添加记录
     * @access public
     * @param string $fields 要插入的数据表字段名
     * @param string $table 要插入的数据表名
     * @param array $options 表达式
     * @return boolean
     */
    public function selectAdd($fields = '', $table = '', $options = array())
    {
        // 分析表达式
        $options = $this->_parseOptions($options);
        // 写入数据到数据库
        if (false === $result = $this->mysql->selectInsert($fields ?: $options['field'], $table ?: $this->getTableName(), $options)) {
            // 数据库插入操作失败
            $this->error = L('_OPERATION_WRONG_');
            return false;
        } else {
            // 插入成功
            return $result;
        }
    }

    /**
     * 删除数据
     * @access public
     * @param mixed $options 表达式
     * @return mixed
     */
    public function delete($options = array())
    {
        $pk = $this->getPk();
        if (empty($options) && empty($this->options['where'])) {
            // 如果删除条件为空 则删除当前数据对象所对应的记录
            if (!empty($this->data) && isset($this->data[$pk]))
                return $this->delete($this->data[$pk]);
            else
                return false;
        }
        if (is_numeric($options) || is_string($options)) {
            // 根据主键删除记录
            if (is_string($options) && strpos($options, ',')) {
                $where[$pk] = array('IN', $options);
            } else {
                $where[$pk] = $options;
            }
            $options = array();
            $options['where'] = $where;
        }
        // 根据复合主键删除记录
        if (is_array($options) && (count($options) > 0) && is_array($pk)) {
            $count = 0;
            foreach (array_keys($options) as $key) {
                if (is_int($key)) $count++;
            }
            if ($count == count($pk)) {
                $i = 0;
                foreach ($pk as $field) {
                    $where[$field] = $options[$i];
                    unset($options[$i++]);
                }
                $options['where'] = $where;
            } else {
                return false;
            }
        }
        // 分析表达式
        $options = $this->_parseOptions($options);
        if (empty($options['where'])) {
            // 如果条件为空 不进行删除操作 除非设置 1=1
            return false;
        }
        if (is_array($options['where']) && isset($options['where'][$pk])) {
            $pkValue = $options['where'][$pk];
        }

        if (false === $this->_before_delete($options)) {
            return false;
        }
        $result = $this->mysql->delete($options);
        if (false !== $result && is_numeric($result)) {
            $data = array();
            if (isset($pkValue)) $data[$pk] = $pkValue;
            $this->_after_delete($data, $options);
        }
        // 返回删除记录个数
        return $result;
    }

    protected function _before_delete($options)
    {
    }

    protected function _after_delete($data, $options)
    {
    }

    /**
     * 查询数据集
     * @access public
     * @param array $options 表达式参数
     * @return mixed
     */
    public function select($options = array())
    {
        $pk = $this->getPk();
        if (is_string($options) || is_numeric($options)) {
            // 根据主键查询
            if (strpos($options, ',')) {
                $where[$pk] = array('IN', $options);
            } else {
                $where[$pk] = $options;
            }
            $options = array();
            $options['where'] = $where;
        } elseif (is_array($options) && (count($options) > 0) && is_array($pk)) {
            // 根据复合主键查询
            $count = 0;
            foreach (array_keys($options) as $key) {
                if (is_int($key)) $count++;
            }
            if ($count == count($pk)) {
                $i = 0;
                foreach ($pk as $field) {
                    $where[$field] = $options[$i];
                    unset($options[$i++]);
                }
                $options['where'] = $where;
            } else {
                return false;
            }
        } elseif (false === $options) { // 用于子查询 不查询只返回SQL
            return $this->buildSql();
        }

        // 分析表达式
        $options = $this->_parseOptions($options);
        // 判断查询缓存
        if (isset($options['cache'])) {
            $cache = $options['cache'];
            $key = is_string($cache['key']) ? $cache['key'] : md5(serialize($options));
            $data = S($key, '', $cache);
            if (false !== $data) {
                return $data;
            }
        }

        $resultSet = $this->mysql->select($options);
        if (false === $resultSet) {
            return false;
        }
        if (empty($resultSet)) { // 查询结果为空
            return null;
        }

        if (is_string($resultSet)) {
            return $resultSet;
        }

        $resultSet = array_map(array($this, '_read_data'), $resultSet);
        $this->_after_select($resultSet, $options);
        if (isset($options['index'])) { // 对数据集进行索引
            $index = explode(',', $options['index']);
            foreach ($resultSet as $result) {
                $_key = $result[$index[0]];
                if (isset($index[1]) && isset($result[$index[1]])) {
                    $cols[$_key] = $result[$index[1]];
                } else {
                    $cols[$_key] = $result;
                }
            }
            $resultSet = $cols;
        }
        if (isset($cache)) {
            S($key, $resultSet, $cache);
        }
        return $resultSet;
    }

    /**
     * 生成查询SQL 可用于子查询
     * @access public
     * @return string
     */
    public function buildSql()
    {
        return '( ' . $this->fetchSql(true)->select() . ' )';
    }

    /**
     * 获取执行的SQL语句
     * @access public
     * @param boolean $fetch 是否返回sql
     * @return Model
     */
    public function fetchSql($fetch)
    {
        $this->options['fetch_sql'] = $fetch;
        return $this;
    }

    protected function _after_select(&$resultSet, $options)
    {
    }

    /**
     * 处理字段映射
     * @access public
     * @param array $data 当前数据
     * @param integer $type 类型 0 写入 1 读取
     * @return array
     */
    public function parseFieldsMap($data, $type = 1)
    {
        // 检查字段映射
        if (!empty($this->_map)) {
            foreach ($this->_map as $key => $val) {
                if ($type == 1) { // 读取
                    if (isset($data[$val])) {
                        $data[$key] = $data[$val];
                        unset($data[$val]);
                    }
                } else {
                    if (isset($data[$key])) {
                        $data[$val] = $data[$key];
                        unset($data[$key]);
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 字段值增长
     * @access public
     * @param string $field 字段名
     * @param integer $step 增长值
     * @return boolean
     */
    public function setInc($field, $step = 1)
    {
        return $this->setField($field, array('exp', $field . '+' . $step));
    }

    /**
     * 设置记录的某个字段值
     * 支持使用数据库字段和方法
     * @access public
     * @param string|array $field 字段名
     * @param string $value 字段值
     * @return boolean
     */
    public function setField($field, $value = '')
    {
        if (is_array($field)) {
            $data = $field;
        } else {
            $data[$field] = $value;
        }
        return $this->save($data);
    }

    /**
     * 保存数据
     * @access public
     * @param mixed $data 数据
     * @param array $options 表达式
     * @return boolean
     */
    public function save($data = '', $options = array())
    {
        if (empty($data)) {
            // 没有传递数据，获取当前数据对象的值
            if (!empty($this->data)) {
                $data = $this->data;
                // 重置数据
                $this->data = array();
            } else {
                $this->error = '_DATA_TYPE_INVALID_';
                return false;
            }
        }
        // 数据处理
        $data = $this->_facade($data);
        if (empty($data)) {
            // 没有数据则不执行
            $this->error = '_DATA_TYPE_INVALID_';
            return false;
        }
        // 分析表达式
        $options = $this->_parseOptions($options);
        $pk = $this->getPk();
        if (!isset($options['where'])) {
            // 如果存在主键数据 则自动作为更新条件
            if (is_string($pk) && isset($data[$pk])) {
                $where[$pk] = $data[$pk];
                unset($data[$pk]);
            } elseif (is_array($pk)) {
                // 增加复合主键支持
                foreach ($pk as $field) {
                    if (isset($data[$field])) {
                        $where[$field] = $data[$field];
                    } else {
                        // 如果缺少复合主键数据则不执行
                        $this->error = L('_OPERATION_WRONG_');
                        return false;
                    }
                    unset($data[$field]);
                }
            }
            if (!isset($where)) {
                // 如果没有任何更新条件则不执行
                $this->error = '_OPERATION_WRONG_';
                return false;
            } else {
                $options['where'] = $where;
            }
        }

        if (is_array($options['where']) && isset($options['where'][$pk])) {
            $pkValue = $options['where'][$pk];
        }
        if (false === $this->_before_update($data, $options)) {
            return false;
        }
        $result = $this->mysql->update($data, $options);
        if (false !== $result && is_numeric($result)) {
            if (isset($pkValue)) $data[$pk] = $pkValue;
            $this->_after_update($data, $options);
        }
        return $result;
    }

    protected function _before_update(&$data, $options)
    {
    }

    protected function _after_update($data, $options)
    {
    }

    /**
     * 字段值减少
     * @access public
     * @param string $field 字段名
     * @param integer $step 减少值
     * @return boolean
     */
    public function setDec($field, $step = 1)
    {
        return $this->setField($field, array('exp', $field . '-' . $step));
    }

    /**
     * 创建数据对象 但不保存到数据库
     * @access public
     * @param mixed $data 创建数据
     * @param string $type 状态
     * @return mixed
     */
    public function create($data = '', $type = '')
    {
        // 如果没有传值默认取POST数据
        if (empty($data)) {
            $data = http_request()->request->all();
        } elseif (is_object($data)) {
            $data = get_object_vars($data);
        }
        // 验证数据
        if (empty($data) || !is_array($data)) {
            $this->error = '_DATA_TYPE_INVALID_';
            return false;
        }

        // 状态
        $type = $type ?: (!empty($data[$this->getPk()]) ? self::MODEL_UPDATE : self::MODEL_INSERT);

        // 检查字段映射
        if (!empty($this->_map)) {
            foreach ($this->_map as $key => $val) {
                if (isset($data[$key])) {
                    $data[$val] = $data[$key];
                    unset($data[$key]);
                }
            }
        }

        // 检测提交字段的合法性
        if (isset($this->options['field'])) { // $this->field('field1,field2...')->create()
            $fields = $this->options['field'];
            unset($this->options['field']);
        }
        if (isset($fields)) {
            if (is_string($fields)) {
                $fields = explode(',', $fields);
            }
            foreach ($data as $key => $val) {
                if (!in_array($key, $fields)) {
                    unset($data[$key]);
                }
            }
        }

        // 数据自动验证
        if (!$this->autoValidation($data, $type)) return false;

        // 验证完成生成数据对象
        if ($this->autoCheckFields) { // 开启字段检测 则过滤非法字段数据
            $fields = $this->getDbFields();
            foreach ($data as $key => $val) {
                if (!in_array($key, $fields)) {
                    unset($data[$key]);
                }
            }
        }

        // 创建完成对数据进行自动处理
        $this->autoOperation($data, $type);
        // 赋值当前数据对象
        $this->data = $data;
        // 返回创建的数据以供其他调用
        return $data;
    }

    /**
     * 自动表单验证
     * @access protected
     * @param array $data 创建数据
     * @param string $type 创建类型
     * @return boolean
     */
    protected function autoValidation($data, $type)
    {
        if (!empty($this->options['validate'])) {
            $_validate = $this->options['validate'];
            unset($this->options['validate']);
        } elseif (!empty($this->_validate)) {
            $_validate = $this->_validate;
        }
        // 属性验证
        if (isset($_validate)) { // 如果设置了数据自动验证则进行数据验证
            if ($this->patchValidate) { // 重置验证错误信息
                $this->error = array();
            }
            foreach ($_validate as $key => $val) {
                // 验证因子定义格式
                // array(field,rule,message,condition,type,when,params)
                // 判断是否需要执行验证
                if (empty($val[5]) || ($val[5] == self::MODEL_BOTH && $type < 3) || $val[5] == $type) {
                    if (0 == strpos($val[2], '{%') && strpos($val[2], '}'))
                        // 支持提示信息的多语言 使用 {%语言定义} 方式
                        $val[2] = L(substr($val[2], 2, -1));

                    // 2016.07.06 加上验证信息支持变量
                    if (strpos($val[2], '[i]') !== false && strpos($val[2], '[/i]') !== false)
                        // 支持提示信息的多语言 使用 {&I变量} 方式
                        $val[2] = preg_replace("/\[i\]\s*(\S+?)\s*\[\/i\]/ise", 'I(\'$1\')', $val[2]);

                    $val[3] = isset($val[3]) ? $val[3] : self::EXISTS_VALIDATE;
                    $val[4] = isset($val[4]) ? $val[4] : 'regex';
                    // 判断验证条件
                    switch ($val[3]) {
                        case self::MUST_VALIDATE:   // 必须验证 不管表单是否有设置该字段
                            if (false === $this->_validationField($data, $val))
                                return false;
                            break;
                        case self::VALUE_VALIDATE:    // 值不为空的时候才验证
                            if (isset($data[$val[0]]) && '' != trim($data[$val[0]]))
                                if (false === $this->_validationField($data, $val))
                                    return false;
                            break;
                        default:    // 默认表单存在该字段就验证
                            if (isset($data[$val[0]]))
                                if (false === $this->_validationField($data, $val))
                                    return false;
                    }
                }
            }
            // 批量验证的时候最后返回错误
            if (!empty($this->error)) return false;
        }
        return true;
    }

    // 数据库切换后回调方法

    /**
     * 验证表单字段 支持批量验证
     * 如果批量验证返回错误的数组信息
     * @access protected
     * @param array $data 创建数据
     * @param array $val 验证因子
     * @return boolean
     */
    protected function _validationField($data, $val)
    {
        if ($this->patchValidate && isset($this->error[$val[0]]))
            return; //当前字段已经有规则验证没有通过
        if (false === $this->_validationFieldItem($data, $val)) {
            if ($this->patchValidate) {
                $this->error[$val[0]] = $val[2];
            } else {
                $this->error = $val[2];
                return false;
            }
        }
        return;
    }

    /**
     * 根据验证因子验证字段
     * @access protected
     * @param array $data 创建数据
     * @param array $val 验证因子
     * @return boolean
     */
    protected function _validationFieldItem($data, $val)
    {
        switch (strtolower(trim($val[4]))) {
            case 'function':// 使用函数进行验证
            case 'callback':// 调用方法进行验证
                $args = isset($val[6]) ? (array)$val[6] : array();
                if (is_string($val[0]) && strpos($val[0], ','))
                    $val[0] = explode(',', $val[0]);
                if (is_array($val[0])) {
                    // 支持多个字段验证
                    foreach ($val[0] as $field)
                        $_data[$field] = $data[$field];
                    array_unshift($args, $_data);
                } else {
                    array_unshift($args, $data[$val[0]]);
                }
                if ('function' == $val[4]) {
                    return call_user_func_array($val[1], $args);
                } else {
                    return call_user_func_array(array(&$this, $val[1]), $args);
                }
            case 'confirm': // 验证两个字段是否相同
                return $data[$val[0]] == $data[$val[1]];
            case 'unique': // 验证某个值是否唯一
                if (is_string($val[0]) && strpos($val[0], ','))
                    $val[0] = explode(',', $val[0]);
                $map = array();
                if (is_array($val[0])) {
                    // 支持多个字段验证
                    foreach ($val[0] as $field)
                        $map[$field] = $data[$field];
                } else {
                    $map[$val[0]] = $data[$val[0]];
                }
                $pk = $this->getPk();
                if (!empty($data[$pk]) && is_string($pk)) { // 完善编辑的时候验证唯一
                    $map[$pk] = array('neq', $data[$pk]);
                }
                if ($this->where($map)->find()) return false;
                return true;
            default:  // 检查附加规则
                return $this->check($data[$val[0]], $val[1], $val[4]);
        }
    }

    /**
     * 验证数据 支持 in between equal length regex expire ip_allow ip_deny
     * @access public
     * @param string $value 验证数据
     * @param mixed $rule 验证表达式
     * @param string $type 验证方式 默认为正则验证
     * @return boolean
     */
    public function check($value, $rule, $type = 'regex')
    {
        $type = strtolower(trim($type));
        switch ($type) {
            case 'in': // 验证是否在某个指定范围之内 逗号分隔字符串或者数组
            case 'notin':
                $range = is_array($rule) ? $rule : explode(',', $rule);
                return $type == 'in' ? in_array($value, $range) : !in_array($value, $range);
            case 'between': // 验证是否在某个范围
            case 'notbetween': // 验证是否不在某个范围
                if (is_array($rule)) {
                    $min = $rule[0];
                    $max = $rule[1];
                } else {
                    list($min, $max) = explode(',', $rule);
                }
                return $type == 'between' ? $value >= $min && $value <= $max : $value < $min || $value > $max;
            case 'equal': // 验证是否等于某个值
            case 'notequal': // 验证是否等于某个值
                return $type == 'equal' ? $value == $rule : $value != $rule;
            case 'length': // 验证长度
                $length = mb_strlen($value, 'utf-8'); // 当前数据长度
                if (strpos($rule, ',')) { // 长度区间
                    list($min, $max) = explode(',', $rule);
                    return $length >= $min && $length <= $max;
                } else {// 指定长度
                    return $length == $rule;
                }
            case 'expire':
                list($start, $end) = explode(',', $rule);
                if (!is_numeric($start)) $start = strtotime($start);
                if (!is_numeric($end)) $end = strtotime($end);
                return NOW_TIME >= $start && NOW_TIME <= $end;
            case 'ip_allow': // IP 操作许可验证
                return in_array(get_client_ip(), explode(',', $rule));
            case 'ip_deny': // IP 操作禁止验证
                return !in_array(get_client_ip(), explode(',', $rule));
            case 'regex':
            default:    // 默认使用正则验证 可以使用验证类中定义的验证名称
                // 检查附加规则
                return $this->regex($value, $rule);
        }
    }

    /**
     * 使用正则验证数据
     * @access public
     * @param string $value 要验证的数据
     * @param string $rule 验证规则
     * @return boolean
     */
    public function regex($value, $rule)
    {
        $validate = array(
            'require' => '/\S+/',
            'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url' => '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
            'currency' => '/^\d+(\.\d+)?$/',
            'number' => '/^\d+$/',
            'zip' => '/^\d{6}$/',
            'integer' => '/^[-\+]?\d+$/',
            'double' => '/^[-\+]?\d+(\.\d+)?$/',
            'english' => '/^[A-Za-z]+$/',
        );
        // 检查是否有内置的正则表达式
        if (isset($validate[strtolower($rule)])) {
            $rule = $validate[strtolower($rule)];
        }

        return preg_match($rule, $value) === 1;
    }

    /**
     * 自动表单处理
     * @access public
     * @param array $data 创建数据
     * @param string $type 创建类型
     * @return mixed
     */
    private function autoOperation(&$data, $type)
    {
        if (!empty($this->options['auto'])) {
            $_auto = $this->options['auto'];
            unset($this->options['auto']);
        } elseif (!empty($this->_auto)) {
            $_auto = $this->_auto;
        }
        // 自动填充
        if (isset($_auto)) {
            foreach ($_auto as $auto) {
                // 填充因子定义格式
                // array('field','填充内容','填充条件','附加规则',[额外参数])
                if (empty($auto[2])) $auto[2] = self::MODEL_INSERT; // 默认为新增的时候自动填充
                if ($type == $auto[2] || $auto[2] == self::MODEL_BOTH) {
                    if (empty($auto[3])) $auto[3] = 'string';
                    switch (trim($auto[3])) {
                        case 'function':    //  使用函数进行填充 字段的值作为参数
                        case 'callback': // 使用回调方法
                            $args = isset($auto[4]) ? (array)$auto[4] : array();
                            if (isset($data[$auto[0]])) {
                                array_unshift($args, $data[$auto[0]]);
                            }
                            if ('function' == $auto[3]) {
                                $data[$auto[0]] = call_user_func_array($auto[1], $args);
                            } else {
                                $data[$auto[0]] = call_user_func_array(array(&$this, $auto[1]), $args);
                            }
                            break;
                        case 'field':    // 用其它字段的值进行填充
                            $data[$auto[0]] = $data[$auto[1]];
                            break;
                        case 'ignore': // 为空忽略
                            if ($auto[1] === $data[$auto[0]])
                                unset($data[$auto[0]]);
                            break;
                        case 'string':
                        default: // 默认作为字符串填充
                            $data[$auto[0]] = $auto[1];
                    }
                    if (isset($data[$auto[0]]) && false === $data[$auto[0]]) unset($data[$auto[0]]);
                }
            }
        }
        return $data;
    }

    /**
     * SQL 查询.
     */
    public function query(string $sql, bool|array|string $parse = false)
    {
        if (!is_bool($parse) && !is_array($parse)) {
            $parse = func_get_args();
            array_shift($parse);
        }
        $sql = $this->parseSql($sql, $parse);
        return $this->mysql->query($sql);
    }

    /**
     * 解析 SQL 语句.
     */
    protected function parseSql(string $sql, bool|array|string $parse): string
    {
        // 分析表达式
        if (true === $parse) {
            $options = $this->_parseOptions();
            $sql = $this->mysql->parseSql($sql, $options);
        } elseif (is_array($parse)) { // SQL预处理
            $parse = array_map(array($this->mysql, 'escapeString'), $parse);
            $sql = vsprintf($sql, $parse);
        }
        return $sql;
    }

    /**
     * 执行 SQL 语句.
     */
    public function execute($sql, $parse = false): int|false
    {
        if (!is_bool($parse) && !is_array($parse)) {
            $parse = func_get_args();
            array_shift($parse);
        }
        $sql = $this->parseSql($sql, $parse);
        return $this->mysql->execute($sql);
    }

    /**
     * 启动事务.
     */
    public function startTrans(): void
    {
        $this->mysql->startTrans();
    }

    /**
     * 提交事务.
     */
    public function commit(): void
    {
        $this->mysql->commit();
    }

    /**
     * 事务回滚.
     */
    public function rollback(): void
    {
        $this->mysql->rollback();
    }

    /**
     * 事务处理
     *
     * - 大多数框架都封装这种用法，简化调用
     */
    public function transaction(Closure $businessLogic): mixed
    {
        return $this->mysql->transaction($businessLogic);
    }

    /**
     * 返回模型的错误信息.
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * 异常抛出来.
     */
    public function throw(string $exception = Exception::class, int $code = 0): void
    {
        throw new $exception($this->error, $code);
    }

    /**
     * 返回最后执行的 sql 语句.
     */
    public function getLastSql(): ?string
    {
        return $this->mysql->getLastSql();
    }

    /**
     * 设置或者获取数据对象值.
     */
    public function data(object|string|array $data = ''): static|array
    {
        if ('' === $data && !empty($this->data)) {
            return $this->data;
        }

        if (is_object($data)) {
            $data = get_object_vars($data);
        } elseif (is_string($data)) {
            parse_str($data, $data);
        }
        $this->data = $data;
        return $this;
    }

    /**
     * 指定当前的数据表.
     */
    public function table(array|string $table): static
    {
        if (is_array($table)) {
            $this->options['table'] = $table;
        } elseif (!empty($table)) {
            $this->options['table'] = $table;
        }
        return $this;
    }

    /**
     * USING 支持用于多表删除.
     */
    public function using(array|string $using): static
    {
        if (is_array($using)) {
            $this->options['using'] = $using;
        } elseif (!empty($using)) {
            $this->options['using'] = $using;
        }
        return $this;
    }

    /**
     * 查询 SQL 组装 join.
     */
    public function join(string|array $join, string $type = 'INNER'): static
    {
        if (is_array($join)) {
            foreach ($join as &$v) {
                $v = false !== stripos($v, 'JOIN') ? $v : $type . ' JOIN ' . $v;
            }
            $this->options['join'] = $join;
        } elseif (!empty($join)) {
            $this->options['join'][] = false !== stripos($join, 'JOIN') ? $join : $type . ' JOIN ' . $join;
        }

        return $this;
    }

    /**
     * 查询 SQL 组装 union.
     */
    public function union(string|array|object $union, bool $all = false): static
    {
        if (empty($union)) {
            return $this;
        }

        if ($all) {
            $this->options['union']['_all'] = true;
        }
        if (is_object($union)) {
            $union = get_object_vars($union);
        }
        // 转换 union 表达式
        if (is_string($union)) {
            $options = $union;
        } else {
            if (isset($union[0])) {
                $this->options['union'] = array_merge($this->options['union'] ?? [], $union);
                return $this;
            }

            $options = $union;
        }
        $this->options['union'][] = $options;
        return $this;
    }

    /**
     * 查询缓存.
     *
     * @todo
     */
    public function cache(bool|string $key = true, ?int $expire = null, ICache $cache = null): static
    {
        // 增加快捷调用方式 cache(10) 等同于 cache(true, 10)
        if (is_int($key) && is_null($expire)) {
            $expire = $key;
            $key = true;
        }
        if (false !== $key) {
            $this->options['cache'] = array(
                'key' => $key,
                'expire' => $expire,
                'cache' => $cache
            );
        }
        return $this;
    }

    /**
     * 指定查询字段
     *
     * - 支持字段排除.
     */
    public function field(string|array|bool $field = '', bool $except = false): static
    {
        if (true === $field) {// 获取全部字段
            $fields = $this->getDbFields();
            $field = $fields ?: '*';
        } elseif ($except) {// 字段排除
            if (is_string($field)) {
                $field = explode(',', $field);
            }
            $fields = $this->getDbFields();
            $field = $fields ? array_diff($fields, $field) : $field;
        }
        $this->options['field'] = $field;
        return $this;
    }

    /**
     * 指定查询数量.
     */
    public function limit(int|string $offset, ?int $length = null): static
    {
        if (is_null($length) && is_string($offset) && strpos($offset, ',')) {
            list($offset, $length) = explode(',', $offset);
        }
        $this->options['limit'] = intval($offset) . ($length ? ',' . intval($length) : '');
        return $this;
    }

    /**
     * 指定分页.
     */
    public function page($page, $listRows = null): static
    {
        if (is_null($listRows) && is_string($page) && strpos($page, ',')) {
            list($page, $listRows) = explode(',', $page);
        }
        $this->options['page'] = array(intval($page), intval($listRows));
        return $this;
    }

    /**
     * 查询注释.
     */
    public function comment(string $comment): static
    {
        $this->options['comment'] = $comment;
        return $this;
    }

    /**
     * 读写分离场景下查询强制走主库.
     *
     * - 目前是用于解决阿里云 RDS 读写分离数据查询延迟的问题
     *
     * @see https://help.aliyun.com/document_detail/51225.html
     */
    public function forceMaster(): static
    {
        $this->options['force_master'] = true;

        return $this;
    }

    /**
     * 检测是否强制走主库.
     */
    public function isForceMaster(): bool
    {
        return isset($this->options['force_master']) && $this->options['force_master'] ? true : false;
    }

    /**
     * 字符串命名风格转换.
     *
     * - type 0 将 Java 风格转换为 C 的风格
     * - 1 将 C 风格转换为 Java 的风格
     */
    protected function parseName(string $name, int $type = 0): string
    {
        if ($type) {
            return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name));
        }

        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
}
