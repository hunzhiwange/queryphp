<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use App\Domain\Dto\ParamsDto;

/**
 * 购物车活动项目.
 */
class CartItemPromotionDto extends ParamsDto
{
    /**
     * 活动 ID.
     */
    public int $promotionId = 0;

    /**
     * 活动名字.
     */
    public string $promotionName = '';

    /**
     * 分摊优惠总价.
     *
     * - 可能存在除不尽的问题
     */
    public float $favorableTotalPrice = 0;

    /**
     * 分摊优惠价.
     *
     * - 成交价和结算价之间的差价，可能由多种优惠构成。
     * - 除不尽的时候会存在一个差价
     */
    public float $favorablePrice = 0;

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

    public array $roportionResult = [];

    public CartItemCollection $cartItems;

    public float $activePurchaseTotalPrice = 0;
    public array $activePurchaseTotalPriceDetail = [];
    public array $activePurchaseTotalPriceDetailAfter = [];
    public bool $needChouDan = false;
    public string $needChouDanMessage = '';

    public function getActivePurchaseTotalPrice(): float
    {
        $activePurchaseTotalPrice = 0;
        $activePurchaseTotalPriceDetail = [];

        /** @var CartItemDto $cartItem */
        foreach ($this->cartItems as $cartItem) {
            $tempTotalPrice = $cartItem->getActivePurchaseTotalPrice();
            $activePurchaseTotalPrice = bcadd_compatibility($activePurchaseTotalPrice, $tempTotalPrice);
            $activePurchaseTotalPriceDetail[$cartItem->getHash()] = $tempTotalPrice;
        }
        $this->activePurchaseTotalPriceDetail = $activePurchaseTotalPriceDetail;

        return $this->activePurchaseTotalPrice = $activePurchaseTotalPrice;
    }

    public function shouldMeetThreshold(): bool
    {
        return bccomp_compatibility($this->activePurchaseTotalPrice, $this->meetThreshold) >= 0;
    }

    public function roportionResult(): array
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

        return $this->roportionResult = CalculatePriceProportionHelper::handle($this->activePurchaseTotalPriceDetailAfter, $this->allFavorableTotalPrice);
    }

    public function isMeetThresholdType(): bool
    {
        return CartItemPromotionTypeEnum::FULL_DISCOUNT === $this->promotionType;
    }

    protected function cartItemsDefaultValue(): CartItemCollection
    {
        return new CartItemCollection([]);
    }
}
