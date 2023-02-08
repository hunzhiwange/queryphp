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

    public function displayValue(): string
    {
        return sprintf('优惠单价 %.2f 元', $this->promotionPrice);
    }
}
