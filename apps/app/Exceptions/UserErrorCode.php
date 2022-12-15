<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Support\BaseEnum;

/**
 * 用户业务错误码.
 */
enum UserErrorCode:int
{
    use BaseEnum;

    #[msg('修改密码参数错误')]
    case CHANGE_PASSWORD_INVALID_ARGUMENT = 1000010000;

    #[msg('账户密码错误')]
    case ACCOUNT_PASSWORD_ERROR = 1000010001;

    #[msg('账号不存在或者已禁用')]
    case ACCOUNT_NOT_EXIST_OR_DISABLED = 1000010002;

    #[msg('权限保存参数错误')]
    case PERMISSION_STORE_INVALID_ARGUMENT = 1000010003;

    #[msg('权限包含子项不能够被删除')]
    case PERMISSION_CONTAINS_SUB_KEY_AND_CANNOT_BE_DELETED = 1000010004;

    #[msg('权限更新参数错误')]
    case PERMISSION_UPDATE_INVALID_ARGUMENT = 1000010005;

    #[msg('资源保存参数错误')]
    case RESOURCE_STORE_INVALID_ARGUMENT = 1000010006;

    #[msg('资源更新参数错误')]
    case RESOURCE_UPDATE_INVALID_ARGUMENT = 1000010007;

    #[msg('角色保存参数错误')]
    case ROLE_STORE_INVALID_ARGUMENT = 1000010008;

    #[msg('角色更新参数错误')]
    case ROLE_UPDATE_INVALID_ARGUMENT = 1000010014;

    #[msg('用户保存参数错误')]
    case USER_STORE_INVALID_ARGUMENT = 1000010009;

    #[msg('用户更新参数错误')]
    case USER_UPDATE_INVALID_ARGUMENT = 1000010010;

    #[msg('锁定管理面板参数错误')]
    case LOCK_MANAGEMENT_PANEL_INVALID_ARGUMENT = 1000010012;

    #[msg('解锁管理面板参数错误')]
    case UNLOCK_MANAGEMENT_PANEL_INVALID_ARGUMENT = 1000010013;

    #[msg('指定用户部分不存在')]
    case SOME_USERS_DOES_NOT_EXIST = 1000010015;
}
