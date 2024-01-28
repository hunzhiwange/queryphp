<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use App\Infra\Dto\ParamsDto;
use App\Infra\Validate\Support\Destroy;

class DestroyParams extends ParamsDto
{
    public int $id = 0;

    public string $validatorClass = Destroy::class;

    /**
     * 实体自动保存.
     */
    public bool $entityAutoFlush = true;
}
