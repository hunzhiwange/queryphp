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

namespace Common\Domain\Service\User\Permission;

use Common\Domain\Entity\User\Permission;
use Common\Infra\Exception\BusinessException;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 权限保存.
 */
class Store
{
    /**
     * 输入数据.
     */
    private array $input;
    private UnitOfWork $w;

    public function __construct(UnitOfWork $w)
    {
        $this->w = $w;
    }

    public function handle(array $input): array
    {
        $this->input = $input;
        $this->validateArgs();

        return $this->save($input)->toArray();
    }

    /**
     * 保存.
     */
    private function save(array $input): Permission
    {
        $this->w
            ->persist($entity = $this->entity($input))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 创建实体.
     */
    private function entity(array $input): Permission
    {
        return new Permission($this->data($input));
    }

    /**
     * 组装实体数据.
     */
    private function data(array $input): array
    {
        $input['pid'] = $this->parseParentId($input['pid']);

        return [
            'pid'        => $input['pid'],
            'name'       => trim($input['name']),
            'num'        => trim($input['num']),
            'status'     => $input['status'],
        ];
    }

    /**
     * 分析父级数据.
     */
    private function parseParentId(array $pid): int
    {
        $p = (int) (array_pop($pid));
        if ($p < 0) {
            $p = 0;
        }

        return $p;
    }

    /**
     * 校验基本参数.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    private function validateArgs(): void
    {
        $validator = Validate::make(
            $this->input,
            [
                'name'          => 'required|chinese_alpha_num|max_length:50',
                'num'           => 'required|alpha_dash|'.UniqueRule::rule(Permission::class, null, null, null, 'delete_at', 0),
            ],
            [
                'name'          => __('名字'),
                'num'           => __('编号'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new BusinessException($e);
        }
    }
}
