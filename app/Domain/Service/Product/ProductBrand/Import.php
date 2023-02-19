<?php

declare(strict_types=1);

namespace App\Domain\Service\Product\ProductBrand;

use App\Domain\Entity\Product\ProductBrand;
use App\Domain\Entity\Product\ProductBrandSearchingEnum;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Arr\Only;

/**
 * 商品品牌导入.
 */
class Import
{
    private const BRAND_FIELD = [
        'brand_id',
        'name',
        'searching',
    ];

    public function handle(array $data): void
    {
        $data = $this->prepareData($data);
        $w = UnitOfWork::make();
        $w->persist(function () use ($data): void {
            ProductBrand::select()->insertAll($data, [], self::BRAND_FIELD);
        });
        $w->flush();
    }

    protected function prepareData(array $data): array
    {
        $this->validateBrandItem($data);
        $data = $this->prepareBrandData($data);
        if (!$data) {
            throw new \Exception('导入的品牌数据不能为空');
        }

        return $data;
    }

    protected function prepareBrandData(array $data): array
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
            if (isset($item['searching'])) {
                ProductBrandSearchingEnum::from((int) $item['searching']);
            }
            if (empty($item['name'])) {
                throw new \Exception('商品品牌名字不能为空');
            }
        }
    }
}
