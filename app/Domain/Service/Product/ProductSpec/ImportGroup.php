<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpecGroup;
use App\Domain\Entity\Product\ProductSpecGroupGroupTypeEnum;
use App\Domain\Entity\Product\ProductSpecGroupSearchingEnum;
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

    protected function defaultData(): array
    {
        return [
            'category_id' => '',
            'group_id' => '',
            'group_name' => '',
            'group_sku_field' => '',
            'group_type' => ProductSpecGroupGroupTypeEnum::SKU->value,
            'group_searching' => ProductSpecGroupSearchingEnum::YES->value,
        ];
    }

    /**
     * @throws \Exception
     */
    protected function validateItem(array $data): void
    {
        foreach ($data as $item) {
            if (empty($item['group_id'])) {
                throw new \Exception('商品规格分组编号不能为空');
            }

            if (empty($item['group_name'])) {
                throw new \Exception('商品规格分组名字不能为空');
            }

            if (isset($item['group_type'])) {
                ProductSpecGroupGroupTypeEnum::from((int) $item['group_type']);
            }

            if (isset($item['group_searching'])) {
                ProductSpecGroupSearchingEnum::from((int) $item['group_searching']);
            }
        }
    }
}
