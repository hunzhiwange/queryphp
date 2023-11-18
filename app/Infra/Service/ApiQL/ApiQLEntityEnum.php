<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use Leevel\Database\Ddd\Entity;

/**
 * API批量查询语言实体枚举.
 */
class ApiQLEntityEnum
{
    use ParseEntityClass;
    use PrepareEnumDescriptionTrait;

    public function handle(ApiQLEntityEnumParams $params): array
    {
        $params->validate();

        $this->setEntityClass($params);

        $entityClass = $params->entityClass;
        $field = $params->prop;
        $entityFields = $entityClass::fields();
        if (empty($entityFields[$field][Entity::ENUM_CLASS])) {
            throw new \Exception(sprintf('The field `%s` of entity `%s` has no enum.', $field, $entityClass));
        }

        $enumClass = $entityFields[$field][Entity::ENUM_CLASS];

        return $this->prepareEnumDescription($enumClass, $params->group);
    }

    protected function setEntityClass(ApiQLEntityEnumParams $params): void
    {
        $params->entityClass = $this->parseEntityClass($params->entityClass);
    }
}
