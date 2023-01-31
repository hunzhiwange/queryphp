<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use Leevel\Support\Dto;

class CodeParams extends Dto
{
    /**
     * 验证码对应的唯一键.
     *
     * - 这里为用户名
     */
    public string $id = '';
}
