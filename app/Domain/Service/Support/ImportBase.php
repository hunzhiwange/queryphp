<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use Leevel\Support\Arr\Only;

/**
 * 基础导入.
 */
trait ImportBase
{
    protected function prepareData(string $entityClass, array $data): array
    {
        if (!$data) {
            throw new \Exception('导入的数据不能为空');
        }

        $fields = $this->parseFields($entityClass, $data[0]);
        $data = $this->filterData($data, $this->defaultData(), $fields);
        $this->validateItem($data);

        return [
            'data' => $data,
            'fields' => $fields,
        ];
    }

    protected function filterData(array $data, array $defaultData, array $currentFields): array
    {
        foreach ($data as &$item) {
            $item = Only::handle($item, $currentFields);
        }

        return format_by_default_data($data, $defaultData);
    }

    protected function defaultData(): array
    {
        return [];
    }

    /**
     * @throws \Exception
     */
    protected function validateItem(array $data): void
    {
    }

    protected function parseFields(string $entityClass, array $data): array
    {
        $importFields = get_entity_import_fields($entityClass);
        $fields = array_values(array_intersect($importFields, array_keys($data)));
        if (!$fields) {
            throw new \Exception('导入的字段全部不允许');
        }

        return $fields;
    }
}
