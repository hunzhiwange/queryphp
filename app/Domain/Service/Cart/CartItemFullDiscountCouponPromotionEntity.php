<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 满减优惠券活动.
 */
class CartItemFullDiscountCouponPromotionEntity extends CartItemFullDiscountPromotionEntity
{
    /**
     * 活动类型.
     */
    public CartItemPromotionTypeEnum $promotionType = CartItemPromotionTypeEnum::FULL_DISCOUNT_COUPON;

    public function discount(CartItemEntity $cartItemEntity): float
    {
        if (!$this->canApply()) {
            return 0;
        }

        return $this->priceAllocationResult[$cartItemEntity->getHash()] ?? 0;
    }

    public function displayValue(): string
    {
        return sprintf('优惠总价 %.2f 元', $this->allFavorableTotalPrice);
    }
}
