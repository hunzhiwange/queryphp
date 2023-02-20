<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductCategory;

use App\Domain\Entity\Product\ProductCategory;
use App\Domain\Entity\Product\ProductCategorySearchingEnum;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Arr\Only;

/**
 * 商品分类导入.
 */
class Import
{
    private const BRAND_FIELD = [
        'category_id',
        'name',
        'searching',
    ];

    public function handle(array $data): void
    {
        $data = $this->prepareData($data);
        $w = UnitOfWork::make();
        $w->persist(function () use ($data): void {
            ProductCategory::select()->insertAll($data, [], self::BRAND_FIELD);
        });
        $w->flush();
    }

    protected function prepareData(array $data): array
    {
        $this->validateCategoryItem($data);
        $data = $this->prepareCategoryData($data);
        if (!$data) {
            throw new \Exception('导入的分类数据不能为空');
        }

        return $data;
    }

    protected function prepareCategoryData(array $data): array
    {
        $defaultData = $this->defaultData();
        foreach ($data as &$item) {
            $item = array_merge($defaultData, $item);
            $item = Only::handle($item, self::BRAND_FIELD);
        }

        return $data;
    }

    protected function defaultData(): array
    {
        return [
            'category_id' => '',
            'name' => '',
            'searching' => ProductCategorySearchingEnum::YES->value,
        ];
    }

    /**
     * @throws \Exception
     */
    protected function validateCategoryItem(array $data): void
    {
        foreach ($data as $item) {
            if (empty($item['category_id'])) {
                throw new \Exception('商品分类编号不能为空');
            }
            if (isset($item['searching'])) {
                ProductCategorySearchingEnum::from((int) $item['searching']);
            }
            if (empty($item['name'])) {
                throw new \Exception('商品分类名字不能为空');
            }
        }
    }
}
