<?php
declare(strict_types=1);

namespace App\Infra;

use Closure;
use Leevel\Database\Ddd\Entity;
use Exception;

/**
 * ThinkPHP Mysql 驱动类兼容层
 *
 * - 基于 ThinkPHP 3.2.3 模型 Think\Db\Driver\Mysql 移植而来
 */
class Mysql
{
    /**
     * 当前 SQL 指令.
     */
    protected string $queryStr = '';

    /**
     * 数据库表达式.
     */
    protected array $exp = array(
        'eq' => '=',
        'neq' => '<>',
        'gt' => '>',
        'egt' => '>=',
        'lt' => '<',
        'elt' => '<=',
        'notlike' => 'NOT LIKE',
        'like' => 'LIKE',
        'in' => 'IN',
        'notin' => 'NOT IN',
        'not in' => 'NOT IN',
        'between' => 'BETWEEN',
        'not between' => 'NOT BETWEEN',
        'notbetween' => 'NOT BETWEEN'
    );

    /**
     * 查询表达式.
     *
     * - 注释实现阿里云走主库 @see https://help.aliyun.com/document_detail/51225.html
     */
    protected string $selectSql = '%FORCE_MASTER%SELECT %DISTINCT% %FIELD% FROM %TABLE%%FORCE%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%%LIMIT% %UNION%%LOCK%%COMMENT%';

    /**
     * 参数绑定.
     */
    protected array $bind = array();

    /**
     * 总记录数量.
     */
    protected int $totalCount = 0;

    /**
     * 模型实体.
     */
    protected Entity $entity;

    /**
     * 构造函数.
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
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
     * 插入记录.
     */
    public function insert(array $data, array $options = array(), bool $replace = false): int|string
    {
        $values = $fields = array();
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
     * 字段和表名处理.
     */
    protected function parseKey(&$key): string
    {
        $key = trim($key);
        if (!is_numeric($key) && !preg_match('/[,\'\"\*\(\)`.\s]/', $key)) {
            $key = '`' . $key . '`';
        }

        return $key;
    }

    /**
     * value 分析.
     */
    protected function parseValue(mixed $value): mixed
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
     * SQL 指令安全过滤.
     */
    public function escapeString(string $str): string
    {
        return addslashes($str);
    }

    /**
     * 参数绑定.
     */
    protected function bindParam($name, $value): void
    {
        $this->bind[':' . $name] = $value;
    }

    /**
     * table 分析.
     */
    protected function parseTable(array|string $tables): string
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
     * ON DUPLICATE KEY UPDATE 分析.
     */
    protected function parseDuplicate(mixed $duplicate): string
    {
        // 布尔值或空则返回空字符串
        if (is_bool($duplicate) || empty($duplicate)) {
            return '';
        }

        if (is_string($duplicate)) {
            // field1,field2 转数组
            $duplicate = explode(',', $duplicate);
        } elseif (is_object($duplicate)) {
            // 对象转数组
            $duplicate = get_class_vars($duplicate);
        }
        $updates = array();
        foreach ((array)$duplicate as $key => $val) {
            if (is_numeric($key)) {
                // array('field1', 'field2', 'field3') 解析为 ON DUPLICATE KEY UPDATE field1=VALUES(field1), field2=VALUES(field2), field3=VALUES(field3)
                $updates[] = $this->parseKey($val) . "=VALUES(" . $this->parseKey($val) . ")";
            } else {
                if (is_scalar($val)) { // 兼容标量传值方式
                    $val = array('value', $val);
                }
                if (!isset($val[1])) {
                    continue;
                }
                switch ($val[0]) {
                    case 'exp': // 表达式
                        $updates[] = $this->parseKey($key) . "=($val[1])";
                        break;
                    case 'value': // 值
                    default:
                        $name = count($this->bind);
                        $updates[] = $this->parseKey($key) . "=:" . $name;
                        $this->bindParam($name, $val[1]);
                        break;
                }
            }
        }

        if (empty($updates)) {
            return '';
        }

        return " ON DUPLICATE KEY UPDATE " . join(', ', $updates);
    }

    /**
     * comment 分析.
     */
    protected function parseComment(string $comment): string
    {
        return !empty($comment) ? '/*' . $comment . '*/' : '';
    }

    /**
     * 执行语句.
     */
    public function execute(string $str, bool $fetchSql = false): int|string
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

        $this->bind = array();
        return $this->entity::select()->execute($this->queryStr);
    }

