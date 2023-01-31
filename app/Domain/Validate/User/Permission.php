<?php

declare(strict_types=1);

namespace App\Domain\Validate\User;

use App\Domain\Entity\User\Permission as UserPermission;
use App\Domain\Entity\User\PermissionStatusEnum;
use App\Domain\Validate\IValidator;

/**
 * 权限验证.
 */
class Permission implements IValidator
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
                'pid',
                'name',
                'num',
                'status',
            ],
            'store' => [
                'pid',
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
        return UserPermission::columnNames();
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
            'pid'    => 'required|type:int|egt:0',
            'name'   => ['required|chinese_alpha_num|max_length:50', $this->uniqueRule],
            'num'    => ['required|alpha_dash', $this->uniqueRule],
            'status' => [
                ['in', PermissionStatusEnum::values()],
            ],
        ];
    }
}
