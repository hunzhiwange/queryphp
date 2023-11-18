<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use Leevel\Database\Ddd\Entity;

trait ParseEntityClass
{
    protected function parseEntityClass(string $entityClass): string
    {
        $app = 'base';
        if (str_contains($entityClass, ':')) {
            // 第一步解析出应用
            $colonPos = (int) strpos($entityClass, ':');
            $app = substr($entityClass, 0, $colonPos);
            $entityClass = substr($entityClass, $colonPos + 1);

            // 剩余的路径为目录，暂时不支持
            // @todo 移除目录的设计
            if (str_contains($entityClass, ':')) {
                $entityClass = implode('\\', array_map(fn ($v) => ucfirst($v), explode(':', $entityClass)));
            }
        }

        if (str_contains($entityClass, '_')) {
            $entityClass = implode('', array_map(fn ($v) => ucfirst($v), explode('_', $entityClass)));
        }

        $app = ucfirst($app);
        $entityClass = "App\\{$app}\\Entity\\".ucfirst($entityClass);

        if (!class_exists($entityClass)) {
            throw new \Exception(sprintf('Entity %s is not exists.', $entityClass));
        }

        if (!is_subclass_of($entityClass, Entity::class)) {
            throw new \InvalidArgumentException(sprintf('Entity %s must be subclass of %s.', $entityClass, Entity::class));
        }

        return $entityClass;
    }

    protected function entityClassName(string $entityClass): string
    {
        return get_entity_class_name($entityClass);
    }
}
