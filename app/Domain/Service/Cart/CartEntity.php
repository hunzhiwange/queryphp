<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Dto;

class CartEntity extends Dto
{
    /**
     * 购物车商品
     */
    public CartItemEntityCollection $cartItems;

    /**
     * 购物车活动.
     */
    public CartItemPromotionEntityCollection $promotions;

    /**
     * 新增一项商品到购物车.
     */
    public function addItem(CartItemEntity $cartItem): CartItemEntity
    {
        $itemHash = $cartItem->generateHash();

        if ($this->hasItem($itemHash)) {
            $this->getItem($itemHash)->addNumber($cartItem->number);
        } else {
            $this->cartItems->set($itemHash, $cartItem);
        }

        return $cartItem;
    }

    /**
     * 获取购物车项.
     *
     * @throws \Exception
     */
    public function getItem(string $itemHash): CartItemEntity
    {
        $cartItemEntity = $this->cartItems->get($itemHash);
        if (!$cartItemEntity) {
            throw new \Exception(sprintf('Cart item %s not found', $itemHash));
        }

        return $cartItemEntity;
    }

    /**
     * 是否存在购物车项.
     */
    public function hasItem(string $itemHash): bool
    {
        return $this->cartItems->has($itemHash);
    }

    /**
     * @throws \Exception
     */
    public function increment(string $itemHash, float $step = 1.0): CartItemEntity
    {
        $item = $this->getItem($itemHash);
        $item->addNumber($step);

        return $item;
    }

    public function decrement(string $itemHash, float $step = 1.0): CartItemEntity
    {
        $item = $this->getItem($itemHash);
        if (1 === bccomp_compatibility($item->number, $step)) {
            $item->subNumber($step);

            return $item;
        }

        $this->removeItem($itemHash);

        return $item;
    }

    public function removeItem(string $itemHash): void
    {
        $this->cartItems->remove($itemHash);
    }

    public function emptyCart(): void
    {
        $this->cartItems = $this->cartItemsDefaultValue();
    }

    public function getPurchaseTotalPrice(): float
    {
        $total = 0;
        if (!$this->countItemNumber()) {
            return $total;
        }

        /** @var CartItemEntity $item */
        foreach ($this->cartItems as $item) {
            $total = bcadd_compatibility($total, $item->getPurchaseTotalPrice());
        }

        return $total;
    }

    public function getActivePurchaseTotalPrice(): float
    {
        $total = 0;
        if (!$this->countItemNumberActive()) {
            return $total;
        }

        /** @var CartItemEntity $item */
        foreach ($this->cartItems as $item) {
            if ($item->active) {
                $total = bcadd_compatibility($total, $item->getActivePurchaseTotalPrice());
            }
        }

        return $total;
    }

    public function count(): int
    {
        return $this->cartItems->count();
    }

    public function countActive(): int
    {
        $count = 0;

        /** @var CartItemEntity $item */
        foreach ($this->cartItems as $item) {
            if ($item->active) {
                ++$count;
            }
        }

        return $count;
    }

    public function countItemNumber(): float
    {
        $count = 0;

        /** @var CartItemEntity $item */
        foreach ($this->cartItems as $item) {
            $count = bcadd_compatibility($count, $item->number);
        }

        return $count;
    }

    public function countItemNumberActive(): float
    {
        $count = 0;

        /** @var CartItemEntity $item */
        foreach ($this->cartItems as $item) {
            if ($item->active) {
                $count = bcadd_compatibility($count, $item->number);
            }
        }

        return $count;
    }

    public function addPromotion(CartItemPromotionEntity $coupon, CartItemEntity ...$moreCartItemEntity): void
    {
        $coupon->addCartItems(...$moreCartItemEntity);
        $this->promotions->set($coupon->promotionId, $coupon);
    }

    /**
     * 计算价格
     */
    public function calculatePrice(bool $calculateIndependently = true): void
    {
        $this->clearCartItemsPrice();

        foreach ($this->normalizeSortedPromotions($this->promotions) as $promotion) {
            $promotion->calculatePrice();
            if (!$calculateIndependently) {
                $promotion->calculateCartItemsPrice();
            }
        }

        if ($calculateIndependently) {
            $this->calculateCartItemsPrice();
        }
    }

    protected function cartItemsDefaultValue(): CartItemEntityCollection
    {
        return new CartItemEntityCollection([]);
    }

    protected function promotionsDefaultValue(): CartItemPromotionEntityCollection
    {
        return new CartItemPromotionEntityCollection([]);
    }

    /**
     * 清理一下价格信息.
     */
    protected function clearCartItemsPrice(): void
    {
        /** @var CartItemEntity $cartItem */
        foreach ($this->cartItems as $cartItem) {
            $cartItem->price->clearPrice();
        }
    }

    /**
     * 通知价格更新.
     */
    protected function calculateCartItemsPrice(): void
    {
        /** @var CartItemEntity $cartItem */
        foreach ($this->cartItems as $cartItem) {
            $cartItem->calculatePrice();
        }
    }

    protected function normalizeSortedPromotions(CartItemPromotionEntityCollection $promotions): array
    {
        if (!$promotions->count()) {
            return [];
        }

        $tempPromotionIds = [];

        /** @var CartItemPromotionEntity $promotion */
        foreach ($promotions as $promotion) {
            if ($promotion->cartItems->count()) {
                $tempPromotionIds[$promotion->priority()][] = $promotion->promotionId;
            }
        }

        if (!$tempPromotionIds) {
            return [];
        }

        ksort($tempPromotionIds);

        $newPromotions = [];
        foreach ($tempPromotionIds as $promotionIds) {
            foreach ($promotionIds as $v) {
                $newPromotions[] = $promotions->get($v);
            }
        }

        return $newPromotions;
    }
}