    /**
     * 批量插入记录.
     *
     * @throws \Exception
     */
    public function insertAll(array $dataSet, array $options = array(), bool $replace = false): int
    {
        $values = array();
        if (!is_array($dataSet[0])) {
            throw new Exception('Invalid data.');
        }
        $fields = array_keys($dataSet[0]);
        array_walk($fields, array($this, 'parseKey'));
        foreach ($dataSet as $data) {
            $value = array();
            foreach ($data as $val) {
                if (is_array($val) && 'exp' == $val[0]) {
                    $value[] = $val[1];
                } elseif (is_scalar($val) || is_null($val)) {
                    if (0 === strpos($val, ':') && in_array($val, array_keys($this->bind))) {
                        $value[] = $this->parseValue($val);
                    } else {
                        $name = count($this->bind);
                        $value[] = ':' . $name;
                        $this->bindParam($name, $val);
                    }
                }
            }
            $values[] = '(' . implode(',', $value) . ')';
        }
        // 兼容数字传入方式
        $replace = (is_numeric($replace) && $replace > 0) ? true : $replace;
        $sql = (true === $replace ? 'REPLACE' : 'INSERT') . ' INTO ' . $this->parseTable($options['table']) . ' (' . implode(',', $fields) . ') VALUES ' . implode(',', $values) . $this->parseDuplicate($replace);
        $sql .= $this->parseComment(!empty($options['comment']) ? $options['comment'] : '');

        return $this->execute($sql, !empty($options['fetch_sql']) ? true : false);
    }

    /**
     * 通过 Select 方式插入记录.
     */
    public function selectInsert(string|array $fields, string $table, array $options = array()): int|string
    {
        if (is_string($fields)) {
            $fields = explode(',', $fields);
        }
        array_walk($fields, array($this, 'parseKey'));
        $sql = 'INSERT INTO ' . $this->parseTable($table) . ' (' . implode(',', $fields) . ') ';
        $sql .= $this->buildSelectSql($options);
        return $this->execute($sql, !empty($options['fetch_sql']) ? true : false);
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
        return $this->parseSql($this->selectSql, $options);
    }

    /**
     * 替换SQL语句中表达式
     * @access public
     * @param array $options 表达式
     * @return string
     */
    public function parseSql($sql, $options = array())
    {
        return str_replace(
            array('%FORCE_MASTER%', '%TABLE%', '%DISTINCT%', '%FIELD%', '%JOIN%', '%WHERE%', '%GROUP%', '%HAVING%', '%ORDER%', '%LIMIT%', '%UNION%', '%LOCK%', '%COMMENT%', '%FORCE%'),
            array(
                $this->parseForceMaster(!empty($options['force_master'])),
                $this->parseTable($options['table']),
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
    }

    protected function parseForceMaster($forceMaster)
    {
        return $forceMaster ? '/*FORCE_MASTER*/ ' : '';
    }

    /**
     * distinct 分析.
     */
    protected function parseDistinct(bool $distinct): string
    {
        return !empty($distinct) ? ' DISTINCT ' : '';
    }

    /**
     * field 分析.
     */
    protected function parseField(string|array $fields): string
    {
        if (is_string($fields) && '' !== $fields) {
            $fields = explode(',', $fields);
        }

        if (!is_array($fields)) {
            return '*';
        }

        // 完善数组方式传字段名的支持
        // 支持 'field1'=>'field2' 这样的字段别名定义
        $array = array();
        foreach ($fields as $key => $field) {
            if (!is_numeric($key)) {
                $array[] = $this->parseKey($key) . ' AS ' . $this->parseKey($field);
            } else {
                $array[] = $this->parseKey($field);
            }
        }

        return implode(',', $array);
    }

    /**
     * join 分析.
     */
    protected function parseJoin(string|array $join): string
    {
        $joinStr = '';
        if (!empty($join)) {
            $joinStr = ' ' . implode(' ', $join) . ' ';
        }

        return $joinStr;
    }

    /**
     * where 分析.
     */
    protected function parseWhere(mixed $where): string
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
     * 特殊条件分析.
     */
    protected function parseThinkWhere(string $key, mixed $val): string
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

    protected function parseWhereItem(string $key, mixed $val): string
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
                    E(('L_EXPRESS_ERROR_') . ':' . $val[0]);
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
            $whereStr .= $key . ' = ' . $this->parseValue($val);
        }

        return $whereStr;
    }

