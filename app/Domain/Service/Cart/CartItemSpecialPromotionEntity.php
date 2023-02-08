<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 普通特价活动.
 *
 * - 商品直接指定多少钱
 * - 这里可以根据不同商品实现不同的特价
 */
class CartItemSpecialPromotionEntity extends CartItemPromotionEntity
{
    /**
     * 活动价或者折扣.
     *
     * - 动价指商品在参与营销活动时的售卖价格。
     * - 例如参与“秒杀活动”的商品价格，常常会称之为“秒杀价”，这里的“秒杀价”就是商品参与“秒杀活动”的“活动价”。
     * - 可以简单的将“活动价”认为是“商品参与活动时的销售价”。
     * - 销售价和活动价本质上是一回事，区别就在于是否参加活动引起的叫法不同。
     */
    public float $promotionPrice = 0;

    /**
     * 活动类型.
     */
    public CartItemPromotionTypeEnum $promotionType = CartItemPromotionTypeEnum::SPECIAL;

    public function calculatePrice(): void
    {
        if (!$this->cartItems->count()) {
            return;
        }

        /** @var CartItemEntity $cartItem */
        foreach ($this->cartItems as $cartItem) {
            $cartItem->price->setPromotionPriceArray($this->promotionId, $this->discount($cartItem), random_int(100, 500));
        }
    }

    public function discount(CartItemEntity $cartItemEntity): float
    {
        if (!$this->canApply()) {
            return 0;
        }

        return $this->promotionPrice;
    }

    public function displayValue(): string
    {
        return sprintf('优惠单价 %.2f 元', $this->promotionPrice);
    }
}
