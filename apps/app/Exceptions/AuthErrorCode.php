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

    #[msg('签名校验失败')]
    public const AUTH_SIGNATURE_VERIFY_FAILD = 1000030008;

    #[msg('签名必须')]
    public const AUTH_SIGNATURE_CANNOT_BE_EMPTY = 1000030009;

    #[msg('接口时间必须')]
    public const AUTH_TIMESTAMP_CANNOT_BE_EMPTY = 1000030010;

    #[msg('接口过期')]
    public const AUTH_TIMESTAMP_EXPIRED = 1000030011;

    #[msg('签名方法必须')]
    public const AUTH_SIGNATURE_METHOD_CANNOT_BE_EMPTY = 1000030012;

    #[msg('签名方法不支持')]
    public const AUTH_SIGNATURE_METHOD_NOT_SUPPORT = 1000030013;

    #[msg('接口应用 KEY 必须')]
    public const AUTH_APP_KEY_CANNOT_BE_EMPTY = 1000030014;

    #[msg('接口应用 KEY 已失效')]
    public const AUTH_APP_KEY_INVALID = 1000030015;

    #[msg('接口格式化必须')]
    public const AUTH_FORMAT_CANNOT_BE_EMPTY = 1000030016;

    #[msg('接口格式化不支持')]
    public const AUTH_FORMAT_NOT_SUPPORT = 1000030017;
}
