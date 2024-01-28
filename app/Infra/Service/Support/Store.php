<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 通用保存.
 */
trait Store
{
    use ValidateEntity;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(StoreParams $params): Entity
    {
        $params->validate();
        $this->validate($params);

        return $this->save($params);
    }

    private function validate(StoreParams $params): void
    {
    }

    /**
     * 保存.
     */
    private function save(StoreParams $params): Entity
    {
        $entity = $this->entity($params);

        // 保存前置操作
        if (method_exists($entity, 'beforeCreateEvent')) {
            $entity::event(Entity::BEFORE_CREATE_EVENT, fn () => $entity->beforeCreateEvent());
        }

        $this->w->create(function() use($entity): void {
            $this->validateEntityDuplicateKey($entity, function () use ($entity): void {
                $entity->create()->flush();
            });
        });

        if ($params->entityAutoFlush) {
            $this->w->flush();
        }

        return $entity;
    }

    /**
     * 创建实体.
     */
    private function entity(StoreParams $params): Entity
    {
        $entityClass = $params->entityClass;

        // 实体会做一次数据自动转换，比如将请求字符串转换为实体需要的类型
        // 如果不做转换会导致很多校验无法通过
        // 过滤掉null值，不然验证器会无法校验可选规则
        $data = $this->data($params);
        $data = inject_snowflake_id($data, $entityClass);
        $data = array_filter($data, function ($v) {
            return null !== $v;
        });

        $entity = $this->newEntity($entityClass, $data);
        $this->validateEntity($entityClass, $entity->except()->toArray(), 'store');

        return $entity;
    }

    /**
     * 组装实体数据.
     */
    private function data(StoreParams $params): array
    {
        return $params->toArray();
    }

    private function newEntity(string $entityClass, array $data): Entity
    {
        if (!is_subclass_of($entityClass, Entity::class)) {
            throw new \Exception(sprintf('Entity %s is not exists.', $entityClass));
        }

        // @var Entity $entity
        return new $entityClass($data);
    }
}
