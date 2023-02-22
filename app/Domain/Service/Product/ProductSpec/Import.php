<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductSpec;

use App\Domain\Entity\Product\ProductSpec;
use App\Domain\Entity\Product\ProductSpecSearchingEnum;
use App\Domain\Service\Support\ImportBase;

/**
 * 商品多规格导入.
 */
class Import
{
    use ImportBase;

    public function handle(array $data): void
    {
        $this->handleBase(ProductSpec::class, $data);
    }

    protected function defaultData(): array
    {
        return [
            'group_id' => '',
            'name' => '',
            'spec_id' => '',
            'searching' => ProductSpecSearchingEnum::YES->value,
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

            if (empty($item['spec_id'])) {
                throw new \Exception('商品规格编号不能为空');
            }

            if (empty($item['name'])) {
                throw new \Exception('商品规格名字不能为空');
            }

            if (isset($item['searching'])) {
                ProductSpecSearchingEnum::from((int) $item['searching']);
            }
        }
    }
}
