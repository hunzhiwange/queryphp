<?php

declare(strict_types=1);

namespace App\User\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 账号类型枚举.
 */
enum UserTypeEnum: int
{
    use Enum;

    #[Msg('员工')]
    case EMPLOYEE = 1;

    #[Msg('客户')]
    case CLIENT = 2;

    #[Msg('供应商')]
    case SUPPLIER = 3;

    #[Msg('联营商')]
    case COLLABORATOR = 4;
}
