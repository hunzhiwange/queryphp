<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Service\Support;

use Leevel\Collection\Collection;
use Leevel\Database\Ddd\Repository;
use Leevel\Database\Ddd\Select;
use Leevel\Support\Str\camelize;

/**
 * 查询.
 */
trait Read
{
    /**
     * 预处理.
     */
    private function prepare(array &$data, array $input): void
    {
        if (!$data) {
            return;
        }

        foreach (array_keys($data[0]) as $field) {
            $prepare = f(camelize::class, (string) $field).'Prepare';
            if (method_exists($this, $prepare)) {
                $this->{$prepare}($data, $field, $input);
            }
        }
    }

    /**
     * 查询规约条件.
     */
    private function spec(Select $select, array $input): void
    {
        foreach ($input as $k => $v) {
            if (null !== $v) {
                $method = f(camelize::class, (string) $k).'Spec';
                if (method_exists($this, $method)) {
                    $this->{$method}($select, $v, $input);
                }
            }
        }
    }

    /**
     * 关键字条件.
     *
     * @param mixed $value
     */
    private function keySpec(Select $select, $value, array $meta = []): void
    {
        $value = str_replace(' ', '%', $value);

        $select->where(function ($select) use ($value, $meta) {
            foreach ($meta['key_column'] as $v) {
                $select->orWhere($v, 'like', '%'.$value.'%');
            }
        });
    }

    /**
     * 状态条件.
     *
     * @param mixed $value
     */
    private function statusSpec(Select $select, $value, array $meta = []): void
    {
        $select->where('status', (int) $value);
    }

    /**
     * 字段查询条件.
     *
     * @param mixed $value
     */
    private function columnSpec(Select $select, $value, array $meta = []): void
    {
        $select->setColumns($value);
    }

    /**
     * 查询条数限制.
     *
     * @param mixed $value
     */
    private function limitSpec(Select $select, $value, array $meta = []): void
    {
        $value = array_map(function ($v) {
            return (int) $v;
        }, $value);
        $select->limit(...$value);
    }

    /**
     * 排序.
     *
     * @param mixed $value
     */
    private function orderBySpec(Select $select, $value, array $meta = []): void
    {
        $select->orderBy($value);
    }

    /**
     * 过滤搜索空字符串值.
     */
    private function filterSearchInput(array &$input): void
    {
        $input = $this->filterEmptyStringInput($input);
    }

    /**
     * 分页查询.
     */
    private function findPage(array $input, Repository $repository): array
    {
        $page = $repository->findPage(
            $input['page'],
            $input['size'],
            $this->condition($input),
        );
        $page = $page->toArray();

        $data['page'] = $page['page'];
        $entitys = $page['data'];
        $lists = $this->prepareToArray($entitys);
        $this->prepare($lists, $input);
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
