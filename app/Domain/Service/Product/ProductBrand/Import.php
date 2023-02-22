<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductBrand;

use App\Domain\Entity\Product\ProductBrand;
use App\Domain\Entity\Product\ProductBrandSearchingEnum;
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

    protected function defaultData(): array
    {
        return [
            'brand_id' => '',
            'name' => '',
            'searching' => ProductBrandSearchingEnum::YES->value,
        ];
    }

    /**
     * @throws \Exception
     */
    protected function validateBrandItem(array $data): void
    {
        foreach ($data as $item) {
            if (empty($item['brand_id'])) {
                throw new \Exception('商品品牌编号不能为空');
            }

            if (empty($item['name'])) {
                throw new \Exception('商品品牌名字不能为空');
            }

            if (isset($item['searching'])) {
                ProductBrandSearchingEnum::from((int) $item['searching']);
            }
        }
    }
}
