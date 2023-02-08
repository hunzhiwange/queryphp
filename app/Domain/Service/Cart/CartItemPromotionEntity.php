<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Dto;

/**
 * 购物车活动项目.
 */
abstract class CartItemPromotionEntity extends Dto
{
    /**
     * 活动标识符.
     *
     * - 活动唯一值，如果同一个活动多种满足规格，可以通过设置不同的活动标识符（活动+规则值）
     */
    public int|string $promotionId = 0;

    /**
     * 活动名字.
     */
    public string $promotionName = '';

    /**
     * 活动包含的商品
     */
    public CartItemEntityCollection $cartItems;

    /**
     * 能否使用优惠.
     */
    public function canApply(): bool
    {
        return true;
    }

    abstract public function discount(CartItemEntity $cartItemEntity): float;

    /**
     * 获取活动商品结算总价和明细.
     */
    public function getActivePurchaseTotalPrice(): float
    {
        $activePurchaseTotalPrice = 0;
        $activePurchaseTotalPriceDetail = [];

        /** @var CartItemEntity $cartItem */
        foreach ($this->cartItems as $cartItem) {
            $tempTotalPrice = $cartItem->getActivePurchaseTotalPrice();
            $activePurchaseTotalPrice = bcadd_compatibility($activePurchaseTotalPrice, $tempTotalPrice);
            $activePurchaseTotalPriceDetail[$cartItem->getHash()] = $tempTotalPrice;
        }
        $this->activePurchaseTotalPriceDetail = $activePurchaseTotalPriceDetail;

        return $this->activePurchaseTotalPrice = $activePurchaseTotalPrice;
    }

    /**
     * 活动商品是否满足门槛.
     */
    public function shouldMeetThreshold(): bool
    {
        return bccomp_compatibility($this->activePurchaseTotalPrice, $this->meetThreshold) >= 0;
    }

    abstract public function calculatePrice(): void;

    abstract public function displayValue(): string;

    /**
     * 是否为满足门槛类型活动.
     */
    public function isMeetThresholdType(): bool
    {
        return CartItemPromotionTypeEnum::SPECIAL !== $this->promotionType;
    }

    /**
     * 活动商品默认值
     */
    protected function cartItemsDefaultValue(): CartItemEntityCollection
    {
        return new CartItemEntityCollection([]);
    }
}
