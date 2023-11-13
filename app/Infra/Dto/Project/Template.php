<?php

declare(strict_types=1);

namespace App\Infra\Dto\Project;

use Leevel\Support\Dto;
use Leevel\Support\VectorDto;

/**
 * 项目模板对象.
 */
class Template extends Dto
{
    public ?string $key = null;

    public ?string $title = null;

    public ?VectorDto $data = null;
}
