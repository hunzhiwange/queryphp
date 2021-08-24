<?php

declare(strict_types=1);

namespace App\Domain\Dto\Project;

use Leevel\Collection\TypedDtoArray;
use Leevel\Support\Dto;

/**
 * 项目模板对象.
 */
class Template extends Dto
{
    public ?string $key = null;

    public ?string $title = null;

    public ?TypedDtoArray $data = null;
}
