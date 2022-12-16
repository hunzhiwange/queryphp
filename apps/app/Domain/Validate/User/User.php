<?php

declare(strict_types=1);

namespace App\Domain\Validate\User;

use App\Domain\Entity\User\User as UserUser;
use App\Domain\Entity\User\UserStatusEnum;
use App\Domain\Validate\IValidator;
use Leevel\Validate\IValidator as ValidateIValidator;

/**
 * 用户验证.
 */
class User implements IValidator
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
                ':num'      => ValidateIValidator::OPTIONAL,
                ':password' => ValidateIValidator::OPTIONAL,
                ':status'   => ValidateIValidator::OPTIONAL,
                'email',
                'mobile',
            ],
            'store' => [
                'name',
                'num',
                'password',
                'status',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function names(): array
    {
        return UserUser::columnNames();
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
            'id'       => 'required|type:int|gt:0',
            'name'     => ['required|chinese_alpha_num|max_length:50', $this->uniqueRule],
            'num'      => ['required|alpha_dash', $this->uniqueRule],
            'password' => 'required|min_length:6,max_length:30',
            'status'   => [
                ['in', UserStatusEnum::values()],
            ],
            'email'  => 'email|'.ValidateIValidator::OPTIONAL,
            'mobile' => 'mobile|'.ValidateIValidator::OPTIONAL,
        ];
    }
}
