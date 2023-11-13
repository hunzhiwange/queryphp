<?php

declare(strict_types=1);

namespace App\User\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 账号子类型枚举.
 */
enum UserSubTypeEnum: int
{
    use Enum;

    #[Msg('通用')]
    case DEFAULT = 0;

    #[Msg('老板')]
    case BOSS = 1;

    #[Msg('内勤')]
    case STAFF = 2;

    #[Msg('业务员')]
    case SALESPERSON = 3;

    public static function employee(): array
    {
        return [
            self::BOSS,
            self::STAFF,
            self::SALESPERSON,
        ];
    }
}
