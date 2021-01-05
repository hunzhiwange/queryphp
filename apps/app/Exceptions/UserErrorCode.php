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

    #[msg('账户密码错误')]
    public const ACCOUNT_PASSWORD_ERROR = 1000010001;

    #[msg('账号不存在或者已禁用')]
    public const ACCOUNT_NOT_EXIST_OR_DISABLED = 1000010002;

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

    #[msg('用户保存参数错误')]
    public const USER_STORE_INVALID_ARGUMENT = 1000010009;

    #[msg('用户更新参数错误')]
    public const USER_UPDATE_INVALID_ARGUMENT = 1000010010;

    #[msg('用户更新资料参数错误')]
    public const USER_UPDATE_INFO_INVALID_ARGUMENT = 1000010011;

    #[msg('锁定管理面板参数错误')]
    public const LOCK_ANAGEMENT_PANEL_INVALID_ARGUMENT = 1000010012;

    #[msg('解锁管理面板参数错误')]
    public const UNLOCK_ANAGEMENT_PANEL_INVALID_ARGUMENT = 1000010013;
}
