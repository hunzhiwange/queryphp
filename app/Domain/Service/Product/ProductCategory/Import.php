<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductCategory;

use App\Domain\Entity\Product\ProductCategory;
use App\Domain\Service\Support\ImportBase;

/**
 * 商品分类导入.
 */
class Import
{
    use ImportBase;

    public function handle(array $data): void
    {
        $this->handleBase(ProductCategory::class, $data);
    }
}