    /**
     * group 分析.
     */
    protected function parseGroup(string $group): string
    {
        return !empty($group) ? ' GROUP BY ' . $group : '';
    }

    /**
     * having 分析.
     */
    protected function parseHaving(string $having): string
    {
        return !empty($having) ? ' HAVING ' . $having : '';
    }

    /**
     * order 分析.
     */
    protected function parseOrder(array|string $order): string
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
     * 设置锁机制.
     */
    protected function parseLock(bool $lock = false): string
    {
        return $lock ? ' FOR UPDATE ' : '';
    }

    /**
     * index 分析，可在操作链中指定需要强制使用的索引.
     */
    protected function parseForce(array|string $index): string
    {
        if (empty($index)) {
            return '';
        }

        if (is_array($index)) {
            $index = join(",", $index);
        }

        return sprintf(" FORCE INDEX ( %s ) ", $index);
    }

    /**
     * 更新记录.
     */
    public function update(array $data, array $options): int
    {
        $table = $this->parseTable($options['table']);
        $sql = 'UPDATE ' . $table . $this->parseSet($data);
        if (strpos($table, ',')) {// 多表更新支持JOIN操作
            $sql .= $this->parseJoin(!empty($options['join']) ? $options['join'] : '');
        }
        $sql .= $this->parseWhere(!empty($options['where']) ? $options['where'] : '');
        if (!strpos($table, ',')) {
            //  单表更新支持 order 和 limit
            $sql .= $this->parseOrder(!empty($options['order']) ? $options['order'] : '')
                . $this->parseLimit(!empty($options['limit']) ? $options['limit'] : '');
        }
        $sql .= $this->parseComment(!empty($options['comment']) ? $options['comment'] : '');
        return $this->execute($sql, !empty($options['fetch_sql']) ? true : false);
    }

    /**
     * set 分析.
     */
    protected function parseSet(array $data): string
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
     * 删除记录.
     */
    public function delete(array $options = array()): int|false
    {
        $table = $this->parseTable($options['table']);
        $sql = 'DELETE FROM ' . $table;
        if (strpos($table, ',')) {// 多表删除支持 USING 和 JOIN 操作
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

    /**
     * 获取数据库字段.
     */
    public function getFields(): array
    {
        return [
            'fields' => array_keys($this->entity->fields()),
            'primaryKey' => $this->entity->primaryKey(),
            'auto' => $this->entity->autoIncrement(),
        ];
    }

    /**
     * 查找记录.
     */
    public function select(array $options = array()): mixed
    {
        $sql = $this->buildSelectSql($options);
        return $this->query($sql, !empty($options['fetch_sql']) ? true : false, $options['cache'] ?? []);
    }

    /**
     * 执行查询返回数据集.
     */
    public function query(string $str, bool $fetchSql = false, array $cacheOptions = []): mixed
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
            $this->totalCount = $count['0']['count'];
        }

        if ($fetchSql) {
            return $this->queryStr;
        }

        $result = $this->entity::select()
            ->query(
                $this->queryStr,
                [],
                false,
                $cacheOptions['key'] ?? null,
                $cacheOptions['expire'] ?? null,
                $cacheOptions['cache'] ?? null,
            );
        if (is_array($result)) {
            foreach ($result as &$v) {
                $v = (array)$v;
            }
        }

        return $result;
    }

    /**
     * 获取最近一次查询的 SQL 语句.
     */
    public function getLastSql(): ?string
    {
        return $this->queryStr;
    }

    /**
     * 获取最近插入的 ID.
     */
    public function getLastInsID(): string
    {
        return $this->entity::select()->lastInsertId();
    }

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
}
