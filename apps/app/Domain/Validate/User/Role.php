<?php

declare(strict_types=1);

namespace App\Domain\Validate\User;

use App\Domain\Entity\User\Role as UserRole;
use App\Domain\Validate\IValidator;

/**
 * 角色验证.
 */
class Role implements IValidator
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
        return UserRole::columnNames();
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
            'id'     => 'required|type:int|gt:0',
            'name'   => ['required|chinese_alpha_num|max_length:50', $this->uniqueRule],
            'num'    => ['required|alpha_dash', $this->uniqueRule],
            'status' => [
                ['in', UserRole::values('status')],
            ],
        ];
    }
}
