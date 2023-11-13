<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use App\Infra\Dto\ParamsDto;

class DestroyParams extends ParamsDto
{
    public int $id = 0;

    public string $validatorClass = \App\Infra\Validate\Support\Destroy::class;
}
