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
     * 活动优先级.
     *
     * - 活动执行优先级
     */
    public int $priority = 500;

    /**
     * 能否使用优惠.
     */
    public function canApply(): bool
    {
        return true;
    }

    abstract public function discount(CartItemEntity $cartItemEntity): float;

    abstract public function calculatePrice(): void;

    abstract public function displayValue(): string;

    public function priority(): int
    {
        return $this->priority;
    }

    public function addCartItems(CartItemEntity ...$moreCartItemEntity): void
    {
        foreach ($moreCartItemEntity as $v) {
            $this->cartItems->set($v->getHash(), $v);
        }
    }

    public function calculateCartItemsPrice(): void
    {
        /** @var CartItemEntity $cartItem */
        foreach ($this->cartItems as $cartItem) {
            $cartItem->calculatePrice();
        }
    }

    /**
     * 活动商品默认值
     */
    protected function cartItemsDefaultValue(): CartItemEntityCollection
    {
        return new CartItemEntityCollection([]);
    }
}
