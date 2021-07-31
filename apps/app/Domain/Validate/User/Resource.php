<?php

declare(strict_types=1);

namespace App\Domain\Validate\User;

use App\Domain\Entity\User\Resource as UserResource;
use App\Domain\Validate\IValidator;

/**
 * 权限验证.
 */
class Resource implements IValidator
{
    public function __construct(private string $uniqueRule)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function scenes(): array
    {
        return [
            'update' => [
                'id',
                'name',
                'num',
                'status',
            ],
            'store' => [
                'name',
                'num',
                'status',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function names(): array
    {
        return UserResource::columnNames();
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
            'id' => 'required|type:int|gt:0',
            'name' => ['required|chinese_alpha_num|max_length:50', $this->uniqueRule],
            'num'  => ['required|alpha_dash', $this->uniqueRule],
            'status' => [
                ['in', UserResource::values('status')],
            ],
        ];
    }
}
