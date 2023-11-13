<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use Leevel\Database\Ddd\Entity;

/**
 * API批量查询语言实体结构.
 */
class ApiQLEntityStruct
{
    use ParseEntityClass;
    use PrepareEnumDescriptionTrait;

    public function handle(ApiQLEntityStructParams $params): array
    {
        $params->validate();
        $this->setEntityClass($params);
        $entityClass = $params->entityClass;
        $fields = $entityClass::fields();

        return $this->prepareEnum($fields);
    }

    protected function setEntityClass(ApiQLEntityStructParams $params): void
    {
        $params->entityClass = $this->parseEntityClass($params->entityClass);
    }

    protected function prepareEnum(array $fields): array
    {
        foreach ($fields as &$field) {
            if (!isset($field[Entity::ENUM_CLASS])) {
                continue;
            }

            $enumClass = $field[Entity::ENUM_CLASS];
            $field['enum_description'] = $this->prepareEnumDescription($enumClass);
        }

        return $fields;
    }
}
