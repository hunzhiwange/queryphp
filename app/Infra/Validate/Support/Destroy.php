<?php

declare(strict_types=1);

namespace App\Infra\Validate\Support;

use App\Infra\Validate\IValidator;

/**
 * 删除验证.
 */
class Destroy implements IValidator
{
    /**
     * {@inheritDoc}
     */
    public function scenes(): array
    {
        return [
            'all' => [
                'id',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function names(): array
    {
        return [
            'id' => 'ID',
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
            'id' => 'required',
        ];
    }
}
