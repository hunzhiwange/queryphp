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
    public function scenes(): array
    {
        return [
            'all' => [
                'ids',
                'status',
            ],
        ];
    }

    public function names(): array
    {
        return [
            'ids' => 'ID',
            'status' => __('状态值'),
        ];
    }

    public function messages(): array
    {
        return [];
    }

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
