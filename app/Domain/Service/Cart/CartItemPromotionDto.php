<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use App\Domain\Dto\ParamsDto;

/**
 * 购物车活动项目.
 */
class CartItemPromotionDto extends ParamsDto
{
    /**
     * 活动 ID.
     */
    public int $promotionId = 0;

    /**
     * 活动名字.
     */
    public string $promotionName = '';
}
