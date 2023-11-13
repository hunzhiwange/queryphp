<?php

declare(strict_types=1);

namespace App\Infra\Validate\Support;

use App\Infra\Entity\EnabledEnum;
use App\Infra\Validate\IValidator;

/**
 * 状态验证.
 */
class Status implements IValidator
{
    /**
     * {@inheritDoc}
     */
    public function scenes(): array
    {
        return [
            'all' => [
                'ids',
                'status',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function names(): array
    {
        return [
            'ids' => 'ID',
            'status' => __('状态值'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            'ids' => 'required|is_array',
            'status' => [
                ['in', EnabledEnum::values()],
            ],
        ];
    }
}
