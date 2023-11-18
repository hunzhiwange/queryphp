<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use Symfony\Component\HttpFoundation\Response;

/**
 * API查询语言保存任意格式数据.
 */
class ApiQLStoreAny
{
    use ParseEntityClass;
    use ParseEntityMethod;

    public function handle(ApiQLStoreAnyParams $params): array|Response
    {
        $sourceEntityClass = $params->entityClass;
        $this->setEntityClass($params);

        return $this->runEntityMethod($sourceEntityClass, $params);
    }

    protected function setEntityClass(ApiQLStoreAnyParams $params): void
    {
        $params->entityClass = $this->parseEntityClass($params->entityClass);
    }
}
