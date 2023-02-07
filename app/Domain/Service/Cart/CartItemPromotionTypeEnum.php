<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Enum;

/**
 * 购物车活动类型枚举.
 */
enum CartItemPromotionTypeEnum: int
{
    use Enum;

    #[msg('特价')]
    case SPECIAL = 1;

    #[msg('满减')]
    case FULL_DISCOUNT = 2;
}
