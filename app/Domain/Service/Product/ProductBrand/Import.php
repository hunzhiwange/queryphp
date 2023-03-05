<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductBrand;

use App\Domain\Entity\Product\ProductBrand;
use App\Domain\Service\Support\ImportBase;

/**
 * 商品品牌导入.
 */
class Import
{
    use ImportBase;

    public function handle(array $data): void
    {
        $this->handleBase(ProductBrand::class, $data);
    }
}
