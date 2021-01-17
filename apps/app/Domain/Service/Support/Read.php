<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use Leevel\Collection\Collection;
use Leevel\Collection\TypedStringArray;
use Leevel\Database\Ddd\Repository;
use Leevel\Database\Ddd\Select;
use function Leevel\Support\Str\camelize;

/**
 * 查询.
 */
trait Read
{
    /**
     * 预处理.
     */
    private function prepare(array &$data, ReadParams $params): void
    {
        if (!$data) {
            return;
        }

        foreach (array_keys($data[0]) as $field) {
            $prepare = func(fn () => camelize((string) $field)).'Prepare';
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
        foreach ($params->all(false) as $k => $v) {
            if (null !== $v) {
                $method = $k.'Spec';
                if (method_exists($this, $method)) {
                    $this->{$method}($select, $v, $params);
                }
            }
        }
    }

    /**
     * 关键字条件.
     */
    private function keySpec(Select $select, mixed $value, ReadParams $params): void
    {
        $value = str_replace(' ', '%', $value);
        $select->where(function ($select) use ($value, $params) {
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

        $data['page'] = $page['page'];
        $entitys = $page['data'];
        $lists = $this->prepareToArray($entitys);
        $this->prepare($lists, $params);
        $data['data'] = $lists;

        return $data;
    }

    /**
     * 转换集合为数组.
     */
    private function prepareToArray(Collection $data): array
    {
        $result = [];
        foreach ($data as $v) {
            $result[] = $this->prepareItem($v);
        }

        return $result;
    }
}
