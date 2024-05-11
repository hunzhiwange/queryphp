<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Infra\Service\Support\ReadParams;
use Leevel\Support\VectorString;

/**
 * 项目用户列表参数.
 */
class UsersParams extends ReadParams
{
    public ?int $projectId = null;

    public ?string $orderBy = 'id DESC';

    public string $entityClass = \App\Project\Entity\ProjectUser::class;

    protected function columnDefaultValue(): VectorString
    {
        return new VectorString([
            '*',
        ]);
    }

    protected function keyColumnDefaultValue(): VectorString
    {
        return new VectorString([
            'user.id', 'user.name', 'user.num',
        ]);
    }
}
