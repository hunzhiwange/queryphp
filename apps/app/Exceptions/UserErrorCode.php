<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 用户业务错误码.
 */
final class UserErrorCode extends ErrorCode
{
    #[msg('修改密码参数错误')]
    public const CHANGE_PASSWORD_INVALID_ARGUMENT = 1000010000;

    #[msg('账户旧密码错误')]
    public const CHANGE_PASSWORD_ACCOUNT_OLD_PASSWORD_ERROR = 1000010001;

    #[msg('账号不存在或者已禁用')]
    public const CHANGE_PASSWORD_ACCOUNT_NOT_EXIST_OR_DISABLED = 1000010002;

    #[msg('权限保存参数错误')]
    public const PERMISSION_STORE_INVALID_ARGUMENT = 1000010003;

    #[msg('权限包含子项不能够被删除')]
    public const PERMISSION_CONTAINS_SUBKEY_AND_CANNOT_BE_DELETED = 1000010004;

    #[msg('权限更新参数错误')]
    public const PERMISSION_UPDATE_INVALID_ARGUMENT = 1000010005;

    #[msg('资源保存参数错误')]
    public const RESOURCE_STORE_INVALID_ARGUMENT = 1000010006;

    #[msg('资源更新参数错误')]
    public const RESOURCE_UPDATE_INVALID_ARGUMENT = 1000010007;

    #[msg('角色保存参数错误')]
    public const ROLE_STORE_INVALID_ARGUMENT = 1000010008;
}
