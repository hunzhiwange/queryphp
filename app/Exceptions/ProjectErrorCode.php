<?php

declare(strict_types=1);

namespace App\Exceptions;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 项目业务错误码.
 */
enum ProjectErrorCode: int
{
    use Enum;

    #[Msg('项目收藏保存参数错误')]
    case PROJECT_USER_FAVOR_STORE_INVALID_ARGUMENT = 1000050001;

    #[Msg('你已经收藏过该项目')]
    case PROJECT_USER_FAVOR_ALREADY_EXIST = 1000050002;

    #[Msg('项目收藏取消参数错误')]
    case PROJECT_USER_FAVOR_CANCEL_INVALID_ARGUMENT = 1000050003;

    #[Msg('你尚未收藏过该项目')]
    case PROJECT_USER_FAVOR_NOT_EXIST = 1000050004;

    #[Msg('你尚未加入该项目')]
    case PROJECT_USER_MEMBER_NOT_EXIST = 1000050005;

    #[Msg('你不是该项目的管理')]
    case PROJECT_USER_MEMBER_IS_NOT_ADMINISTRATOR = 1000050006;

    #[Msg('你已经是该项目的管理')]
    case PROJECT_USER_MEMBER_ALREADY_ADMINISTRATOR = 1000050007;

    #[Msg('待新增的所有用户已经是项目的成员')]
    case PROJECT_USER_MEMBER_TO_BE_ADDED_ALREADY_EXIST = 1000050008;

    #[Msg('项目版本保存参数错误')]
    case PROJECT_RELEASE_STORE_INVALID_ARGUMENT = 1000050009;

    #[Msg('项目任务不存在')]
    case PROJECT_ISSUE_NOT_EXIST = 1000050013;

    #[Msg('项目分类ID不能为空')]
    case PROJECT_LABEL_SORT_PROJECT_LABEL_IDS_IS_EMPTY = 1000050014;

    #[Msg('项目分类ID存在相同的数据')]
    case PROJECT_LABEL_SORT_PROJECT_LABEL_IDS_EXISTS_SAME_ID = 1000050015;

    #[Msg('项目任务ID不能和目标任务ID相同')]
    case PROJECT_ISSUE_TASK_ID_CANNOT_BE_THE_SAME_AS_THE_TARGET_TASK_ID = 1000050016;

    #[Msg('项目目标任务分类和提交的任务分类不一致')]
    case PROJECT_ISSUE_TASK_LABEL_MUST_BE_THE_SAME_AS_THE_SUBMITTED_LABEL = 1000050017;
}
