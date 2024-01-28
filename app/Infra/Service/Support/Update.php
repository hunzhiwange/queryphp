<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use Leevel\Database\Condition;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 通用更新.
 */
trait Update
{
    use ValidateEntity;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function beforeHandle(UpdateParams $params): void
    {
    }

    public function handle(UpdateParams $params): Entity
    {
        $this->beforeHandle($params);

        $params->validate();
        $this->validate($params);

        return $this->save($params);
    }

    private function validate(UpdateParams $params): void
    {
    }

    /**
     * 更新实体.
     */
    private function entity(UpdateParams $params): Entity
    {
        if ($params->entityClass::definedEntityConstant('UPDATE_PROP')) {
            $updateProp = $params->entityClass::entityConstant('UPDATE_PROP');
            $entity = $this->findUpdateEntity($updateProp, $params->entityData[$updateProp], $params);
        } else {
            $primaryId = $params->entityClass::ID;
            $entity = $this->find($params->{$primaryId}, $params);
        }

        // 实体会做一次数据自动转换，比如将请求字符串转换为实体需要的类型
        // 如果不做转换会导致很多校验无法通过
        // 过滤掉null值，不然验证器会无法校验可选规则
        $data = $this->data($params);
        $data = array_filter($data, function ($v) {
            return null !== $v;
        });

        $entity->withProps($data);
        $this->validateEntity($params->entityClass, $entity->except()->toArray(), $params->validatorScene);

        return $entity;
    }

    private function findUpdateEntity(string $updateProp, mixed $updatePropData, UpdateParams $params): Entity
    {
        return $this->w
            ->repository($params->entityClass)
            ->findOrFail(function (Condition $select) use ($updateProp, $updatePropData): void {
                $select->where($updateProp, $updatePropData);
            }, [$params->entityClass::ID])
        ;
    }

    /**
     * 查找实体.
     */
    private function find(int $id, UpdateParams $params): Entity
    {
        return $this->w
            ->repository($params->entityClass)
            ->findOrFail($id, [$params->entityClass::ID])
        ;
    }

    /**
     * 组装实体数据.
     */
    private function data(UpdateParams $params): array
    {
        $primaryId = $params->entityClass::ID;

        return $params->except([$primaryId])->toArray();
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): Entity
    {
        $entity = $this->entity($params);

        // 更新前置操作
        // @phpstan-ignore-next-line
        if (method_exists($entity, 'beforeUpdateEvent')) {
            $entity::event(Entity::BEFORE_UPDATE_EVENT, fn (...$args) => $entity->beforeUpdateEvent(...$args));
        }

        $this->w->create(function() use($entity): void {
            $this->validateEntityDuplicateKey($entity, function () use ($entity): void {
                $entity->update()->flush();
            });
        });

        if ($params->entityAutoFlush) {
            $this->w->flush();
        }

        return $entity;
    }
}
