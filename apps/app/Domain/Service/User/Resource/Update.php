<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Validate\Validate;
use Leevel\Validate\UniqueRule;
use App\Domain\Validate\User\Resource as UserResource;

/**
 * 资源更新.
 */
class Update
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UpdateParams $params): array
    {
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): Resource
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): Resource
    {
        $entity = $this->find($params->id);
        $entity->withProps($this->data($params));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Resource
    {
        return $this->w
            ->repository(Resource::class)
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
            Resource::class,
            exceptId:$params->id,
        );

        $validator = Validate::make(new UserResource($uniqueRule), 'update', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::RESOURCE_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }
}
