<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Collection;

/**
 * 购物车项集合.
 */
class CartItemEntityCollection extends Collection
{
    /**
     * 键类型.
     */
    protected array $keyTypes = ['string'];

    /**
     * 值类型.
     */
    protected array $valueTypes = [CartItemEntity::class];

    /**
     * 构造函数.
     */
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    /**
     * 获取购物车商品.
     *
     * @throws \Exception
     */
    public function get(string $itemHash): ?CartItemEntity
    {
        $cartItemEntity = $this->__get($itemHash);
        if (!$cartItemEntity) {
            throw new \Exception(sprintf('Cart item entity %s was not found.', $itemHash));
        }

        // @phpstan-ignore-next-line
        return $cartItemEntity;
    }

    /**
     * 设置购物车商品.
     */
    public function set(string $itemHash, CartItemEntity $cartItem): void
    {
        $this->__set($itemHash, $cartItem);
    }

    /**
     * 删除购物车商品.
     */
    public function remove(string $itemHash): void
    {
        $this->__unset($itemHash);
    }

    /**
     * 是否存在购物车商品.
     */
    public function has(string $itemHash): bool
    {
        return $this->__isset($itemHash);
    }
}
