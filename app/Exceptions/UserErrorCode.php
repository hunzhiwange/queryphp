<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 用户业务错误码.
 */
enum UserErrorCode: int
{
    use Enum;

    #[Msg('修改密码参数错误')]
    case CHANGE_PASSWORD_INVALID_ARGUMENT = 1000010000;

    #[Msg('账户密码错误')]
    case ACCOUNT_PASSWORD_ERROR = 1000010001;

    #[Msg('账号不存在或者已禁用')]
    case ACCOUNT_NOT_EXIST_OR_DISABLED = 1000010002;

    #[Msg('权限包含子项不能够被删除')]
    case PERMISSION_CONTAINS_SUB_KEY_AND_CANNOT_BE_DELETED = 1000010004;

    #[Msg('指定用户部分不存在')]
    case SOME_USERS_DOES_NOT_EXIST = 1000010015;
}
