<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 百分比特价活动.
 */
class CartItemSpecialPercentagePromotionEntity extends CartItemSpecialPromotionEntity
{
    /**
     * 活动类型.
     */
    public CartItemPromotionTypeEnum $promotionType = CartItemPromotionTypeEnum::SPECIAL_PERCENTAGE;

    public function discount(CartItemEntity $cartItemEntity): float
    {
        if (!$this->canApply()) {
            return 0;
        }

        return bcmul_compatibility($cartItemEntity->price->purchasePrice, $this->promotionPrice);
    }

    public function displayValue(): string
    {
        return sprintf('优惠比例 %.2f', bcmul_compatibility($this->promotionPrice, 100)).'%';
    }
}
