<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use App\Infra\Service\Support\Read;
use App\Infra\Service\Support\ReadParams;
use Leevel\Database\Ddd\Entity;

/**
 * API查询语言列表.
 */
class ApiQL
{
    use ParseEntityClass;
    use Read {
        Read::handle as protected parentHandle;
    }

    public function handle(ReadParams $params): array
    {
        $this->setEntityClass($params);

        return $this->parentHandle($params);
    }

    protected function setEntityClass(ReadParams $params): void
    {
        $entityClass = $this->parseEntityClass($params->entityClass);
        $params->entityClass = $entityClass;
        $this->setSearchKeyColumn($entityClass, $params);
    }

    protected function setSearchKeyColumn(string $entity, ReadParams $params): void
    {
        $searchKeyColumn = [];
        foreach ($entity::fields() as $field => $options) {
            $searchKeyColumnValue = $options[Entity::META][ReadParams::SEARCH_KEY_COLUMN] ?? null;
            if (true === $searchKeyColumnValue) {
                $searchKeyColumn[] = $field;
            }
        }

        if ($searchKeyColumn) {
            $params->keyColumn->batchSet($searchKeyColumn);
        }
    }
}
