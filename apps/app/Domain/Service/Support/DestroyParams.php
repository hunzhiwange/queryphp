<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Domain\Validate\ValidateParams;
use Leevel\Support\Dto;
use App\Domain\Validate\Support\Destroy;

class DestroyParams extends Dto
{
    use ValidateParams;

    public int $id;

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $this->baseValidate(new Destroy());
    }
}
