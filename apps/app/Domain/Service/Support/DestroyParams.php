<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Domain\Dto\ParamsDto;
use App\Domain\Validate\Support\Destroy;

class DestroyParams extends ParamsDto
{
    public int $id;

    protected string $validatorClass = Destroy::class;
}
