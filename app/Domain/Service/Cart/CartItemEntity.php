<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Dto;

class CartItemEntity extends Dto
{
    /**
     * 库存唯一值.
     *
     * - 库存中包含 SKU 和仓库信息
     */
    public int|string $inventoryId = 0;

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
    public CartItemPriceEntity $price;

    /**
     * 产品.
     */
    public CartItemProductEntity $product;

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

    public function calculatePrice(?CartItemPromotionEntityCollection $cartItemPromotionCollection = null): void
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

        return $this->getPurchaseTotalPrice();
    }

    public function getSettlementTotalPrice(): float
    {
        return bcadd_compatibility(
            bcmul_compatibility($this->number, $this->price->settlementPrice),
            $this->price->settlementRemainTotalPrice
        );
    }

    public function getActiveSettlementTotalPrice(): float
    {
        if (!$this->active) {
            return 0;
        }

        return $this->getSettlementTotalPrice();
    }

    public function getSettlementRemainTotalPrice(): float
    {
        return $this->price->settlementRemainTotalPrice;
    }

    public function getActiveSettlementRemainTotalPrice(): float
    {
        if (!$this->active) {
            return 0;
        }

        return $this->getSettlementRemainTotalPrice();
    }

    protected function priceDefaultValue(): CartItemPriceEntity
    {
        return new CartItemPriceEntity();
    }

    protected function productDefaultValue(): CartItemProductEntity
    {
        return new CartItemProductEntity();
    }
}
