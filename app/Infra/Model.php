<?php

declare(strict_types=1);

namespace App\Infra;

use Closure;
use Exception;
use Leevel\Cache\ICache;
use Leevel\Database\Ddd\Entity;

/**
 * ThinkPHP Model 模型类兼容层
 *
 * - 基于 ThinkPHP 3.2.3 模型 \Think\Model 移植而来
 * - 实现了 ORM 和 ActiveRecords 模式
 */
abstract class Model
{
    /**
     * 插入模型数据.
     */
    public const MODEL_INSERT = 1;

    /**
     * 更新模型数据.
     */
    public const MODEL_UPDATE = 2;

    /**
     * 包含上面两种方式.
     */
    public const MODEL_BOTH = 3;

    /**
     * 必须验证.
     */
    public const MUST_VALIDATE = 1;

    /**
     * 表单存在字段则验证.
     */
    public const EXISTS_VALIDATE = 0;

    /**
     * 表单值不为空则验证.
     */
    public const VALUE_VALIDATE = 2;

    /**
     * 数据库驱动兼容层.
     */
    protected Database $database;

    /**
     * 自动完成定义.
     */
    protected string|array $pk = 'id';

    /**
     * 主键是否自动增长.
     */
    protected bool $autoing = false;

    /**
     * 表名称.
     */
    private string $tableName = '';

    /**
     * 最近错误信息.
     */
    protected string|array $currentError = '';

    /**
     * 字段信息.
     */
    protected array $fields = array();

    /**
     * 数据信息.
     */
    protected array $data = array();

    /**
     * 查询表达式参数.
     */
    protected array $options = array();

    /**
     * 自动完成定义.
     */
    protected array $_validate = array();

    /**
     * 自动完成定义.
     */
    protected array $_auto = array();

    /**
     * 命名范围定义.
     */
    protected array $_scope = array();

    /**
     * 是否自动检测数据表字段信息.
     */
    protected bool $autoCheckFields = true;

    /**
     * 是否批处理验证.
     */
    protected bool $patchValidate = false;

    /**
     * 是否为统计查询.
     */
    private bool $shouldCountSelect = false;

    /**
     * 总记录数量.
     */
    protected int $totalCount = 0;

    /**
     * 构造函数.
     */
    public function __construct()
    {
        $this->_initialize();
        $this->createConnect();
    }

    protected function _initialize(): void
    {
    }

    public function patchValidate(bool $patchValidate = true): static
    {
        $this->patchValidate = $patchValidate;
        return $this;
    }

    /**
     * 创建数据库连接.
     *
     * @throws Exception
     */
    protected function createConnect(): void
    {
        if (!defined(static::class . '::ENTITY')) {
            throw new Exception(sprintf('Entity of model %s not defined.', static::class));
        }

        $entity = constant(static::class . '::ENTITY');
        /** @var Entity $entity */
        $entity = new $entity();
        $this->database = new Database($entity);
        $this->tableName = $entity->table();
        $this->_checkTableInfo();
    }

    /**
     * 自动检测数据表信息.
     */
    protected function _checkTableInfo(): void
    {
        // 如果不是Model类 自动记录数据表信息
        // 只在第一次执行记录
        if (empty($this->fields)) {
            $this->flush();
        }
    }

    /**
     * 获取字段信息并缓存.
     */
    public function flush(): void
    {
        $fields = $this->database->getFields();
        $pk = $fields['primaryKey'];
        if (is_array($pk) && count($pk) === 1) {
            $pk = $pk[0];
        }
        $this->pk = $pk;
        $this->fields = $fields['fields'];
        $this->autoing = !empty($fields['auto']);
    }

    /**
     * 创建一个新对象.
     */
    public static function make(): static
    {
        return new static();
    }

    /**
     * 获取数据对象的值.
     */
    public function __get(string $name): mixed
    {
        return $this->data[$name] ?? null;
    }

