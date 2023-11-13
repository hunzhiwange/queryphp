<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use App\Infra\Dto\ParamsDto;

/**
 * API查询语言实体枚举参数.
 */
class ApiQLEntityEnumParams extends ParamsDto
{
    public string $entityClass = '';

    public string $prop = '';

    public string $group = '';
}
