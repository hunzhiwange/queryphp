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

    public function discount(CartItemEntity $cartItemEntity): float
    {
        return $this->priceAllocationResult[$cartItemEntity->getHash()] ?? 0;
    }

    public function displayValue(): string
    {
        return sprintf('优惠总价 %.2f 元', $this->allFavorableTotalPrice);
    }
}
