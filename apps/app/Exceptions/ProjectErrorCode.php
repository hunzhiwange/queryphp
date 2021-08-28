<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * 项目业务错误码.
 */
final class ProjectErrorCode extends ErrorCode
{
    #[msg('项目收藏保存参数错误')]
    public const PROJECT_USER_FAVOR_STORE_INVALID_ARGUMENT = 1000050001;

    #[msg('你已经收藏过该项目')]
    public const PROJECT_USER_FAVOR_ALREADY_EXIST = 1000050002;

    #[msg('项目收藏取消参数错误')]
    public const PROJECT_USER_FAVOR_CANCEL_INVALID_ARGUMENT = 1000050003;

    #[msg('你尚未收藏过该项目')]
    public const PROJECT_USER_FAVOR_NOT_EXIST = 1000050004;

    #[msg('你尚未加入该项目')]
    public const PROJECT_USER_MEMBER_NOT_EXIST = 1000050005;

    #[msg('你不是该项目的管理')]
    public const PROJECT_USER_MEMBER_IS_NOT_ADMINISTRATOR = 1000050006;

    #[msg('你已经是该项目的管理')]
    public const PROJECT_USER_MEMBER_ALREADY_ADMINISTRATOR = 1000050007;

    #[msg('待新增的所有用户已经是项目的成员')]
    public const PROJECT_USER_MEMBER_TO_BE_ADDED_ALREADY_EXIST = 1000050008;

    #[msg('项目发行版保存参数错误')]
    public const PROJECT_RELEASE_STORE_INVALID_ARGUMENT = 1000050009;

    #[msg('项目发行版更新参数错误')]
    public const PROJECT_RELEASE_UPDATE_INVALID_ARGUMENT = 1000050010;
}
