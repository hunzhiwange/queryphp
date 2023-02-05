<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use App\Domain\Dto\ParamsDto;

class CartItemDto extends ParamsDto
{
    /**
     * 库存 ID.
     *
     * - 库存中包含 SKU 和仓库信息
     */
    public int $inventoryId = 0;

    /**
     * 商品数量.
     */
    public float $number = 0;

    /**
     * 商品单位.
     *
     * - 1 = 小单位
     * - 2 = 中单位
     * - 3 = 大单位
     */
    public int $units = 1;

    /**
     * 商品价格.
     */
    public CartItemPriceDto $price;

    /**
     * 商品总价.
     *
     * - 商品总价分为“全部商品总价”和“部分商品总价”，两者区分仅在于计算时是否将所有商品全都算进去。
     * - 商品总价=Σ成交价x数量
     */
    // public float $totalPrice = 0;

    /**
     * 活动.
     */
    public CartItemPromotionDto $promotion;

    /**
     * 产品.
     */
    public CartItemProductDto $product;

    public function getPurchaseTotalPrice(): float
    {
        return $this->number * $this->price->purchasePrice;
    }

    public function getSettlementTotalPrice(): float
    {
        return $this->number * $this->price->settlementPrice;
    }

    protected function priceDefaultValue(): CartItemPriceDto
    {
        return new CartItemPriceDto();
    }

    protected function promotionDefaultValue(): CartItemPromotionDto
    {
        return new CartItemPromotionDto();
    }

    protected function productDefaultValue(): CartItemProductDto
    {
        return new CartItemProductDto();
    }
}