    /**
     * 设置数据对象的值.
     */
    public function __set(string $name, mixed $value): void
    {
        // 错误直接抛出异常，取消以前那种 getError 写法
        if ($name === 'error') {
            $this->getError($value);
        }

        // 设置数据对象属性
        $this->data[$name] = $value;
    }

    /**
     * 检测数据对象的值.
     */
    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * 销毁数据对象的值.
     */
    public function __unset(string $name): void
    {
        unset($this->data[$name]);
    }

    public function strict(bool $strict = true): static
    {
        $this->options['strict'] = $strict;
        return $this;
    }

    public function order(string|array $order = ''): static
    {
        $this->options['order'] = $order;
        return $this;
    }

    public function alias(string $alias = ''): static
    {
        $this->options['alias'] = $alias;
        return $this;
    }

    public function having(string $having = ''): static
    {
        $this->options['having'] = $having;
        return $this;
    }

    public function group(string $group = ''): static
    {
        $this->options['group'] = $group;
        return $this;
    }

    public function lock(bool $lock = true): static
    {
        $this->options['lock'] = $lock;
        return $this;
    }

    public function distinct(bool $distinct = true): static
    {
        $this->options['distinct'] = $distinct;
        return $this;
    }

    public function auto(array $auto = []): static
    {
        $this->options['auto'] = $auto;
        return $this;
    }

    public function filter(callable $filter): static
    {
        $this->options['filter'] = $filter;
        return $this;
    }

    public function validate(array $validate): static
    {
        $this->options['validate'] = $validate;
        return $this;
    }

    public function index(string $index = ''): static
    {
        $this->options['index'] = $index;
        return $this;
    }

    public function count(string $field = '*'): string|int
    {
        return $this->totalCount = $this->callStatisticalQuery('count', $field);
    }

    public function sum(string $field = '*'): string|int|float
    {
        return $this->callStatisticalQuery('sum', $field);
    }

    public function min(string $field = '*'): string|int|float
    {
        return $this->callStatisticalQuery('min', $field);
    }

    public function max(string $field = '*'): string|int|float
    {
        return $this->callStatisticalQuery('max', $field);
    }

    public function avg(string $field = '*'): string|int|float
    {
        return $this->callStatisticalQuery('avg', $field);
    }

    protected function callStatisticalQuery($method, string $field): string|int|float
    {
        try {
            $this->shouldCountSelect = true;
            return $this->getField(strtoupper($method) . '(' . $field . ') AS ' . $method);
        } finally {
            $this->shouldCountSelect = false;
        }
    }

    public function findCount(array $in = []): string|int
    {
        $this->mergeScopeWhere($in);

        return $this->count();
    }

    public function findList(array $in = []): string|array
    {
        $this->mergeScopeWhere($in);

        return $this->select();
    }

    public function findListAndCount(array $in = []): array
    {
        $this->mergeScopeWhere($in);
        $countThis = clone $this;

        return [
            'count' => $this->totalCount = $countThis->count(),
            'list' => $this->select(),
        ];
    }

    public function findOne(array $in = []): string|array
    {
        $this->mergeScopeWhere($in);

        return $this->find();
    }

    /**
     * 利用 __call 方法实现一些特殊的 Model 方法.
     *
     * @throws Exception
     */
    public function __call(string $method, array $args): mixed
    {
        if (strtolower(substr($method, 0, 5)) == 'getby') {
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
            throw new Exception(__CLASS__ . ':' . $method . ' not exist.');
        }
    }

