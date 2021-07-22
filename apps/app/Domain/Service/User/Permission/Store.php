<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 权限保存.
 */
class Store
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(StoreParams $params): array
    {
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(StoreParams $params): Permission
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 创建实体.
     */
    private function entity(StoreParams $params): Permission
    {
        return new Permission($this->data($params));
    }

    /**
     * 组装实体数据.
     */
    private function data(StoreParams $params): array
    {
        return $params->toArray();
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    private function validateArgs(StoreParams $params): void
    {
        $uniqueRule = UniqueRule::rule(
            Permission::class,
            additional:['delete_at' => 0]
        );

        $validator = Validate::make(
            $params->toArray(),
            [
                'name' => 'required|chinese_alpha_num|max_length:50|'.$uniqueRule,
                'num'  => 'required|alpha_dash|'.$uniqueRule,
                'status' => [
                    ['in', Permission::values('status')],
                ],
            ],
            [
                'name' => __('名字'),
                'num'  => __('编号'),
                'status' => __('状态值'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);
            throw new UserBusinessException(UserErrorCode::PERMISSION_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
