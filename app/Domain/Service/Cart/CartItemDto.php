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
     * 产品.
     */
    public CartItemProductDto $product;

    /**
     * 是否选中.
     */
    public bool $active = true;

    protected ?string $itemHash = null;

    public function __construct(array $data = [], bool $ignoreMissingValues = true)
    {
        parent::__construct($data, $ignoreMissingValues);

        $this->calculatePrice();
    }

    public function generateHash(bool $force = false): string
    {
        if (!$force && $this->itemHash) {
            return $this->itemHash;
        }

        $cartItemArray = [
            'inventory_id' => $this->inventoryId,
        ];

        return $this->itemHash = create_data_id($cartItemArray);
    }

    public function getHash(): string
    {
        return $this->itemHash;
    }

    public function disable(): void
    {
        $this->active = false;
    }

    public function enable(): void
    {
        $this->active = true;
    }

    public function addNumber(float $number): void
    {
        $this->number = bcadd_compatibility($this->number, $number);
    }

    public function subNumber(float $number): void
    {
        if (bccomp_compatibility($this->number, $number) < 1) {
            throw new \Exception('Not enough number');
        }
        $this->number = bcsub_compatibility($this->number, $number);
    }

    public function setPromotionFavorableTotalPrice(int $promotionId, float $favorableTotalPrice): void
    {
        $this->price->promotions->get($promotionId)->favorableTotalPrice = $favorableTotalPrice;
    }

    public function calculatePrice(?CartItemPromotionCollection $cartItemPromotionCollection = null): void
    {
        $this->price->calculatePrice($this, $cartItemPromotionCollection);
    }

    public function getPurchaseTotalPrice(): float
    {
        return bcmul_compatibility($this->number, $this->price->purchasePrice);
    }

    public function getActivePurchaseTotalPrice(): float
    {
        if (!$this->active) {
            return 0;
        }

        return bcmul_compatibility($this->number, $this->price->purchasePrice);
    }

    public function getSettlementTotalPrice(): float
    {
        return bcadd_compatibility(
            bcmul_compatibility($this->number, $this->price->settlementPrice),
            $this->price->settlementRemainTotalPrice
        );
    }

    public function getSettlementRemainTotalPrice(): float
    {
        return $this->price->settlementRemainTotalPrice;
    }

    protected function priceDefaultValue(): CartItemPriceDto
    {
        return new CartItemPriceDto();
    }

    protected function productDefaultValue(): CartItemProductDto
    {
        return new CartItemProductDto();
    }
}
