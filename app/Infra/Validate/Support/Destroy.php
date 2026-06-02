<?php

declare(strict_types=1);

namespace App\Infra\Validate\Support;

use App\Infra\Validate\IValidator;

/**
 * 删除验证.
 */
class Destroy implements IValidator
{
    public function scenes(): array
    {
        return [
            'all' => [
                'id',
            ],
        ];
    }

    public function names(): array
    {
        return [
            'id' => 'ID',
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function rules(): array
    {
        return [
            'id' => 'required',
        ];
    }
}
