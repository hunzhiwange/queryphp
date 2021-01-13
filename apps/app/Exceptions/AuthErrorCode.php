<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 认证业务错误码.
 */
final class AuthErrorCode extends ErrorCode
{
    #[msg('验证码错误')]
    public const VERIFICATION_CODE_ERROR = 1000030003;

    #[msg('认证参数错误')]
    public const AUTH_INVALID_ARGUMENT = 1000030004;

    #[msg('你没有权限执行操作')]
    public const AUTH_NO_PERMISSION = 1000030005;

    #[msg('权限认证失败')]
    public const PERMISSION_AUTHENTICATION_FAILED = 1000030006;

    #[msg('管理系统已锁定')]
    public const MANAGEMENT_SYSTEM_LOCKED = 1000030007;
}
