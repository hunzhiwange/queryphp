<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Collection;

/**
 * 活动集合.
 */
class CartItemPromotionEntityCollection extends Collection
{
    /**
     * 键类型.
     */
    protected array $keyTypes = ['int'];

    /**
     * 值类型.
     */
    protected array $valueTypes = [CartItemPromotionEntity::class];

    /**
     * 构造函数.
     */
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    /**
     * 获取活动.
     */
    public function get(int|string $promotionId): ?CartItemPromotionEntity
    {
        return $this->__get($promotionId);
    }

    /**
     * 设置活动.
     */
    public function set(int|string $promotionId, CartItemPromotionEntity $cartItemPromotion): void
    {
        $this->__set($promotionId, $cartItemPromotion);
    }

    /**
     * 删除活动.
     */
    public function remove(int|string $promotionId): void
    {
        $this->__unset($promotionId);
    }

    /**
     * 是否存在活动.
     */
    public function has(int|string $promotionId): bool
    {
        return $this->__isset($promotionId);
    }
}
