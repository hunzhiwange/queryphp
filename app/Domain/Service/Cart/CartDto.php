<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use App\Domain\Dto\ParamsDto;

class CartDto extends ParamsDto
{
    public CartItemCollection $cartItems;

    public CartItemPromotionCollection $promotions;

    public function addItem(CartItemDto $cartItem): CartItemDto
    {
        $itemHash = $cartItem->generateHash();

        if ($this->getItem($itemHash)) {
            $this->getItem($itemHash)->addNumber($cartItem->number);
        } else {
            $this->cartItems->set($itemHash, $cartItem);
        }

        return $cartItem;
    }

    public function getItem(string $itemHash): ?CartItemDto
    {
        // @todo 不存在直接抛出异常
        return $this->cartItems->get($itemHash);
    }

    public function increment(string $itemHash, float $step = 1.0): ?CartItemDto
    {
        $item = $this->getItem($itemHash);
        $item->addNumber($step);

        return $item;
    }

    public function decrement(string $itemHash, float $step = 1.0): ?CartItemDto
    {
        $item = $this->getItem($itemHash);
        if (1 === bccomp_compatibility($item->number, $step)) {
            $item->subNumber($step);

            return $item;
        }

        $this->removeItem($itemHash);
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

        /** @var CartItemDto $item */
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

        /** @var CartItemDto $item */
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

        /** @var CartItemDto $item */
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

        /** @var CartItemDto $item */
        foreach ($this->cartItems as $item) {
            $count = bcadd_compatibility($count, $item->number);
        }

        return $count;
    }

    public function countItemNumberActive(): float
    {
        $count = 0;

        /** @var CartItemDto $item */
        foreach ($this->cartItems as $item) {
            if ($item->active) {
                $count = bcadd_compatibility($count, $item->number);
            }
        }

        return $count;
    }

    public function addCoupon(CartItemPromotionEntity $coupon): void
    {
        $this->promotions->set($coupon->promotionId, $coupon);
    }

    public function setCouponCartItem(CartItemPromotionEntity $coupon, CartItemDto $cartItemDto, ...$moreCartItemDto): void
    {
        $coupon->cartItems->set($cartItemDto->getHash(), $cartItemDto);
        foreach ($moreCartItemDto as $v) {
            $coupon->cartItems->set($v->getHash(), $v);
        }
        $this->addCoupon($coupon);
    }

    public function update1(): void
    {
        /** @var CartItemPromotionEntity $promotion */
        foreach ($this->promotions as $promotion) {
            if ($promotion->isMeetThresholdType() && $promotion->cartItems->count()) {
                $promotion->calculatePriceAllocationResult();
            }
        }

        // 通知价格更新
        // @todo 只通知一部分受价格影响的商品更新价格
        /** @var CartItemDto $cartItem */
        foreach ($this->cartItems as $cartItem) {
            // 遍历购物车项目计算价格
            $cartItem->calculatePrice($this->promotions);
        }
    }

    protected function cartItemsDefaultValue(): CartItemCollection
    {
        return new CartItemCollection([]);
    }

    protected function promotionsDefaultValue(): CartItemPromotionCollection
    {
        return new CartItemPromotionCollection([]);
    }
}
