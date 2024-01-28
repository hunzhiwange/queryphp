<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use Leevel\Database\Condition;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\Repository;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Page\Page;
use Leevel\Support\Collection;
use Leevel\Support\MapStringMixed;
use Leevel\Support\Str\Camelize;
use Leevel\Support\VectorString;

/**
 * 查询.
 */
trait Read
{
    protected Repository $repository;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(ReadParams $params): array
    {
        return $this->findLists($params, $params->entityClass);
    }

    public function findLists(ReadParams $params, string $entityClass): array
    {
        return $this->findPage($params, $this->w->repository($entityClass));
    }

    /**
     * 预处理.
     */
    private function prepare(array &$data, ReadParams $params): void
    {
        if (!$data) {
            return;
        }

        foreach (array_keys($data[0]) as $field) {
            $prepare = Camelize::handle((string) $field).'Prepare';
            if (method_exists($this, $prepare)) {
                $this->{$prepare}($data, $field, $params);
            }
        }
    }

    /**
     * 查询规约条件.
     */
    private function spec(Select $select, ReadParams $params): void
    {
        $entity = $this->repository->entity();
        $specs = array_merge(['initialization' => true], $params->all(false));

        foreach ($specs as $k => $v) {
            if (null === $v) {
                continue;
            }

            $method = $k.'Spec';
            if (method_exists($this, $method)) {
                $this->{$method}($select, $v, $params);
            } elseif (!$this->isNotWhereConditionField($entity, $k)) {
                $this->parseWhereCondition($select, $k, $v);
            }
        }
    }

    private function whereSpec(Select $select, MapStringMixed $value): void
    {
        $entity = $this->repository->entity();
        foreach ($value->toArray() as $k => $v) {
            if (null === $v || $this->isNotWhereConditionField($entity, $k)) {
                continue;
            }
            $this->parseWhereCondition($select, $k, $v);
        }
    }

    private function isNotWhereConditionField(Entity $entity, string $field): bool
    {
        return \in_array($field, ReadParams::REMAINED_FIELD, true) || !$entity->hasField($field);
    }

    private function parseWhereCondition(Select $select, string $field, array|string|int $condition): void
    {
        if (!\is_array($condition)) {
            $select->where($field, $condition);

            return;
        }

        $searchRawLength = \strlen(ReadParams::SEARCH_RAW);
        foreach ($condition as $key => $value) {
            if (str_starts_with($key, ReadParams::SEARCH_RAW)) {
                $key = substr($key, $searchRawLength);
                $value = Condition::raw('['.$value.']');
                $select->where($field, $key, $value);

                continue;
            }

            $select->where($field, $key, $value);
        }
    }

    /**
     * 初始化规约.
     */
    private function initializationSpec(Select $select, bool $value, ReadParams $params): void
    {
    }

    /**
     * 关键字条件.
     */
    private function keySpec(Select $select, string $value, ReadParams $params): void
    {
        if (!\count($params->keyColumn)) {
            return;
        }

        // 如果你想在Google搜索中组合多个关键词，你可以使用引号来确保搜索结果中包含特定短语或词组
        // `关键词1 关键词2`表示这将返回包含同时包含"关键词1"和"关键词2"的结果
        // 商品名字，商品编号任意一个满足条件同时包含"关键词1"和"关键词2"即可
        // `关键词1 OR 关键词2`或者`关键词1 | 关键词2`表示这将返回包含"关键词1"或"关键词2"的结果。
        // 商品名字，商品编号任意一个满足"关键词1"或"关键词2"即可
        // `关键词1 - 关键词2`或者`关键词1 NOT 关键词2`表示这将返回包含"关键词1"但不包含"关键词2"的结果
        // 商品名字，商品编号任意一个满足"关键词1",但是任意一个字段都不能包含"关键词2"
        $conditions = $this->parseSearchSyntax($value);

        if (!empty($conditions['and'])) {
            $select->where(function (Condition $select) use ($conditions, $params): void {
                // @phpstan-ignore-next-line
                foreach ($params->keyColumn as $v) {
                    $select->orWhere($v, 'like', '%' . implode('%', $conditions['and']) . '%');
                }
            });
        }

        if (!empty($conditions['not'])) {
            // @phpstan-ignore-next-line
            foreach ($params->keyColumn as $v) {
                foreach ($conditions['not'] as $notValue) {
                    $select->where($v, 'not like', '%' . $notValue . '%');
                }
            }
        }

        if (!empty($conditions['or'])) {
            // @phpstan-ignore-next-line
            foreach ($params->keyColumn as $v) {
                foreach ($conditions['or'] as $orValue) {
                    $select->orWhere($v, 'like', '%' . $orValue . '%');
                }
            }
        }
    }

