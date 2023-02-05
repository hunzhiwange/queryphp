<?php

declare(strict_types=1);

namespace App\Domain\Validate\Support;

use App\Domain\Entity\StatusEnum;
use App\Domain\Validate\IValidator;

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
                ['in', StatusEnum::values()],
            ],
        ];
    }
}
