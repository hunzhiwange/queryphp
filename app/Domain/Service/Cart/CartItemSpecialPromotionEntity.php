<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 特价活动.
 */
class CartItemSpecialPromotionEntity extends CartItemPromotionEntity
{
    /**
     * 活动类型.
     */
    public CartItemPromotionTypeEnum $promotionType = CartItemPromotionTypeEnum::SPECIAL;

    public function discount(CartItemEntity $cartItemEntity): float
    {
        return $this->promotionPrice;
    }
}