    /**
     * 获取一条记录的某个字段值.
     */
    public function getField($field, null|string|bool|int $separator = null): string|array|int|float
    {
        $options['field'] = $field;
        $options = $this->_parseOptions($options);

        // 判断查询缓存
        if (isset($options['cache'])) {
            $cache = $options['cache'];
            $key = is_string($cache['key']) ? $cache['key'] : 'sql:' . md5($separator . serialize($options));
            $options['cache']['key'] = $key;
        }
        $field = trim($field);
        if (strpos($field, ',') && false !== $separator) { // 多字段
            if (!isset($options['limit'])) {
                $options['limit'] = is_numeric($separator) ? $separator : '';
            }
            $resultSet = $this->database->select($this->filterOptionsForCountSelect($options));
            if (empty($resultSet)) {
                return $resultSet;
            }

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
                    $cols[$name] = is_string($separator) ? implode($separator, array_slice($result, 1)) : $result;
                }
            }
            return $cols;
        }

        // 查找一条记录
        // 返回数据个数
        if (true !== $separator) {// 当 $separator 指定为 true 的时候返回所有数据
            $options['limit'] = is_numeric($separator) ? $separator : 1;
        }
        $result = $this->database->select($this->filterOptionsForCountSelect($options));
        if (!empty($result) && is_array($result)) {
            if (true !== $separator && 1 == $options['limit']) {
                return current($result[0]);
            }
            $array = [];
            foreach ($result as $val) {
                $array[] = $val[$field];
            }
            return $array;
        }

        return $result;
    }

    protected function filterOptionsForCountSelect(array $options): array
    {
        // 统计查询移除掉一些特性
        if (!$this->shouldCountSelect) {
            return $options;
        }

        foreach (['page', 'order'] as $field) {
            if (isset($options[$field])) {
                $options[$field] = '';
            }
        }

        $options['limit'] = 1;

        return $options;
    }

    /**
     * 分析表达式.
     *
     * @throws Exception
     */
    protected function _parseOptions(array $options = array()): array
    {
        if (is_array($options)) {
            $options = array_merge($this->options, $options);
        }

        if (!isset($options['table'])) {
            // 自动获取表名
            $options['table'] = $this->getTableName();
            $fields = $this->fields;
        } else {
            // 指定数据表，则重新获取字段列表，但不支持类型检测
            $fields = $this->getDbFields();
        }

        // 数据表别名
        if (!empty($options['alias'])) {
            $options['table'] .= ' ' . $options['alias'];
        }

        // 字段类型验证
        if (isset($options['where']) &&
            is_array($options['where']) &&
            !empty($fields) &&
            !isset($options['join'])) {
            // 对数组查询条件进行字段类型检查
            foreach ($options['where'] as $key => $val) {
                $key = trim($key);
                if (in_array($key, $fields, true)) {
                } elseif (!is_numeric($key) &&
                    !str_starts_with($key, '_') &&
                    !str_contains($key, '.') &&
                    !str_contains($key, '(') &&
                    !str_contains($key, '|') &&
                    !str_contains($key, '&')) {
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

    /**
     * 得到数据表名.
     */
    public function getTableName(): string
    {
        return $this->tableName;
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

    /**
     * 获取数据表字段信息.
     */
    public function getDbFields(): array|false
    {
        if (isset($this->options['table'])) {// 动态指定表名
            if (!is_array($this->options['table'])) {
                $table = $this->options['table'];
                if (strpos($table, ')')) {
                    // 子查询
                    return false;
                }
            }
            $fields = $this->database->getFields();
            return !empty($fields['fields']) ? array_keys($fields['fields']) : false;
        }
        if ($this->fields) {
            return $this->fields;
        }
        return false;
    }

    protected function _options_filter(array &$options): void
    {
    }

    /**
     * 查询数据.
     */
    public function find(array|string|int|float $options = array()): array|string
    {
        $where = [];
        if (is_numeric($options) || is_string($options)) {
            $where[$this->getPk()] = $options;
            $options = array();
            $options['where'] = $where;
        }
        // 根据复合主键查找记录
        $pk = $this->getPk();
        if (is_array($options) && $options && is_array($pk)) {
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
                throw new Exception('Invalid primary where condition.');
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
        $resultSet = $this->database->select($options);
        if (is_string($resultSet)) {
            return $resultSet;
        }

        // 读取数据后的处理
        if ($resultSet) {
            $data = $resultSet[0];
            $this->_after_find($data, $options);
        } else {
            $data = $resultSet;
        }
        return $this->data = $data;
    }

    /**
     * 获取主键名称.
     */
    public function getPk(): string|array
    {
        return $this->pk;
    }

    protected function _after_find(array &$result, array $options): void
    {
    }

    /**
     * 指定查询条件.
     *
     * - 支持安全过滤
     */
    public function where(mixed $where, mixed $parse = null): static
    {
        if (!is_null($parse) && is_string($where)) {
            if (!is_array($parse)) {
                $parse = func_get_args();
                array_shift($parse);
            }
            $parse = array_map(array($this->database, 'escapeString'), $parse);
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
     * 调用命名范围.
     */
    public function scope(string|array $scope = '', ?array $args = NULL): static
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
            if (!empty($args)) {
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

    /**
     * 得到上一次分页查询的总条数.
     */
    public function fetchTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * 新增数据.
     *
     * @throws Exception
     */
    public function add(mixed $data = '', array $options = array(), bool $replace = false): int|string
    {
        if (empty($data)) {
            // 没有传递数据，获取当前数据对象的值
            if (!empty($this->data)) {
                $data = $this->data;
                // 重置数据
                $this->data = array();
            } else {
                throw new Exception('Data type invalid.');
            }
        }
        // 数据处理
        $data = $this->_facade($data);
        // 分析表达式
        $options = $this->_parseOptions($options);
        $this->_before_insert($data, $options);
        // 写入数据到数据库
        $result = $this->database->insert($data, $options, $replace);
        if (!is_int($result) && ctype_digit($result)) {
            $pk = $this->getPk();
            // 增加复合主键支持
            if (is_array($pk)) {
                return $result;
            }
            $insertId = $result;
            if ($insertId) {
                // 自增主键返回插入ID
                $data[$pk] = $insertId;
                $this->_after_insert($data, $options);
                return $insertId;
            }
            $this->_after_insert($data, $options);
        }
        return $result;
    }

    /**
     * 对保存到数据库的数据进行处理.
     *
     * @throws Exception
     */
    protected function _facade(array $data): array
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
                        throw new Exception('Data type invalid:[' . $key . '=>' . $val . ']');
                    }
                    unset($data[$key]);
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

    protected function _before_write(array &$data): void
    {
    }

    protected function _before_insert(array &$data, array $options): void
    {
    }

    protected function _after_insert(array &$data, array $options): void
    {
    }

    /**
     * @throws Exception
     */
    public function addAll(array $dataList, array $options = array(), bool $replace = false): int|string
    {
        if (empty($dataList)) {
            throw new Exception('Data type invalid.');
        }
        // 数据处理
        foreach ($dataList as $key => $data) {
            $dataList[$key] = $this->_facade($data);
        }
        // 分析表达式
        $options = $this->_parseOptions($options);
        // 写入数据到数据库
        return $this->database->insertAll($dataList, $options, $replace);
    }

    /**
     * 返回最后插入的 ID.
     */
    public function getLastInsID(): null|string|int
    {
        $lastInsID = $this->database->getLastInsID();
        if (ctype_digit($lastInsID)) {
            $lastInsID = (int)$lastInsID;
        }
        return $lastInsID;
    }

    /**
     * 通过 Select 方式添加记录.
     */
    public function selectAdd(array|string $fields = '', string $table = '', array $options = array()): int|string
    {
        // 分析表达式
        $options = $this->_parseOptions($options);
        // 写入数据到数据库
        return $this->database->selectInsert($fields ?: $options['field'], $table ?: $this->getTableName(), $options);
    }

    /**
     * 删除数据.
     *
     * @throws Exception
     */
    public function delete(int|string|array $options = array()): int|string
    {
        $pk = $this->getPk();
        if (empty($options) && empty($this->options['where'])) {
            // 如果删除条件为空，则删除当前数据对象所对应的记录
            if (!empty($this->data) && isset($this->data[$pk])) {
                return $this->delete($this->data[$pk]);
            } else {
                throw new Exception('Invalid delete condition.');
            }
        }
        $where = [];
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
        if (is_array($options) && $options && is_array($pk)) {
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
                throw new Exception('Invalid primary where condition.');
            }
        }
        // 分析表达式
        $options = $this->_parseOptions($options);
        if (empty($options['where'])) {
            // 如果条件为空，不进行删除操作，除非设置 1=1
            throw new Exception('Empty where condition.');
        }
        if (is_array($options['where']) && isset($options['where'][$pk])) {
            $pkValue = $options['where'][$pk];
        }

        $this->_before_delete($options);
        $result = $this->database->delete($options);
        if (is_numeric($result)) {
            $data = array();
            if (isset($pkValue)) {
                $data[$pk] = $pkValue;
            }
            $this->_after_delete($data, $options);
        }
        // 返回删除记录个数
        return $result;
    }

    protected function _before_delete(array $options): void
    {
    }

    protected function _after_delete(array &$data, array $options): void
    {
    }

    /**
     * 查询数据集.
     *
     * @throws Exception
     */
    public function select(int|string|array|bool $options = array()): array|string
    {
        $pk = $this->getPk();
        $where = [];
        if (is_string($options) || is_numeric($options)) {
            // 根据主键查询
            if (strpos($options, ',')) {
                $where[$pk] = array('IN', $options);
            } else {
                $where[$pk] = $options;
            }
            $options = array();
            $options['where'] = $where;
        } elseif (is_array($options) && $options && is_array($pk)) {
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
                throw new Exception('Invalid primary where condition.');
            }
        } elseif (false === $options) { // 用于子查询 不查询只返回SQL
            return $this->buildSql();
        }

        // 分析表达式
        $options = $this->_parseOptions($options);
        // 判断查询缓存
        if (isset($options['cache'])) {
            $cache = $options['cache'];
            $key = is_string($cache['key']) ? $cache['key'] : 'sql:' . md5(serialize($options));
            $options['cache']['key'] = $key;
        }

        $resultSet = $this->database->select($options);
        if (is_string($resultSet)) {
            return $resultSet;
        }

        $this->_after_select($resultSet, $options);
        if (isset($options['index'])) { // 对数据集进行索引
            $index = explode(',', $options['index']);
            $cols = [];
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

        return $resultSet;
    }

    /**
     * 生成查询 SQL 可用于子查询.
     */
    public function buildSql(): string
    {
        return '( ' . $this->fetchSql(true)->select() . ' )';
    }

    /**
     * 设置是否获取执行的 SQL 语句.
     */
    public function fetchSql(bool $fetch = true): static
    {
        $this->options['fetch_sql'] = $fetch;
        return $this;
    }

    protected function _after_select(array &$resultSet, array $options): void
    {
    }

    /**
     * 字段值增长.
     */
    public function setInc(string $field, int $step = 1): int
    {
        return $this->setField($field, array('exp', $field . '+' . $step));
    }

    /**
     * 设置记录的某个字段值.
     *
     * - 支持使用数据库字段和方法
     */
    public function setField(array|string $field, mixed $value = ''): int
    {
        if (is_array($field)) {
            $data = $field;
        } else {
            $data[$field] = $value;
        }
        return $this->save($data);
    }

    /**
     * 保存数据.
     *
     * @throws Exception
     */
    public function save(mixed $data = '', array $options = array()): int
    {
        if (empty($data)) {
            // 没有传递数据，获取当前数据对象的值
            if (!empty($this->data)) {
                $data = $this->data;
                // 重置数据
                $this->data = array();
            } else {
                throw new Exception('Data type invalid.');
            }
        }
        // 数据处理
        $data = $this->_facade($data);
        if (empty($data)) {
            // 没有数据则不执行
            throw new Exception('Data type invalid.');
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
                        throw new Exception('Operation wrong.');
                    }
                    unset($data[$field]);
                }
            }
            if (!isset($where)) {
                // 如果没有任何更新条件则不执行
                throw new Exception('Operation wrong.');
            } else {
                $options['where'] = $where;
            }
        }

        if (is_array($options['where']) && isset($options['where'][$pk])) {
            $pkValue = $options['where'][$pk];
        }
        $this->_before_update($data, $options);
        $affectedRow = $this->database->update($data, $options);
        if ($affectedRow > 0) {
            if (isset($pkValue)) $data[$pk] = $pkValue;
            $this->_after_update($data, $options);
        }
        return $affectedRow;
    }

    protected function _before_update(array &$data, array $options): void
    {
    }

    protected function _after_update(array &$data, array $options): void
    {
    }

    /**
     * 字段值减少.
     */
    public function setDec(string $field, int $step = 1): int
    {
        return $this->setField($field, array('exp', $field . '-' . $step));
    }

    /**
     * 创建数据对象.
     *
     * - 但不保存到数据库.
     *
     * @throws Exception
     */
    public function create(mixed $data = '', int $type = 0): static
    {
        // 如果没有传值默认取POST数据
        if (empty($data)) {
            $data = http_request()->request->all();
        } elseif (is_object($data)) {
            $data = get_object_vars($data);
        }
        // 验证数据
        if (empty($data) || !is_array($data)) {
            throw new Exception('Data type invalid.');
        }

        // 状态
        $type = $type ?: (!empty($data[$this->getPk()]) ? self::MODEL_UPDATE : self::MODEL_INSERT);

        // 检测提交字段的合法性
        if (isset($this->options['field'])) {
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
        if (!$this->autoValidation($data, $type)) {
            $currentError = $this->currentError;
            if (is_array($currentError)) {
                $currentError = $this->formatPatchValidate($currentError);
            }
            $this->getError($currentError);
        }

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
        return $this;
    }

    protected function formatPatchValidate(array $currentError): string
    {
        $message = [];
        foreach ($currentError as $v) {
            $message[] = sprintf('%s;', $v);
        }

        return implode('', $message);
    }

    /**
     * 自动表单验证.
     */
    protected function autoValidation(array $data, int $type): bool
    {
        if (!empty($this->options['validate'])) {
            $validateData = $this->options['validate'];
            unset($this->options['validate']);
        } elseif (!empty($this->_validate)) {
            $validateData = $this->_validate;
        }
        // 属性验证
        if (isset($validateData)) { // 如果设置了数据自动验证则进行数据验证
            if ($this->patchValidate) { // 重置验证错误信息
                $this->currentError = array();
            }
            foreach ($validateData as $val) {
                // 验证因子定义格式
                // array(field,rule,message,condition,type,when,params)
                // 判断是否需要执行验证
                if (empty($val[5]) || ($val[5] == self::MODEL_BOTH && $type < 3) || $val[5] == $type) {
                    if (0 == strpos($val[2], '{%') && strpos($val[2], '}'))
                        // 支持提示信息的多语言 使用 {%语言定义} 方式
                        $val[2] = substr($val[2], 2, -1);

                    $val[3] = $val[3] ?? self::EXISTS_VALIDATE;
                    $val[4] = $val[4] ?? 'regex';
                    // 判断验证条件
                    switch ($val[3]) {
                        case self::MUST_VALIDATE:   // 必须验证 不管表单是否有设置该字段
                            if (false === $this->_validationField($data, $val))
                                return false;
                            break;
                        case self::VALUE_VALIDATE:    // 值不为空的时候才验证
                            if (isset($data[$val[0]]) && '' != trim($data[$val[0]]))
                                if (false === $this->_validationField($data, $val)) {
                                    return false;
                                }
                            break;
                        default:    // 默认表单存在该字段就验证
                            if (isset($data[$val[0]]))
                                if (false === $this->_validationField($data, $val)) {
                                    return false;
                                }
                    }
                }
            }
            // 批量验证的时候最后返回错误
            if (!empty($this->currentError)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 验证表单字段 支持批量验证.
     *
     * - 如果批量验证返回错误的数组信息
     */
    protected function _validationField(array $data, array $val): ?bool
    {
        if ($this->patchValidate && isset($this->currentError[$val[0]])) {
            return null; //当前字段已经有规则验证没有通过
        }
        if (false === $this->_validationFieldItem($data, $val)) {
            if ($this->patchValidate) {
                $this->currentError[$val[0]] = $val[2];
            } else {
                $this->currentError = $val[2];
                return false;
            }
        }
        return null;
    }

    /**
     * 根据验证因子验证字段.
     */
    protected function _validationFieldItem(array $data, array $val): bool
    {
        switch (strtolower(trim($val[4]))) {
            case 'function':// 使用函数进行验证
            case 'callback':// 调用方法进行验证
                $args = isset($val[6]) ? (array)$val[6] : array();
                if (is_string($val[0]) && strpos($val[0], ',')) {
                    $val[0] = explode(',', $val[0]);
                }
                if (is_array($val[0])) {
                    // 支持多个字段验证
                    $tempData = [];
                    foreach ($val[0] as $field) {
                        $tempData[$field] = $data[$field];
                    }
                    array_unshift($args, $tempData);
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
                if (is_string($val[0]) && strpos($val[0], ',')) {
                    $val[0] = explode(',', $val[0]);
                }
                $map = array();
                if (is_array($val[0])) {
                    // 支持多个字段验证
                    foreach ($val[0] as $field) {
                        $map[$field] = $data[$field];
                    }
                } else {
                    $map[$val[0]] = $data[$val[0]];
                }
                $pk = $this->getPk();
                if (!empty($data[$pk]) && is_string($pk)) { // 完善编辑的时候验证唯一
                    $map[$pk] = array('neq', $data[$pk]);
                }
                if ($this->where($map)->find()) {
                    return false;
                }
                return true;
            default:  // 检查附加规则
                return $this->check($data[$val[0]], $val[1], $val[4]);
        }
    }

    /**
     * 验证数据 支持 in between equal length regex expire ip_allow ip_deny.
     */
    public function check(mixed $value, array|string $rule, string $type = 'regex'): bool
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
                if (!is_numeric($start)) {
                    $start = strtotime($start);
                }
                if (!is_numeric($end)) {
                    $end = strtotime($end);
                }
                return time() >= $start && time() <= $end;
            case 'regex':
            default:    // 默认使用正则验证 可以使用验证类中定义的验证名称
                // 检查附加规则
                return $this->regex($value, $rule);
        }
    }

    /**
     * 使用正则验证数据.
     */
    public function regex(string $value, string $rule): bool
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
        // 检查是否有内置得正则表达式
        if (isset($validate[strtolower($rule)])) {
            $rule = $validate[strtolower($rule)];
        }

        return preg_match($rule, $value) === 1;
    }

    /**
     * 自动表单处理.
     */
    private function autoOperation(array &$data, int $type): void
    {
        if (!empty($this->options['auto'])) {
            $autoData = $this->options['auto'];
            unset($this->options['auto']);
        } elseif (!empty($this->_auto)) {
            $autoData = $this->_auto;
        }

        // 自动填充
        if (isset($autoData)) {
            foreach ($autoData as $auto) {
                // 填充因子定义格式
                // array('field','填充内容','填充条件','附加规则',[额外参数])
                if (empty($auto[2])) {
                    $auto[2] = self::MODEL_INSERT; // 默认为新增的时候自动填充
                }
                if ($type == $auto[2] || $auto[2] == self::MODEL_BOTH) {
                    if (empty($auto[3])) {
                        $auto[3] = 'string';
                    }
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
                            if ($auto[1] === $data[$auto[0]]) {
                                unset($data[$auto[0]]);
                            }
                            break;
                        case 'string':
                        default: // 默认作为字符串填充
                            $data[$auto[0]] = $auto[1];
                    }
                    if (isset($data[$auto[0]]) && false === $data[$auto[0]]) {
                        unset($data[$auto[0]]);
                    }
                }
            }
        }
    }

    /**
     * SQL 查询.
     */
    public function query(string $sql, bool|array|string $parse = false): array|string
    {
        if (!is_bool($parse) && !is_array($parse)) {
            $parse = func_get_args();
            array_shift($parse);
        }
        $sql = $this->parseSql($sql, $parse);
        return $this->database->query($sql);
    }

    /**
     * 解析 SQL 语句.
     */
    protected function parseSql(string $sql, bool|array|string $parse): string
    {
        // 分析表达式
        if (true === $parse) {
            $options = $this->_parseOptions();
            $sql = $this->database->parseSql($sql, $options);
        } elseif (is_array($parse)) { // SQL预处理
            $parse = array_map(array($this->database, 'escapeString'), $parse);
            $sql = vsprintf($sql, $parse);
        }
        return $sql;
    }

    /**
     * 执行 SQL 语句.
     */
    public function execute(string $sql, bool|array|string $parse = false): int|string
    {
        if (!is_bool($parse) && !is_array($parse)) {
            $parse = func_get_args();
            array_shift($parse);
        }
        $sql = $this->parseSql($sql, $parse);
        return $this->database->execute($sql);
    }

    /**
     * 启动事务.
     */
    public function startTrans(): void
    {
        $this->database->startTrans();
    }

    /**
     * 提交事务.
     */
    public function commit(): void
    {
        $this->database->commit();
    }

    /**
     * 事务回滚.
     */
    public function rollback(): void
    {
        $this->database->rollback();
    }

    /**
     * 事务处理.
     *
     * - 大多数框架都封装这种用法，简化调用
     */
    public function transaction(Closure $businessLogic): mixed
    {
        return $this->database->transaction($businessLogic);
    }

    /**
     * 返回模型的错误信息.
     *
     * - 方法不再支持返回错误消息
     * - 支持抛出异常
     *
     * @throws Exception
     * @deprecated
     */
    public function getError(?string $message = null): void
    {
        throw new Exception($message ?? 'Method getError is deprecated.');
    }

    /**
     * 返回最后执行的 sql 语句.
     */
    public function getLastSql(): null|string
    {
        return $this->database->getLastSql();
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
            $oldData = $data;
            $data = [];
            parse_str($oldData, $data);
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
        if (!is_string($union)) {
            if (isset($union[0])) {
                $this->options['union'] = array_merge($this->options['union'] ?? [], $union);
                return $this;
            }

        }
        $options = $union;
        $this->options['union'][] = $options;
        return $this;
    }

    /**
     * 查询缓存.
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
        return isset($this->options['force_master']) && $this->options['force_master'];
    }

    protected function parseInArgs(array $in): array
    {
        if (in_array('company_id', $this->fields, true)) {
            if (!isset($in['map']['company_id'])) {
                $in['map']['company_id'] = get_company_id();
            } elseif (false === $in['map']['company_id']) {
                unset($in['map']['company_id']);
            }
        }

        if (isset($in['map'])) {
            $in['where'] = $in['map'];
            unset($in['map']);
        }
        return $in;
    }

    protected function mergeScopeWhere(array $in): void
    {
        $in = $this->parseInArgs($in);
        $baseWhere = [];
        if (isset($in['scope'])) {
            $this->scope($in['scope']);
            $baseWhere = $this->options['where'];
        }
        $this->scope($in);
        if ($baseWhere) {
            $this->options['where'] = array_merge($baseWhere, $this->options['where']);
        }
    }
}
