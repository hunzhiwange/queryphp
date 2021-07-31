<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Domain\Validate\User\Permission as UserPermission;
use App\Domain\Validate\Validate;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
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
        $this->validateData($params);

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

        $validator = Validate::make(new UserPermission($uniqueRule), 'store', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);
            throw new UserBusinessException(UserErrorCode::PERMISSION_STORE_INVALID_ARGUMENT, $e, true);
        }
    }

    /**
     * 校验数据.
     */
    private function validateData(StoreParams $params): void
    {
        if ($params->pid > 0) {
            $this->validatePidData($params->pid);
        }
    }

    private function validatePidData(int $pid)
    {
        $this->find($pid);
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Permission
    {
        return $this->w
            ->repository(Permission::class)
            ->findOrFail($id);
    }
}
