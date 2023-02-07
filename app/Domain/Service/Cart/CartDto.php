<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use App\Domain\Dto\ParamsDto;

class CartDto extends ParamsDto
{
    public CartItemCollection $cartItems;

    public CartItemPromotionCollection $promotions;

    protected array $couponMap = [];

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

    public function addCoupon(CartItemPromotionDto $coupon): void
    {
        $this->promotions->set($coupon->promotionId, $coupon);
    }

    public function setCouponCartItem(CartItemPromotionDto $coupon, CartItemDto $cartItemDto): void
    {
        $this->addCoupon($coupon);
        $cartItemDto->price->promotions->set($coupon->promotionId, $coupon);
    }

    public function update1(): void
    {
        // 第一步分析活动商品满减明细
        $result = [];
        $resultDetail = [];

        /** @var CartItemPromotionDto $promotion */
        foreach ($this->promotions as $promotion) {
            /** @var CartItemDto $cartItem */
            foreach ($this->cartItems as $cartItem) {
                /** @var CartItemPromotionDto $cartItemPromotion */
                foreach ($cartItem->price->promotions as $cartItemPromotion) {
                    if ($promotion->promotionId === $cartItemPromotion->promotionId) {
                        $result[$promotion->promotionId] = bcadd_compatibility($result[$promotion->promotionId] ?? 0, $cartItem->getActivePurchaseTotalPrice());
                        $resultDetail[$promotion->promotionId][$cartItem->getHash()] = $cartItem->getActivePurchaseTotalPrice();
                    }
                }
            }
        }

        // 第二步分析活动的满减门槛是否达到，如果达到则计算分摊价格
        /** @var CartItemPromotionDto $promotion */
        foreach ($this->promotions as $promotion) {
            if (isset($result[$promotion->promotionId])
                && 1 === bccomp_compatibility($result[$promotion->promotionId], 0)
            ) {
                if (bccomp_compatibility($result[$promotion->promotionId], $promotion->meetThreshold) >= 0) {
                    $promotion->roportionResult = CalculatePriceProportionHelper::handle($resultDetail[$promotion->promotionId], $promotion->allFavorableTotalPrice);
                } else {
                    echo '还差多少钱满足最低门槛';
                }
            }
        }

        // 通知价格更新
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
