<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use App\Domain\Dto\ParamsDto;

/**
 * 购物车产品项目.
 */
class CartItemProductDto extends ParamsDto
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
