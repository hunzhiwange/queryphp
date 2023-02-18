<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpec;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 项目多规格导入.
 */
class Import
{
    public function handle(array $data): void
    {
        $w = UnitOfWork::make();
        $w->persist(function () use ($data): void {
            $productSpec = new ProductSpec();
            $lastInsertId = $productSpec::select()->insertAll($data, [], [
                'category_id',
                'group_id',
                'group_name',
                'group_main',
                'group_sku_field',
                'group_type',
                'group_searching',
                'name',
                'spec_id',
                'searching',
            ]);
        });
        $w->flush();
    }
}
