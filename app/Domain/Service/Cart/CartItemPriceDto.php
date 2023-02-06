<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use App\Domain\Dto\ParamsDto;

/**
 * 购物车价格项目.
 *
 * @see 参考了一下文章 https://blog.csdn.net/y0ungroc/article/details/122586302
 */
class CartItemPriceDto extends ParamsDto
{
    /**
     * 成交价.
     *
     * - 成交价指商品进入订单结算环节的价格。
     * - 成交价是订单结算后续环节的起步，在后续的流程中，订单结算均只使用“成交价”，不再关心销售价和活动价。
     * - 实际上，绝大多数情况下，成交价无非就是取销售价、活动中的某一个值，作为“导购环节”和“阶段环节”的过渡。可以简单理解为，成交价就是在结算时实际使用的价格。
     * - 价格为 0 表示赠品
     */
    public float $purchasePrice = 0;

    /**
     * 结算价.
     *
     * - 商品结算价指买家为一件商品实际支付的金额。
     * - 需付款金额=Σ结算价x数量
     * - 需要注意的一点是，结算价不仅仅用于商品，存在运费的订单，运费单独计算结算价，叫“运费结算价”，只不过运费项目往往只存在1项，就没有必要单独去讲它的结算价了。
     */
    public float $settlementPrice = 0;

    /**
     * 优惠价.
     *
     * - 成交价和结算价之间的差价，可能由多种优惠构成。
     */
    public float $favorablePrice = 0;

    public CartItemPromotionCollection $promotions;

    /**
     * 参考价.
     *
     * - 参考价指商家设置用于和“销售价”形成对比，以便使销售价看起来优惠的价格，这几乎也是参考价的唯一用途了
     * - 参考价常以“划线价”的形式呈现（需要注意，不是所有的划线价都是参考价）。参考价其他常见的叫法还有：门市价、吊牌价、专柜价、指导价等等
     */
    public float $referencePrice = 0;

    /**
     * 销售价.
     *
     * - 销售价指商品在实际参与售卖环节使用的价格。
     * - 有一个简单的判断依据是，如果一个商品在不参与任何营销活动（例如秒杀、满减等），无任何优惠项减免的情况下，不计算运费购买单件要支付的价格就是“销售价”。
     */
    public float $salesPrice = 0;

    /**
     * 产品折扣价.
     *
     * - 商品在不同阶段可以设置折扣。
     * - 折扣可以设置过期时间来控制一下。
     * - 一般来说折扣价比销售价便宜
     */
    public float $productDiscountPrice = 0;

    /**
     * 客户星级折扣价.
     */
    public float $clientStarDiscountPrice = 0;

    /**
     * 客户星级折扣.
     */
    // public float $clientStarDiscount = 1;

    /**
     * 客户折扣价.
     */
    public float $clientDiscountPrice = 0;

    /**
     * 客户折扣.
     */
    // public float $clientDiscount = 1;

    /**
     * 活动价.
     *
     * - 动价指商品在参与营销活动时的售卖价格。
     * - 例如参与“秒杀活动”的商品价格，常常会称之为“秒杀价”，这里的“秒杀价”就是商品参与“秒杀活动”的“活动价”。
     * - 可以简单的将“活动价”认为是“商品参与活动时的销售价”。
     * - 销售价和活动价本质上是一回事，区别就在于是否参加活动引起的叫法不同。
     */
    public float $promotionPrice = 0;

    public function updatePurchaseAndSettlementPrice(): void
    {
        // 寻找大于 0 的最低价
        $allPrice = $this->only([
            'salesPrice',
            'productDiscountPrice',
            'clientStarDiscountPrice',
            'clientDiscountPrice',
            'promotionPrice',
        ])->toArray();
        $this->purchasePrice = min(array_filter($allPrice));
        $this->updateSettlementPrice();
    }

    public function updatePromotionPrice(): void
    {
        $favorablePrice = 0;
        $promotionPrices = [];

        /** @var CartItemPromotionDto $promotion */
        foreach ($this->promotions as $promotion) {
            // 活动分摊价格累加
            if ($promotion->favorablePrice) {
                $favorablePrice += $promotion->favorablePrice;
            }
            // 寻找最小的商品活动价
            if ($promotion->promotionPrice > 0) {
                $promotionPrices[] = $promotion->promotionPrice;
            }
        }
        $this->favorablePrice = $favorablePrice;
        $this->promotionPrice = $promotionPrices ? min($promotionPrices) : 0;
        $this->updateSettlementPrice();
    }

    protected function promotionsDefaultValue(): CartItemPromotionCollection
    {
        return new CartItemPromotionCollection([]);
    }

    protected function updateSettlementPrice(): void
    {
        $this->settlementPrice = $this->purchasePrice - $this->favorablePrice;
    }
}
