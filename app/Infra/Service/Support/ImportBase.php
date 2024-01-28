<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use App\Infra\Exceptions\BusinessException;
use App\Infra\Exceptions\ErrorCode;
use App\Infra\Service\ApiQL\ApiQLStore;
use App\Infra\Service\ApiQL\ApiQLStoreParams;
use App\Infra\Service\ApiQL\ApiQLUpdate;
use App\Infra\Service\ApiQL\ApiQLUpdateParams;
use App\Infra\Service\ApiQL\ParseEntityClass;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Arr\Only;

/**
 * 基础导入.
 */
trait ImportBase
{
    use ParseEntityClass;

    public function handleBase(string $entityClass, array $data, ?UnitOfWork $w = null, ?EntityPersistEnum $persist = null, ?\Closure $on = null): void
    {
        if (!$persist) {
            $persist = EntityPersistEnum::STORE;
        }

        $flush = false;
        if (!$w) {
            $w = new UnitOfWork();
            $flush = true;
        }

        $data = $this->prepareData($entityClass, $data);
        $entity = $this->entityClassName($entityClass);
        $this->persist($w, $data, $entity, $persist, $on);

        if ($flush) {
            $w->flush();
        }
    }

    protected function persist(UnitOfWork $w, array $data, string $entity, EntityPersistEnum $persist, ?\Closure $on): void
    {
        $baseData = [
            'entity_class' => $entity,
            'entity_auto_flush' => false,
        ];

        $saveData = [];
        foreach ($data['data'] as $item) {
            $saveData[] = array_merge($baseData, $item);
        }

        switch ($persist) {
            // @todo replace 还不支持
            case EntityPersistEnum::REPLACE:
            case EntityPersistEnum::STORE:
                foreach ($saveData as $item) {
                    $entity = $this->storeAnEntity($item, new ApiQLStore($w));
                    if ($on) {
                        $on($entity);
                    }
                }

                break;

            case EntityPersistEnum::UPDATE:
                foreach ($saveData as $item) {
                    $entity = $this->updateAnEntity($item, new ApiQLUpdate($w));
                    if ($on) {
                        $on($entity);
                    }
                }

                break;

        }
    }

    public function storeAnEntity(array $input, ApiQLStore $service): Entity
    {
        $inputEntity = ApiQLStoreParams::exceptInput($input);
        $input['entity_data'] = $inputEntity;
        $params = new ApiQLStoreParams($input);

        return $service->handle($params);
    }

    public function updateAnEntity(array $input, ApiQLUpdate $service): Entity
    {
        $inputEntity = ApiQLUpdateParams::exceptInput($input);
        $input['entity_data'] = $inputEntity;
        $params = new ApiQLUpdateParams($input);

        return $service->handle($params);
    }

    protected function prepareData(string $entityClass, array $data): array
    {
        if (!$data) {
            throw new BusinessException(ErrorCode::ID2023032511385341);
        }

        if (!isset($data[0])) {
            throw new BusinessException(ErrorCode::ID2023032511385418);
        }

        $fields = $this->parseFields($entityClass, $data[0]);
        $defaultData = array_merge(get_entity_default_data($entityClass), $this->defaultData());
        $data = $this->filterData($data, $defaultData, $fields);
        $this->validateItem($data);

        return [
            'data' => $data,
            'fields' => $fields,
        ];
    }

    protected function filterData(array $data, array $defaultData, array $currentFields): array
    {
        foreach ($data as $k => $item) {
            $data[$k] = Only::handle($item, $currentFields);
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

    protected function parseFields(string $entityClass, array $data): array
    {
        $importFields = get_entity_import_fields($entityClass);
        $fields = array_values(array_intersect($importFields, array_keys($data)));
        if (!$fields) {
            throw new BusinessException(ErrorCode::ID2023032511343739);
        }

        return $fields;
    }

    protected function parseEnumValue(array $fields, array $v): array
    {
        foreach ($fields as $fieldKey => $field) {
            if (!isset($field[Entity::ENUM_CLASS], $v[$fieldKey])) {
                continue;
            }

            /** @todo 缓存一下 */
            $enumClass = $field[Entity::ENUM_CLASS];
            $description = $enumClass::valueDescription();

            if (\array_key_exists($v[$fieldKey], $description)) {
                continue;
            }

            if (\in_array($v[$fieldKey], $description, true)) {
                $v[$fieldKey] = array_search($v[$fieldKey], $description, true);

                continue;
            }

            throw new BusinessException(
                ErrorCode::ID2023032511361029,
                sprintf(
                    '字段`%s`的取值错误，正确的值范围为`%s`，给定的值为`%s`',
                    $fieldKey,
                    implode(',', $description),
                    $v[$fieldKey],
                )
            );
        }

        return $v;
    }
}
