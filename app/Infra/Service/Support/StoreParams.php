<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use App\Infra\Dto\ParamsDto;
use Leevel\Validate\UniqueRule;

/**
 * 通用保存参数.
 */
class StoreParams extends ParamsDto
{
    public string $validatorScene = 'store';

    /**
     * 实体自动保存.
     */
    public bool $entityAutoFlush = true;

    /**
     * {@inheritDoc}
     */
    protected function validatorArgs(): array
    {
        $uniqueRule = UniqueRule::rule(
            $this->entityClass,
        );

        return [$uniqueRule];
    }
}
