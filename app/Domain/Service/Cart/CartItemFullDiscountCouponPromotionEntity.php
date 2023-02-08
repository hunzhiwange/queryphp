<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 满减优惠券活动.
 */
class CartItemFullDiscountCouponPromotionEntity extends CartItemPromotionEntity
{
    /**
     * 活动类型.
     */
    public CartItemPromotionTypeEnum $promotionType = CartItemPromotionTypeEnum::FULL_DISCOUNT_COUPON;

    public function discount(CartItemEntity $cartItemEntity): float
    {
        return $this->priceAllocationResult[$cartItemEntity->getHash()] ?? 0;
    }
}
