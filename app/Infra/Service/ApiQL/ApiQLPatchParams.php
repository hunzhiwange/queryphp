<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use App\Infra\Dto\ParamsDto;

/**
 * API查询语言局部更新参数.
 */
class ApiQLPatchParams extends ParamsDto
{
    public int $id = 0;
}
