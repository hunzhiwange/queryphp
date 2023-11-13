<?php

declare(strict_types=1);

namespace App\Infra\Validate\User;

use App\Infra\Validate\IValidator;
use App\User\Entity\User as UserUser;
use Leevel\Validate\IValidator as ValidateIValidator;

/**
 * 用户验证.
 */
class User implements IValidator
{
    public function __construct(private string $uniqueRule = '')
    {
    }

    /**
     * {@inheritDoc}
     */
    public function scenes(): array
    {
        return [
            'unlock' => [
                'id',
                'token',
                'password',
            ],
            'lock' => [
                'token',
            ],
            'change_password' => [
                'id',
                'old_pwd',
                'new_pwd',
                'confirm_pwd',
            ],
            'login' => [
                'name' => 'required|chinese_alpha_num|max_length:50',
                'password',
                'code',
                'remember',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function names(): array
    {
        $baseNames = UserUser::columnNames();

        return array_merge($baseNames, [
            'old_pwd' => __('旧密码'),
            'new_pwd' => __('新密码'),
            'confirm_pwd' => __('确认密码'),
            'code' => __('校验码'),
            'remember' => __('保持登陆'),
        ]);
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
            'id' => 'required|type:int|greater_than:0',
            'name' => ['required|chinese_alpha_num|max_length:50', $this->uniqueRule],
            'num' => ['required|alpha_dash', $this->uniqueRule],
            'password' => 'required|min_length:6,max_length:30',
            'status' => [
                ['in', \App\User\Entity\UserStatusEnum::values()],
            ],
            'email' => 'email|'.ValidateIValidator::OPTIONAL,
            'mobile' => 'mobile|'.ValidateIValidator::OPTIONAL,
            'token' => 'required',
            'old_pwd' => 'required|min_length:6,max_length:30',
            'new_pwd' => 'required|min_length:6,max_length:30',
            'confirm_pwd' => 'required|min_length:6,max_length:30|equal_to:new_pwd',
            'code' => 'required',
            'remember' => 'required',
        ];
    }
}
