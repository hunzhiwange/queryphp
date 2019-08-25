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

use Leevel\Database\Ddd\Select;
use Leevel\Support\Str\camelize;

/**
 * 查询.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.08.19
 *
 * @version 1.0
 */
trait Read
{
    /**
     * 预处理.
     *
     * @param array $data
     * @param array $input
     */
    private function prepare(array &$data, array $input)
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
     *
     * @param \Leevel\Database\Ddd\Select $select
     * @param array                       $input
     */
    private function spec(Select $select, array $input)
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
     * 过滤搜索空值.
     *
     * @param array $input
     */
    private function filterSearchInput(array &$input): void
    {
        $input = array_map(function ($v) {
            if ('' === $v) {
                $v = null;
            }

            return $v;
        }, $input);
    }

    /**
     * 字段查询条件.
     *
     * @param \Leevel\Database\Ddd\Select $select
     * @param mixed                       $value
     * @param array                       $meta
     */
    private function columnSpec(Select $select, $value, array $meta = []): void
    {
        $select->setColumns($value);
    }

    /**
     * 查询条数限制.
     *
     * @param \Leevel\Database\Ddd\Select $select
     * @param mixed                       $value
     * @param array                       $meta
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
     * @param \Leevel\Database\Ddd\Select $select
     * @param mixed                       $value
     * @param array                       $meta
     */
    private function orderBySpec(Select $select, $value, array $meta = []): void
    {
        $select->orderBy($value);
    }
}
