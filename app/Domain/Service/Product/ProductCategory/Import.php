<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductCategory;

use App\Domain\Entity\Product\ProductCategory;
use App\Domain\Entity\Product\ProductCategorySearchingEnum;
use App\Domain\Service\Support\ImportBase;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 商品分类导入.
 */
class Import
{
    use ImportBase;

    public function handle(array $data): void
    {
        $data = $this->prepareData(ProductCategory::class, $data);
        $w = UnitOfWork::make();
        $w->persist(function () use ($data): void {
            ProductCategory::select()->insertAll($data['data'], [], $data['fields']);
        });
        $w->flush();
    }

    protected function defaultData(): array
    {
        return [
            'category_id' => '',
            'parent_id' => '',
            'name' => '',
            'searching' => ProductCategorySearchingEnum::YES->value,
            'logo_large' => '',
            'brand_id' => '',
            'max_order_number' => 0,
            'sort' => 0,
        ];
    }

    /**
     * @throws \Exception
     */
    protected function validateItem(array $data): void
    {
        foreach ($data as $item) {
            if (empty($item['category_id'])) {
                throw new \Exception('商品分类编号不能为空');
            }

            if (empty($item['name'])) {
                throw new \Exception('商品分类名字不能为空');
            }

            if (isset($item['searching'])) {
                ProductCategorySearchingEnum::from((int) $item['searching']);
            }
        }
    }
}
