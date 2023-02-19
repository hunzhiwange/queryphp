<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 商品多规格分组类型值枚举.
 */
enum ProductSpecGroupGroupTypeEnum: int
{
    use Enum;

    #[Msg('SKU属性')]
    case SKU = 0;

    #[Msg('SPU属性')]
    case SPU = 1;

    #[Msg('基础展示类属性')]
    case DISPLAY = 2;

    #[Msg('自定义类属性')]
    case CUSTOM = 3;
}
