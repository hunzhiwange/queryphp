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

    #[msg('普通特价')]
    case SPECIAL = 1;

    #[msg('特价百分比')]
    case SPECIAL_PERCENTAGE = 2;

    #[msg('普通满减')]
    case FULL_DISCOUNT = 3;

    #[msg('满减优惠券')]
    case FULL_DISCOUNT_COUPON = 4;
}
