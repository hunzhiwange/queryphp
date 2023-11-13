<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use Symfony\Component\HttpFoundation\Response;

/**
 * API查询语言局部更新.
 */
class ApiQLPatch
{
    use ParseEntityClass;
    use ParseEntityMethod;

    public function handle(ApiQLPatchParams $params): array|Response
    {
        $sourceEntityClass = $params->entityClass;
        $this->setEntityClass($params);

        return $this->runEntityMethod($sourceEntityClass, $params);
    }

    protected function setEntityClass(ApiQLPatchParams $params): void
    {
        $params->entityClass = $this->parseEntityClass($params->entityClass);
    }
}
