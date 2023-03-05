<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Exceptions\TimeBusinessException;
use App\Exceptions\TimeErrorCode;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Arr\Only;
use Leevel\Validate\Proxy\Validate;

/**
 * 基础导入.
 */
trait ImportBase
{
    public function handleBase(string $entityClass, array $data, bool $flush = true): UnitOfWork
    {
        $data = $this->prepareData($entityClass, $data);
        $w = UnitOfWork::make();
        $w->persist(function () use ($data, $entityClass): void {
            if (!is_subclass_of($entityClass, Entity::class)) {
                throw new \Exception(sprintf('Entity class %s is invalid.', $entityClass));
            }
            $entityClass::select()->insertAll($data['data'], [], $data['fields']);
        });
        if ($flush) {
            $w->flush();
        }

        return $w;
    }

    protected function prepareData(string $entityClass, array $data): array
    {
        if (!$data) {
            throw new \Exception('导入的数据不能为空');
        }

        if (!isset($data[0])) {
            throw new \Exception('导入的数据异常');
        }

        $fields = $this->parseFields($entityClass, $data[0]);
        $defaultData = array_merge(get_entity_default_data($entityClass), $this->defaultData());
        $data = $this->filterData($data, $defaultData, $fields);
        $this->validateEntity($entityClass, $data);
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

    protected function validateItem(array $data): void
    {
    }

    protected function validateEntity(string $entityClass, array $data): void
    {
        if (!is_subclass_of($entityClass, \Leevel\Database\Ddd\Entity::class)) {
            throw new \Exception(sprintf('Entity class %s is invalid.', $entityClass));
        }

        $validatorScenes = Entity::VALIDATOR_SCENES;
        $validatorFields = array_keys($data[0]);
        $validatorRules = $entityClass::columnValidatorRules($validatorScenes, $validatorFields);
        $columnNames = $entityClass::columnNames();

        foreach ($data as $v) {
            $validator = Validate::make($v, $validatorRules, $columnNames);
            if ($validator->fail()) {
                // @phpstan-ignore-next-line
                throw new TimeBusinessException(TimeErrorCode::ID20230305144912388, $validator->error());
            }
        }
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
