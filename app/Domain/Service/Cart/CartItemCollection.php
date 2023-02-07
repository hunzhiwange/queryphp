<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Collection;

/**
 * 购物车项集合.
 */
class CartItemCollection extends Collection
{
    /**
     * 键类型.
     */
    protected array $keyTypes = ['string'];

    /**
     * 值类型.
     */
    protected array $valueTypes = [CartItemDto::class];

    /**
     * 构造函数.
     */
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function get(string $itemHash): ?CartItemDto
    {
        return $this->__get($itemHash);
    }

    public function set(string $itemHash, CartItemDto $cartItem): void
    {
        $this->__set($itemHash, $cartItem);
    }

    public function remove(string $itemHash): void
    {
        $this->__unset($itemHash);
    }
}
