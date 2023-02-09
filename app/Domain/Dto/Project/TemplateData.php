<?php

declare(strict_types=1);

namespace App\Domain\Dto\Project;

use Leevel\Support\Dto;

/**
 * 项目模板数据对象.
 */
class TemplateData extends Dto
{
    public string $title = '';

    public string $tag = '';

    public string $description = '';
}
