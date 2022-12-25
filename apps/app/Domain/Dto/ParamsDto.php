<?php

declare(strict_types=1);

namespace App\Domain\Dto;

use App\Domain\Validate\ValidateParams;
use Leevel\Support\Dto;
use Leevel;

class ParamsDto extends Dto
{
    use ValidateParams;

    protected string $validatorClass = '';

    protected string $validatorScene = 'all';

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $this->beforeValidate();

        if ($this->validatorClass) {
            $validatorClass = $this->validatorClass;
            $validator = Leevel::make($validatorClass, $this->validatorClassArgs());

            $this->baseValidate(
                $validator,
                $this->validatorScene,
            );
        }

        $this->afterValidate();
    }

    /**
     * 验证前.
     */
    protected function beforeValidate(): void
    {
    }

    /**
     * 验证后.
     */
    protected function afterValidate(): void
    {
    }

    /**
     * 验证器初始化参数.
     */
    protected function validatorClassArgs(): array
    {
        return [];
    }
}
