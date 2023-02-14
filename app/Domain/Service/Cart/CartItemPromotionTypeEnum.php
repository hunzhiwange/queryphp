<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 购物车活动类型枚举.
 */
enum CartItemPromotionTypeEnum: int
{
    use Enum;

    #[Msg('普通特价')]
    case SPECIAL = 1;

    #[Msg('特价百分比')]
    case SPECIAL_PERCENTAGE = 2;

    #[Msg('普通满减')]
    case FULL_DISCOUNT = 3;

    #[Msg('满减优惠券')]
    case FULL_DISCOUNT_COUPON = 4;

    #[Msg('第二份半价')]
    case SPECIAL_SECOND_HALF_PRICE = 5;
}
