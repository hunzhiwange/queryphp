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
    private array $currentFields = [];

    public function handle(array $data): void
    {
        $data = $this->prepareData($data);
        $w = UnitOfWork::make();
        $w->persist(function () use ($data): void {
            ProductCategory::select()->insertAll($data, [], $this->currentFields);
        });
        $w->flush();
    }

    protected function prepareData(array $data): array
    {
        if (!$data) {
            throw new \Exception('导入的分类数据不能为空');
        }

        $importFields = get_entity_import_fields(ProductCategory::class);
        $this->currentFields = array_values(array_intersect($importFields, array_keys($data[0])));
        if (!$this->currentFields) {
            throw new \Exception('导入的字段全部不允许');
        }

        $data = $this->prepareCategoryData($data);
        $this->validateCategoryItem($data);

        return $data;
    }

    protected function prepareCategoryData(array $data): array
    {
        foreach ($data as &$item) {
            $item = Only::handle($item, $this->currentFields);
        }

        return format_by_default_data($data, $this->defaultData());
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