    private function parseSearchSyntax(string $searchString): array
    {
        // 移除多余的空格
        $searchString = preg_replace('/\s+/', ' ', $searchString);

        // 切分搜索字符串
        $keywords = explode(' ', $searchString);

        // 构建查询条件
        $conditions = [
            'and' => [],
            'or' => [],
            'not' => [],
        ];

        $excludeNext = false;
        $orNext = false;
        foreach ($keywords as $keyword) {
            // 检查是否为 OR 操作符
            if (strtolower($keyword) == 'or' || $keyword == '|') {
                $orNext = true;
            } elseif (strtolower($keyword) == 'not' || $keyword == '-') {
                $excludeNext = true;
            } else {
                if ($orNext) {
                    $conditions['or'][] = $keyword;
                } elseif ($excludeNext) {
                    $conditions['not'][] = $keyword;
                }else {
                    if ($keyword[0] == '-') {
                        $conditions['not'][] = substr($keyword, 1);
                    } else {
                        $conditions['and'][] = $keyword;
                    }
                }

                $excludeNext = false;
                $orNext = false;
            }
        }

        return $conditions;
    }

    /**
     * 状态条件.
     */
    private function statusSpec(Select $select, int $value): void
    {
        $select->where('status', $value);
    }

    /**
     * 字段查询条件.
     */
    private function columnSpec(Select $select, VectorString $value): void
    {
        $columns = $value->all();
        $searchRawLength = \strlen(ReadParams::SEARCH_RAW);
        foreach ($columns as &$column) {
            if (str_starts_with($column, ReadParams::SEARCH_RAW)) {
                $column = substr($column, $searchRawLength);
                $column = Condition::raw($column);
            }
        }
        $select->setColumns($columns);
    }

    /**
     * 查询条数限制.
     */
    private function limitSpec(Select $select, array $value): void
    {
        $value = array_map(function ($v) {
            return (int) $v;
        }, $value);
        $select->limit(...$value);
    }

    /**
     * 排序.
     */
    private function orderBySpec(Select $select, mixed $value): void
    {
        $select->orderBy($value);
    }

    /**
     * 分组.
     */
    private function groupBySpec(Select $select, mixed $value): void
    {
        $select->groupBy($value);
    }

    /**
     * 分页查询.
     */
    private function findPage(ReadParams $params, Repository $repository): array
    {
        $this->repository = $repository;

        // 分组
        if (isset($params->groupBy)) {
            $params->orderBy = null;
        }

        if ($params->listOnly) {
            $params->prepareListOnlyLimit();

            $page = [
                'data' => $repository->findAll($this->condition($params)),
                // list-only 也填充一个空的分页数据，满足前端明细页的分页数据格式
                'page' => (new Page(1))->toArray(),
            ];
        } else {
            $params->prepareListPageSize();

            if ($params->listPage) {
                $page = $repository->findPagePrevNext(
                    $params->page,
                    $params->pageSize,
                    $this->condition($params),
                );
            } else {
                $page = $repository->findPage(
                    $params->page,
                    $params->pageSize,
                    $this->condition($params),
                );
            }

            $page = $page->toArray();
        }

        $page['data'] = $this->prepareToArray($page['data']);
        $this->prepare($page['data'], $params);

        return $page;
    }

    private function condition(ReadParams $params): \Closure
    {
        return $this->baseCondition(
            $params,
            $this->conditionCall($params),
        );
    }

    private function conditionCall(ReadParams $params): \Closure
    {
        $relation = $params->relation;
        if (!$relation) {
            return function (): void {};
        }

        $relations = [];
        foreach ($params->relation->toArray() as $relation => $config) {
            $relationScope = null;
            if ($config && (\is_array($config) || \is_string($config))) {
                $relationScope = $config;
            }
            $relations[$relation] = $relationScope;
        }

        return fn (Select $select) => $select->eager($relations);
    }

    private function baseCondition(ReadParams $params, \Closure $call): \Closure
    {
        return function (Select $select) use ($params, $call): void {
            $this->spec($select, $params);
            $call($select);
        };
    }

    /**
     * 转换集合为数组.
     */
    private function prepareToArray(Collection $data): array
    {
        return $data->toArray();
    }
}
