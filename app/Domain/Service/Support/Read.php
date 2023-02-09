<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use Leevel\Database\Ddd\Repository;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Collection;
use Leevel\Support\Str\Camelize;
use Leevel\Support\TypedStringArray;

/**
 * 查询.
 */
trait Read
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(ReadParams $params): array
    {
        return $this->findLists($params, $this->entityClass);
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
        foreach (array_merge(['initialization' => true], $params->all(false)) as $k => $v) {
            if (null !== $v) {
                $method = $k.'Spec';
                if (method_exists($this, $method)) {
                    $this->{$method}($select, $v, $params);
                }
            }
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
    private function keySpec(Select $select, mixed $value, ReadParams $params): void
    {
        $value = str_replace(' ', '%', $value);
        $select->where(function ($select) use ($value, $params): void {
            foreach ($params->keyColumn as $v) {
                $select->orWhere($v, 'like', '%'.$value.'%');
            }
        });
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
    private function columnSpec(Select $select, TypedStringArray $value): void
    {
        $select->setColumns($value->all());
    }

    /**
     * 查询条数限制.
     */
    private function limitSpec(Select $select, mixed $value): void
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
     * 分页查询.
     */
    private function findPage(ReadParams $params, Repository $repository): array
    {
        $page = $repository->findPage(
            $params->page,
            $params->size,
            $this->condition($params),
        );
        $page = $page->toArray();
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
        return function (): void {};
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
