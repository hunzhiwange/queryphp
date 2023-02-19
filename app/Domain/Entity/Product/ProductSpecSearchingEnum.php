<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 商品多规格是否为搜索值枚举.
 */
enum ProductSpecSearchingEnum: int
{
    use Enum;

    #[Msg('否')]
    case NO = 0;

    #[Msg('是')]
    case YES = 1;
}
