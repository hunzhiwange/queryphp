<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Support\Dto;

/**
 * 用户修改密码参数.
 */
class ChangePasswordParams extends Dto
{
    public int $id;

    public string $oldPwd;

    public string $newPwd;

    public string $confirmPwd;
}
