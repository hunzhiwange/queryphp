<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use Leevel\Support\Dto;

class DestroyParams extends Dto
{
    public int $id;
}
