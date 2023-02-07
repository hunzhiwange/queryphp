<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Dto;

/**
 * 购物车活动项目.
 */
class CartItemPromotionEntity extends Dto
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
     * 活动价.
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

    /**
     * 满足门槛.
     */
    public float $meetThreshold = 0;

    /**
     * 优惠总价.
     */
    public float $allFavorableTotalPrice = 0;

    /**
     * 商品分摊结果.
     */
    public array $priceAllocationResult = [];

    /**
     * 活动包含的商品
     */
    public CartItemEntityCollection $cartItems;

    /**
     * 选中的商品总成交价.
     */
    public float $activePurchaseTotalPrice = 0;

    /**
     * 优惠抵扣后前金额.
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

        return $this->priceAllocationResult = CalculatePriceAllocation::handle($this->activePurchaseTotalPriceDetailAfter, $this->allFavorableTotalPrice);
    }

    /**
     * 是否为满足门槛类型活动.
     */
    public function isMeetThresholdType(): bool
    {
        return CartItemPromotionTypeEnum::FULL_DISCOUNT === $this->promotionType;
    }

    /**
     * 活动商品默认值
     */
    protected function cartItemsDefaultValue(): CartItemEntityCollection
    {
        return new CartItemEntityCollection([]);
    }
}
