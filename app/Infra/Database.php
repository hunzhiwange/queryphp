<?php

declare(strict_types=1);

namespace App\Infra;

use Leevel\Database\Ddd\Entity;

/**
 * ThinkPHP 数据库驱动类兼容层
 *
 * - 基于 ThinkPHP 3.2.3 模型 Think\Db\Driver\Mysql 移植而来
 */
class Database
{
    /**
     * 当前 SQL 指令.
     */
    protected string $queryStr = '';

    /**
     * 数据库表达式.
     */
    protected array $exp = [
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
        'notbetween' => 'NOT BETWEEN',
    ];

    /**
     * 查询表达式.
     *
     * - 注释实现阿里云走主库 @see https://help.aliyun.com/document_detail/51225.html
     */
    protected string $selectSql = '%FORCE_MASTER%SELECT %DISTINCT% %FIELD% FROM %TABLE%%FORCE%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%%LIMIT% %UNION%%LOCK%%COMMENT%';

    /**
     * 参数绑定.
     */
    protected array $bind = [];

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

    public function __sleep()
    {
        return [];
    }

    public function __wakeup()
    {
        return [];
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
     * 事务处理.
     *
     * - 大多数框架都封装这种用法，简化调用
     */
    public function transaction(\Closure $businessLogic): mixed
    {
        return $this->entity::select()->transaction($businessLogic);
    }

    /**
     * 插入记录.
     */
    public function insert(array $data, array $options = [], bool $replace = false): int|string
    {
        $values = $fields = [];
        foreach ($data as $key => $val) {
            if (\is_array($val) && 'exp' === $val[0]) {
                $fields[] = $this->parseKey($key);
                $values[] = $val[1];
            } elseif (\is_scalar($val)) { // 过滤非标量数据
                $fields[] = $this->parseKey($key);
                if (\is_string($val) && str_starts_with($val, ':') && \in_array($val, array_keys($this->bind), true)) {
                    $values[] = $this->parseValue($val);
                } else {
                    $name = \count($this->bind);
                    $values[] = ':'.$name;
                    $this->bindParam($name, $val);
                }
            }
        }
        // 兼容数字传入方式
        $replace = (is_numeric($replace) && $replace > 0) ? true : $replace;
        $sql = (true === $replace ? 'REPLACE' : 'INSERT').' INTO '.$this->parseTable($options['table']).' ('.implode(',', $fields).') VALUES ('.implode(',', $values).')'.$this->parseDuplicate($replace);
        $sql .= $this->parseComment(!empty($options['comment']) ? $options['comment'] : '');

        return $this->execute($sql);
    }

    /**
     * SQL 指令安全过滤.
     */
    public function escapeString(string $str): string
    {
        return addslashes($str);
    }

    /**
     * 执行语句.
     */
    public function execute(string $str): int|string
    {
        $this->queryStr = $str;
        if (!empty($this->bind)) {
            $that = $this;
            $this->queryStr = strtr($this->queryStr, array_map(function ($val) use ($that) {
                return '\''.(\is_string($val) ? $that->escapeString($val) : $val).'\'';
            }, $this->bind));
        }

        $this->bind = [];

        return $this->entity::select()->execute($this->queryStr);
    }

    /**
     * 批量插入记录.
     *
     * @throws \InvalidArgumentException
     */
    public function insertAll(array $dataSet, array $options = [], bool $replace = false): int|string
    {
        $values = [];
        if (!\is_array($dataSet[0])) {
            throw new \InvalidArgumentException('Invalid data.');
        }
        $fields = array_keys($dataSet[0]);
        array_walk($fields, [$this, 'parseKey']);
        foreach ($dataSet as $data) {
            $value = [];
            foreach ($data as $val) {
                if (\is_array($val) && 'exp' === $val[0]) {
                    $value[] = $val[1];
                } elseif (\is_scalar($val) || null === $val) {
                    if (str_starts_with($val, ':') && \in_array($val, array_keys($this->bind), true)) {
                        $value[] = $this->parseValue($val);
                    } else {
                        $name = \count($this->bind);
                        $value[] = ':'.$name;
                        $this->bindParam($name, $val);
                    }
                }
            }
            $values[] = '('.implode(',', $value).')';
        }
        // 兼容数字传入方式
        $replace = (is_numeric($replace) && $replace > 0) ? true : $replace;
        $sql = (true === $replace ? 'REPLACE' : 'INSERT').' INTO '.$this->parseTable($options['table']).' ('.implode(',', $fields).') VALUES '.implode(',', $values).$this->parseDuplicate($replace);
        $sql .= $this->parseComment(!empty($options['comment']) ? $options['comment'] : '');

        return $this->execute($sql);
    }

    /**
     * 通过 Select 方式插入记录.
     */
    public function selectInsert(string|array $fields, string $table, array $options = []): int|string
    {
        if (\is_string($fields)) {
            $fields = explode(',', $fields);
        }
        array_walk($fields, [$this, 'parseKey']);
        $sql = 'INSERT INTO '.$this->parseTable($table).' ('.implode(',', $fields).') ';
        $sql .= $this->buildSelectSql($options);

        return $this->execute($sql);
    }

    /**
     * 生成查询 SQL.
     *
     * @param mixed $options
     */
    public function buildSelectSql($options = []): string
    {
        if (!empty($options['page'])) {
            // 根据页数计算 limit
            [$page, $listRows] = $options['page'];
            $page = $page > 0 ? $page : 1;
            $listRows = $listRows > 0 ? $listRows : (is_numeric($options['limit']) ? $options['limit'] : 20);
            $offset = $listRows * ($page - 1);
            $options['limit'] = $offset.','.$listRows;
        }

        return $this->parseSql($this->selectSql, $options);
    }

    /**
     * 替换 SQL 语句中表达式.
     */
    public function parseSql(string $sql, array $options = []): string
    {
        return str_replace(
            ['%FORCE_MASTER%', '%TABLE%', '%DISTINCT%', '%FIELD%', '%JOIN%', '%WHERE%', '%GROUP%', '%HAVING%', '%ORDER%', '%LIMIT%', '%UNION%', '%LOCK%', '%COMMENT%', '%FORCE%'],
            [
                $this->parseForceMaster(!empty($options['force_master'])),
                $this->parseTable($options['table']),
                $this->parseDistinct($options['distinct'] ?? false),
                $this->parseField(!empty($options['field']) ? $options['field'] : '*'),
                $this->parseJoin(!empty($options['join']) ? $options['join'] : ''),
                $this->parseWhere(!empty($options['where']) ? $options['where'] : ''),
                $this->parseGroup(!empty($options['group']) ? $options['group'] : ''),
                $this->parseHaving(!empty($options['having']) ? $options['having'] : ''),
                $this->parseOrder(!empty($options['order']) ? $options['order'] : ''),
                $this->parseLimit(!empty($options['limit']) ? $options['limit'] : ''),
                $this->parseUnion(!empty($options['union']) ? $options['union'] : ''),
                $this->parseLock($options['lock'] ?? false),
                $this->parseComment(!empty($options['comment']) ? $options['comment'] : ''),
                $this->parseForce(!empty($options['force']) ? $options['force'] : ''),
            ],
            $sql
        );
    }

    /**
     * 更新记录.
     */
    public function update(array $data, array $options): int
    {
        $table = $this->parseTable($options['table']);
        $sql = 'UPDATE '.$table.$this->parseSet($data);
        if (strpos($table, ',')) {// 多表更新支持JOIN操作
            $sql .= $this->parseJoin(!empty($options['join']) ? $options['join'] : '');
        }
        $sql .= $this->parseWhere(!empty($options['where']) ? $options['where'] : '');
        if (!strpos($table, ',')) {
            //  单表更新支持 order 和 limit
            $sql .= $this->parseOrder(!empty($options['order']) ? $options['order'] : '')
                .$this->parseLimit(!empty($options['limit']) ? $options['limit'] : '');
        }
        $sql .= $this->parseComment(!empty($options['comment']) ? $options['comment'] : '');

        return $this->execute($sql);
    }

    /**
     * 删除记录.
     */
    public function delete(array $options = []): int
    {
        $table = $this->parseTable($options['table']);
        $sql = 'DELETE FROM '.$table;
        if (strpos($table, ',')) {// 多表删除支持 USING 和 JOIN 操作
            if (!empty($options['using'])) {
                $sql .= ' USING '.$this->parseTable($options['using']).' ';
            }
            $sql .= $this->parseJoin(!empty($options['join']) ? $options['join'] : '');
        }
        $sql .= $this->parseWhere(!empty($options['where']) ? $options['where'] : '');
        if (!strpos($table, ',')) {
            // 单表删除支持order和limit
            $sql .= $this->parseOrder(!empty($options['order']) ? $options['order'] : '')
                .$this->parseLimit(!empty($options['limit']) ? $options['limit'] : '');
        }
        $sql .= $this->parseComment(!empty($options['comment']) ? $options['comment'] : '');

        return $this->execute($sql);
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
    public function select(array $options = []): string|array
    {
        $sql = $this->buildSelectSql($options);

        return $this->query($sql, $options['cache'] ?? []);
    }

    public function buildSelectSqlForSelect(array $options = []): string
    {
        $sql = $this->buildSelectSql($options);
        $this->parseQuerySql($sql);

        return $this->queryStr;
    }

    /**
     * 执行查询返回数据集.
     */
    public function query(string $str, array $cacheOptions = []): array
    {
        $this->parseQuerySql($str);

        $result = $this->entity::select()
            ->query(
                $this->queryStr,
                [],
                false,
                $cacheOptions['key'] ?? null,
                $cacheOptions['expire'] ?? null,
                $cacheOptions['cache'] ?? null,
            )
        ;
        if (\is_array($result)) {
            foreach ($result as &$v) {
                $v = (array) $v;
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

    /**
     * 字段和表名处理.
     *
     * @param mixed $key
     */
    protected function parseKey(&$key): string
    {
        $key = trim($key);
        if (!is_numeric($key) && !preg_match('/[,\'\"*()`.\s]/', $key)) {
            $key = '`'.$key.'`';
        }

        return $key;
    }

    /**
     * value 分析.
     */
    protected function parseValue(mixed $value): mixed
    {
        if (\is_string($value)) {
            $value = str_starts_with($value, ':') && \in_array($value, array_keys($this->bind), true) ? $this->escapeString($value) : '\''.$this->escapeString($value).'\'';
        } elseif (isset($value[0]) && \is_string($value[0]) && 'exp' === strtolower($value[0])) {
            $value = $this->escapeString($value[1]);
        } elseif (\is_array($value)) {
            $value = array_map([$this, 'parseValue'], $value);
        } elseif (\is_bool($value)) {
            $value = $value ? '1' : '0';
        } elseif (null === $value) {
            $value = 'null';
        }

        return $value;
    }

    /**
     * 参数绑定.
     *
     * @param mixed $name
     * @param mixed $value
     */
    protected function bindParam($name, $value): void
    {
        $this->bind[':'.$name] = $value;
    }

    /**
     * table 分析.
     */
    protected function parseTable(array|string $tables): string
    {
        if (\is_array($tables)) {// 支持别名定义
            $array = [];
            foreach ($tables as $table => $alias) {
                if (!is_numeric($table)) {
                    $array[] = $this->parseKey($table).' '.$this->parseKey($alias);
                } else {
                    $array[] = $this->parseKey($alias);
                }
            }
            $tables = $array;
        } elseif (\is_string($tables)) {
            $tables = explode(',', $tables);
            array_walk($tables, [&$this, 'parseKey']);
        }

        return implode(',', $tables);
    }

    /**
     * ON DUPLICATE KEY UPDATE 分析.
     */
    protected function parseDuplicate(mixed $duplicate): string
    {
        // 布尔值或空则返回空字符串
        if (\is_bool($duplicate) || empty($duplicate)) {
            return '';
        }

        if (\is_string($duplicate)) {
            // field1,field2 转数组
            $duplicate = explode(',', $duplicate);
        } elseif (\is_object($duplicate)) {
            // 对象转数组
            $duplicate = get_class_vars($duplicate);
        }
        $updates = [];
        foreach ((array) $duplicate as $key => $val) {
            if (is_numeric($key)) {
                // array('field1', 'field2', 'field3') 解析为 ON DUPLICATE KEY UPDATE field1=VALUES(field1), field2=VALUES(field2), field3=VALUES(field3)
                $updates[] = $this->parseKey($val).'=VALUES('.$this->parseKey($val).')';
            } else {
                if (\is_scalar($val)) { // 兼容标量传值方式
                    $val = ['value', $val];
                }
                if (!isset($val[1])) {
                    continue;
                }

                switch ($val[0]) {
                    case 'exp': // 表达式
                        $updates[] = $this->parseKey($key)."=({$val[1]})";

                        break;

                    case 'value': // 值
                    default:
                        $name = \count($this->bind);
                        $updates[] = $this->parseKey($key).'=:'.$name;
                        $this->bindParam($name, $val[1]);

                        break;
                }
            }
        }

        if (empty($updates)) {
            return '';
        }

        return ' ON DUPLICATE KEY UPDATE '.implode(', ', $updates);
    }

    /**
     * comment 分析.
     */
    protected function parseComment(string $comment): string
    {
        return !empty($comment) ? '/*'.$comment.'*/' : '';
    }

    protected function parseForceMaster(bool $forceMaster): string
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
    protected function parseField(string|array|bool $fields): string
    {
        if (\is_string($fields) && '' !== $fields) {
            $fields = explode(',', $fields);
        }

        if (!\is_array($fields)) {
            return '*';
        }

        // 完善数组方式传字段名的支持
        // 支持 'field1'=>'field2' 这样的字段别名定义
        $array = [];
        foreach ($fields as $key => $field) {
            if (!is_numeric($key)) {
                $array[] = $this->parseKey($key).' AS '.$this->parseKey($field);
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
            $joinStr = ' '.implode(' ', $join).' ';
        }

        return $joinStr;
    }

    /**
     * where 分析.
     */
    protected function parseWhere(mixed $where): string
    {
        $whereStr = '';
        if (\is_string($where)) {
            // 直接使用字符串条件
            $whereStr = $where;
        } else { // 使用数组表达式
            $operate = isset($where['_logic']) ? strtoupper($where['_logic']) : '';
            if (\in_array($operate, ['AND', 'OR', 'XOR'], true)) {
                // 定义逻辑运算规则 例如 OR XOR AND NOT
                $operate = ' '.$operate.' ';
                unset($where['_logic']);
            } else {
                // 默认进行 AND 运算
                $operate = ' AND ';
            }
            foreach ($where as $key => $val) {
                if (is_numeric($key)) {
                    $key = '_complex';
                }
                if (str_starts_with($key, '_')) {
                    // 解析特殊条件表达式
                    $whereStr .= $this->parseThinkWhere($key, $val);
                } else {
                    // 多条件支持
                    $multi = \is_array($val) && isset($val['_multi']);
                    $key = trim($key);
                    if (strpos($key, '|')) { // 支持 name|title|nickname 方式定义查询字段
                        $array = explode('|', $key);
                        $str = [];
                        foreach ($array as $m => $k) {
                            $v = $multi ? $val[$m] : $val;
                            $str[] = $this->parseWhereItem($this->parseKey($k), $v);
                        }
                        $whereStr .= '( '.implode(' OR ', $str).' )';
                    } elseif (strpos($key, '&')) {
                        $array = explode('&', $key);
                        $str = [];
                        foreach ($array as $m => $k) {
                            $v = $multi ? $val[$m] : $val;
                            $str[] = '('.$this->parseWhereItem($this->parseKey($k), $v).')';
                        }
                        $whereStr .= '( '.implode(' AND ', $str).' )';
                    } else {
                        $whereStr .= $this->parseWhereItem($this->parseKey($key), $val);
                    }
                }
                $whereStr .= $operate;
            }
            $whereStr = substr($whereStr, 0, -\strlen($operate));
        }

        return empty($whereStr) ? '' : ' WHERE '.$whereStr;
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
                    $op = ' '.strtoupper($where['_logic']).' ';
                    unset($where['_logic']);
                } else {
                    $op = ' AND ';
                }
                $array = [];
                foreach ($where as $field => $data) {
                    $array[] = $this->parseKey($field).' = '.$this->parseValue($data);
                }
                $whereStr = implode($op, $array);

                break;
        }

        return '( '.$whereStr.' )';
    }

    /**
     * @throws \Exception
     */
    protected function parseWhereItem(string $key, mixed $val): string
    {
        $whereStr = '';
        if (\is_array($val)) {
            if (\is_string($val[0])) {
                $exp = strtolower($val[0]);
                if (preg_match('/^(eq|neq|gt|egt|lt|elt)$/', $exp)) { // 比较运算
                    $whereStr .= $key.' '.$this->exp[$exp].' '.$this->parseValue($val[1]);
                } elseif (preg_match('/^(notlike|like)$/', $exp)) {// 模糊查找
                    if (\is_array($val[1])) {
                        $likeLogic = isset($val[2]) ? strtoupper($val[2]) : 'OR';
                        if (\in_array($likeLogic, ['AND', 'OR', 'XOR'], true)) {
                            $like = [];
                            foreach ($val[1] as $item) {
                                $like[] = $key.' '.$this->exp[$exp].' '.$this->parseValue($item);
                            }
                            $whereStr .= '('.implode(' '.$likeLogic.' ', $like).')';
                        }
                    } else {
                        $whereStr .= $key.' '.$this->exp[$exp].' '.$this->parseValue($val[1]);
                    }
                } elseif ('bind' === $exp) { // 使用表达式
                    $whereStr .= $key.' = :'.$val[1];
                } elseif ('exp' === $exp) { // 使用表达式
                    $whereStr .= $key.' '.$val[1];
                } elseif (preg_match('/^(notin|not in|in)$/', $exp)) { // IN 运算
                    if (isset($val[2]) && 'exp' === $val[2]) {
                        $whereStr .= $key.' '.$this->exp[$exp].' '.$val[1];
                    } else {
                        if (\is_string($val[1])) {
                            $val[1] = explode(',', $val[1]);
                        }
                        $zone = implode(',', $this->parseValue($val[1]));
                        $whereStr .= $key.' '.$this->exp[$exp].' ('.$zone.')';
                    }
                } elseif (preg_match('/^(notbetween|not between|between)$/', $exp)) { // BETWEEN运算
                    $data = \is_string($val[1]) ? explode(',', $val[1]) : $val[1];
                    $whereStr .= $key.' '.$this->exp[$exp].' '.$this->parseValue($data[0]).' AND '.$this->parseValue($data[1]);
                } else {
                    throw new \Exception(sprintf('Where express error:%s.', $val[0]));
                }
            } else {
                $count = \count($val);
                $rule = isset($val[$count - 1]) ? (\is_array($val[$count - 1]) ? strtoupper($val[$count - 1][0]) : strtoupper($val[$count - 1])) : '';
                if (\in_array($rule, ['AND', 'OR', 'XOR'], true)) {
                    $count = $count - 1;
                } else {
                    $rule = 'AND';
                }
                for ($i = 0; $i < $count; ++$i) {
                    $data = \is_array($val[$i]) ? $val[$i][1] : $val[$i];
                    if ('exp' === strtolower($val[$i][0])) {
                        $whereStr .= $key.' '.$data.' '.$rule.' ';
                    } else {
                        $whereStr .= $this->parseWhereItem($key, $val[$i]).' '.$rule.' ';
                    }
                }
                $whereStr = '( '.substr($whereStr, 0, -4).' )';
            }
        } else {
            $whereStr .= $key.' = '.$this->parseValue($val);
        }

        return $whereStr;
    }

    /**
     * group 分析.
     */
    protected function parseGroup(string $group): string
    {
        return !empty($group) ? ' GROUP BY '.$group : '';
    }

    /**
     * having 分析.
     */
    protected function parseHaving(string $having): string
    {
        return !empty($having) ? ' HAVING '.$having : '';
    }

    /**
     * order 分析.
     */
    protected function parseOrder(array|string $order): string
    {
        if (\is_array($order)) {
            $array = [];
            foreach ($order as $key => $val) {
                if (is_numeric($key)) {
                    $array[] = $this->parseKey($val);
                } else {
                    $array[] = $this->parseKey($key).' '.$val;
                }
            }
            $order = implode(',', $array);
        }

        return !empty($order) ? ' ORDER BY '.$order : '';
    }

    /**
     * limit 分析.
     */
    protected function parseLimit(int|string $limit): string
    {
        return !empty($limit) ? ' LIMIT '.$limit.' ' : '';
    }

    /**
     * union 分析.
     */
    protected function parseUnion(array|string $union): string
    {
        if (empty($union)) {
            return '';
        }
        if (isset($union['_all'])) {
            $str = 'UNION ALL ';
            unset($union['_all']);
        } else {
            $str = 'UNION ';
        }
        $sql = [];
        foreach ($union as $u) {
            $sql[] = $str.(\is_array($u) ? $this->buildSelectSql($u) : $u);
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

        if (\is_array($index)) {
            $index = implode(',', $index);
        }

        return sprintf(' FORCE INDEX ( %s ) ', $index);
    }

    /**
     * set 分析.
     */
    protected function parseSet(array $data): string
    {
        $set = [];
        foreach ($data as $key => $val) {
            if (\is_array($val) && 'exp' === $val[0]) {
                $set[] = $this->parseKey($key).'='.$val[1];
            } elseif (null === $val) {
                $set[] = $this->parseKey($key).'=NULL';
            } elseif (\is_scalar($val)) {// 过滤非标量数据
                if (\is_string($val) && str_starts_with($val, ':') && \in_array($val, array_keys($this->bind), true)) {
                    $set[] = $this->parseKey($key).'='.$this->escapeString($val);
                } else {
                    $name = \count($this->bind);
                    $set[] = $this->parseKey($key).'=:'.$name;
                    $this->bindParam($name, $val);
                }
            }
        }

        return ' SET '.implode(',', $set);
    }

    protected function parseQuerySql(string $str): void
    {
        $this->queryStr = $str;
        if (!empty($this->bind)) {
            $that = $this;
            $this->queryStr = strtr($this->queryStr, array_map(function ($val) use ($that) {
                return '\''.$that->escapeString($val).'\'';
            }, $this->bind));
        }
    }
}
