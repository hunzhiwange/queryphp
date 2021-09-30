<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use Leevel\Support\Dto;

/**
 * 项目版本更新参数.
 */
class UpdateParams extends Dto
{
    public int $id;

    public ?int $sort = null;

    public ?string $name = null;

    public ?int $status = null;

    public ?int $completed = null;
}
