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
 * 权限更新.
 */
class Update
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UpdateParams $params): array
    {
        $this->validateArgs($params);
        $this->validateData($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): Permission
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush();

        return $entity;
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): Permission
    {
        $entity = $this->find($params->id);
        $entity->withProps($this->data($params));

        return $entity;
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

    /**
     * 组装实体数据.
     */
    private function data(UpdateParams $params): array
    {
        return $params->except(['id'])->toArray();
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    private function validateArgs(UpdateParams $params): void
    {
        $uniqueRule = UniqueRule::rule(
            Permission::class,
            exceptId:$params->id,
            additional:['delete_at' => 0]
        );

        $validator = Validate::make(new UserPermission($uniqueRule), 'update', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::PERMISSION_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }

    /**
     * 校验数据.
     */
    private function validateData(UpdateParams $params): void
    {
        if ($params->pid > 0) {
            $this->validatePidData($params->pid);
        }
    }

    private function validatePidData(int $pid)
    {
        $this->find($pid);
    }
}
