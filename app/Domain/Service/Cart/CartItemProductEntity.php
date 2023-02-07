<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Dto;

/**
 * 购物车产品项目.
 */
class CartItemProductEntity extends Dto
{
    /**
     * 产品 ID.
     */
    public int $productId = 0;

    /**
     * 产品名字.
     */
    public string $productName = '';
}
