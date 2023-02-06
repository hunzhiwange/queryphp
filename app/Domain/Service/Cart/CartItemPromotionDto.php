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
     * 分摊优惠价.
     *
     * - 成交价和结算价之间的差价，可能由多种优惠构成。
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
}
