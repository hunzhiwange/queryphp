<?php

declare(strict_types=1);

namespace App\Service\Search\Entity;

use Exception;
use InvalidArgumentException;
use Leevel\Database\Ddd\Entity;

/**
 * 实体枚举.
 *
 * - 请求如下：api/v1:search?entity:enums[]=Project:ProjectRelease:completed
 */
class Enums
{
    /**
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function handle(string $entityField): array
    {
        $tempEntityField = explode(':', $entityField);
        if (count($tempEntityField) < 2) {
            throw new InvalidArgumentException('Entity enums format error.');
        }

        $field = array_pop($tempEntityField);
        $entity = 'App\\Domain\\Entity\\'.implode('\\', $tempEntityField);
        if (!class_exists($entity)) {
            throw new Exception(sprintf('Entity `%s` was not found.', $entity));
        }

        $entity = new $entity();
        if (!$entity instanceof Entity) {
            throw new Exception(sprintf('Class `%s` is not an entity.', $entity));
        }

        return $entity::valueDescriptionMap($field);
    }
}
