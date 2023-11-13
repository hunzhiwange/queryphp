<?php

declare(strict_types=1);

namespace App\Infra\Dto;

use App\Infra\Validate\ValidateParams;
use Leevel\Support\Arr\Except;
use Leevel\Support\Dto;

class ParamsDto extends Dto
{
    use ValidateParams;

    public const SPECIAL_FIELD = [
        'format',
        'app_key',
        'app_secret',
        'timestamp',
        'signature_method',
        'token',
        'version',
        'signature',
    ];

    public const REMAINED_FIELD = [
        'entity',
        'entity_data',
        'entity_class',
        'entity_method',
        'validator_scene',
        'validator_class',
    ];

    public string $validatorClass = '';

    public string $validatorScene = 'all';

    public string $entityClass = '';

    public array $entityData = [];

    public string $entityMethod = '';

    public static function exceptInput(array $input): array
    {
        return Except::handle($input, array_merge(
            static::SPECIAL_FIELD,
            static::REMAINED_FIELD
        ));
    }

    /**
     * 校验基本参数.
     */
    public function validate(): void
    {
        $this->beforeValidate();

        if ($this->validatorClass) {
            $validatorClass = $this->validatorClass;

            /** @var \App\Infra\Validate\IValidator $validator */
            $validator = \Leevel::make($validatorClass, $this->validatorArgs());

            $this->baseValidate(
                $validator,
                $this->validatorScene,
            );
        }

        $this->afterValidate();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        foreach ([
            'validator_class',
            'entity_class',
            'validator_scene'] as $field) {
            unset($data[$field]);
        }

        return $data;
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
    protected function validatorArgs(): array
    {
        return [];
    }
}
