<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 第二份半价特价活动.
 *
 * - 第二份半价相当于打了 7.5 折扣
 */
class CartItemSpecialSecondHalfPricePromotionEntity extends CartItemSpecialPercentagePromotionEntity
{
    public float $promotionPrice = 0.75;

    /**
     * 活动类型.
     */
    public CartItemPromotionTypeEnum $promotionType = CartItemPromotionTypeEnum::SPECIAL_SECOND_HALF_PRICE;

    public function discount(CartItemEntity $cartItemEntity): float
    {
        if (0 !== $cartItemEntity->number % 2) {
            throw new \Exception('第二件半价必须是2的整倍数。');
        }

        parent::discount($cartItemEntity);
    }

    public function displayValue(): string
    {
        return '第二份半价';
    }
}
