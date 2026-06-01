<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use App\Infra\Dto\ParamsDto;
use Leevel\Validate\Helper\Unique;

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

    protected function validatorArgs(): array
    {
        $uniqueRule = Unique::rule(
            $this->entityClass,
        );

        return [$uniqueRule];
    }
}
