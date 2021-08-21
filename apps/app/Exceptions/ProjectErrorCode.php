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
}
