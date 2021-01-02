<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 用户业务错误码.
 */
class UserErrorCode extends ErrorCode
{
    #[msg('修改密码参数错误')]
    const CHANGE_PASSWORD_INVALID_ARGUMENT = 1000000000;

    #[msg('账户旧密码错误')]
    const CHANGE_PASSWORD_ACCOUNT_OLD_PASSWORD_ERROR = 1000000001;

    #[msg('账号不存在或者已禁用')]
    const CHANGE_PASSWORD_ACCOUNT_NOT_EXIST_OR_DISABLED = 1000000002;
}
