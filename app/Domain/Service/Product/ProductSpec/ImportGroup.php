<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpecGroup;
use App\Domain\Service\Support\ImportBase;

/**
 * 商品多规格分组导入.
 */
class ImportGroup
{
    use ImportBase;

    public function handle(array $data): void
    {
        $this->handleBase(ProductSpecGroup::class, $data);
    }
}
