<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 百分比特价活动.
 *
 * - 商品直接根据原件优惠多少比例
 * - 这里可以根据不同商品实现不同的特价
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
