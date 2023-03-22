<?php

declare(strict_types=1);

namespace App\Service\Search\Entity;

use Leevel\Database\Ddd\Entity;

/**
 * 实体枚举.
 *
 * - 请求如下：api/v1:search?entity:enums[]=Project:ProjectRelease:completed
 */
class Enums
{
    /**
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function handle(string $entityField): array
    {
        $tempEntityField = explode(':', $entityField);
        if (\count($tempEntityField) < 2) {
            throw new \InvalidArgumentException('Entity enums format error.');
        }

        $field = array_pop($tempEntityField);
        $entityClass = 'App\\Domain\\Entity\\'.implode('\\', $tempEntityField);
        if (!class_exists($entityClass)) {
            throw new \Exception(sprintf('Entity `%s` was not found.', $entityClass));
        }

        $entity = new $entityClass();
        if (!$entity instanceof Entity) {
            throw new \Exception(sprintf('Class `%s` is not an entity.', $entityClass));
        }

        $entityFields = $entity::fields();
        if (empty($entityFields[$field][Entity::ENUM_CLASS])) {
            throw new \Exception(sprintf('The field `%s` of entity `%s` has no enum.', $field, $entityClass));
        }

        $enumClass = $entityFields[$field][Entity::ENUM_CLASS];

        return $enumClass::valueDescription();
    }
}
