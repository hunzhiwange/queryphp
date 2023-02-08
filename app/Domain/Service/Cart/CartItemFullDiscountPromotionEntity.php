<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 满减活动.
 */
class CartItemFullDiscountPromotionEntity extends CartItemPromotionEntity
{
    /**
     * 活动类型.
     */
    public CartItemPromotionTypeEnum $promotionType = CartItemPromotionTypeEnum::FULL_DISCOUNT;
}
