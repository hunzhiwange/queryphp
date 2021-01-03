<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 认证业务错误码.
 */
final class AuthErrorCode extends ErrorCode
{
    #[msg('应用无法找到')]
    public const APP_NOT_FOUND = 1000030000;

    #[msg('账号不存在或者已禁用')]
    public const ACCOUNT_NOT_EXIST_OR_DISABLED = 1000030001;

    #[msg('账户密码错误')]
    public const ACCOUNT_PASSWORD_ERROR = 1000030002;

    #[msg('验证码错误')]
    public const VERIFICATION_CODE_ERROR = 1000030003;

    #[msg('认证参数错误')]
    public const AUTH_INVALID_ARGUMENT = 1000030004;

    #[msg('你没有权限执行操作')]
    public const AUTH_NO_PERMISSION = 1000030005;
}
