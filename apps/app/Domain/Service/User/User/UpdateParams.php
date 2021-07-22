<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use Leevel\Support\Dto;

/**
 * 用户更新参数.
 */
class UpdateParams extends Dto
{
    public int $id;

    public ?string $num = null;

    public ?int $status = null;

    public ?string $password = null;

    public ?string $email = null;

    public ?string $mobile = null;
}
