<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Support\Dto;

/**
 * 用户修改资料参数.
 */
class UpdateInfoParams extends Dto
{
    public int $id;

    public string $email = '';

    public string $mobile = '';
}
