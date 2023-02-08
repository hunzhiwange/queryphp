<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 满减活动.
 */
class CartItemFullDiscountPromotionEntity extends CartItemPromotionEntity
{
    /**
     * 优惠抵扣前金额.
     */
    public array $activePurchaseTotalPriceDetail = [];

    /**
     * 优惠抵扣后金额.
     */
    public array $activePurchaseTotalPriceDetailAfter = [];

    /**
     * 是否需要凑单.
     */
    public bool $needChouDan = false;

    /**
     * 凑单消息格式化消息.
     */
    public string $needChouDanMessage = '';

    /**
     * 选中的商品总成交价.
     */
    public float $activePurchaseTotalPrice = 0;

    /**
     * 优惠总价.
     */
    public float $allFavorableTotalPrice = 0;

    /**
     * 商品分摊结果.
     */
    public array $priceAllocationResult = [];

    /**
     * 满足门槛.
     */
    public float $meetThreshold = 0;

    /**
     * 活动类型.
     */
    public CartItemPromotionTypeEnum $promotionType = CartItemPromotionTypeEnum::FULL_DISCOUNT;

    public function calculatePrice(): void
    {
        if (!$this->cartItems->count()) {
            return;
        }

        $this->calculatePriceAllocationResult();
    }

    /**
     * 活动商品价格分摊.
     */
    public function calculatePriceAllocationResult(): array
    {
        if (!$this->cartItems->count()) {
            return [];
        }

        $this->getActivePurchaseTotalPrice();

        if (!$this->shouldMeetThreshold()) {
            $this->needChouDan = true;
            $this->needChouDanMessage = sprintf(
                '已经购买金额 %.2f 元，再购 %.2f 元可减少 %.2f 元',
                $this->activePurchaseTotalPrice,
                bcsub_compatibility($this->meetThreshold, $this->activePurchaseTotalPrice),
                $this->allFavorableTotalPrice
            );

            return [];
        }

        $this->needChouDan = false;
        $this->needChouDanMessage = '';

        $this->activePurchaseTotalPriceDetailAfter = $this->activePurchaseTotalPriceDetail;
        $this->priceAllocationResult = CalculatePriceAllocation::handle($this->activePurchaseTotalPriceDetailAfter, $this->allFavorableTotalPrice);

        /** @var CartItemEntity $cartItem */
        foreach ($this->cartItems as $cartItem) {
            $cartItem->price->setFavorableTotalPrice($this->promotionId, $this->discount($cartItem), random_int(100, 500));
        }

        return $this->priceAllocationResult;
    }

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
