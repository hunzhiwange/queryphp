<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use App\Infra\Dto\ParamsDto;

/**
 * API查询语言实体结构参数.
 */
class ApiQLEntityStructParams extends ParamsDto
{
    public string $entityClass = '';
}
