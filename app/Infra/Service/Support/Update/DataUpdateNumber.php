<?php

declare(strict_types=1);

namespace App\Infra\Service\Support\Update;

use App\Infra\Exceptions\BusinessException;
use App\Infra\Exceptions\ErrorCode;

abstract class DataUpdateNumber
{
    /**
     * 支持更新的字段.
     */
    public const SUPPORTED_UPDATE_FIELD = [];

    public const MAX_RETRY_NUMBER = 2;

    public const VERSION_FIELD = 'version';

    /**
     * 重试次数.
     */
    protected int $retryNumber = 0;

    protected DataActionEnum $action = DataActionEnum::CHANGE;

    protected string $dataEntity = '';

    protected function updateData(array $currentData, mixed ...$args): void
    {
        check_entity_class($this->dataEntity);
        $this->dataEntity::select()->transaction(fn () => $this->updateDataReal($currentData, ...$args));
    }

    protected function updateDataReal(array $currentData, mixed ...$args): void
    {
        try {
            $oldData = $this->queryOldData($currentData, ...$args);

            $currentData = $this->prepareUpdateData($currentData, $oldData, ...$args);

            // 如果是等于则计算变化量
            if (DataActionEnum::EQUAL === $this->action) {
                $currentData = $this->parseChangedData($currentData, $oldData);
                if (!$currentData) {
                    throw new DataNotChangedException();
                }
            }

            $this->updateDataItem(
                $currentData,
                $oldData,
                ...$args
            );
        } catch (DataUpdateException $e) {
            if ($this->retryNumber >= static::MAX_RETRY_NUMBER) {
                throw $e;
            }
            ++$this->retryNumber;

            $this->updateDataReal($currentData, ...$args);
        } catch (DataNotChangedException) {
        } finally {
            $this->retryNumber = 0;
            $this->action = DataActionEnum::CHANGE;
        }
    }

    protected function prepareUpdateData(array $currentData, array $oldData, mixed ...$args): array
    {
        return $currentData;
    }

    abstract protected function queryOldData(array $currentData, mixed ...$args): array;

    abstract protected function prepareSaveData(array $currentData, array $oldData, mixed ...$args): array;

    protected function updateDataItem(array $currentData, array $oldData, mixed ...$args): void
    {
        [$condition, $saveData] = $this->prepareSaveData($currentData, $oldData, ...$args);

        // 没有任何数据发生变化
        if (!$saveData) {
            throw new DataNotChangedException();
        }

        $saveData[static::VERSION_FIELD] = $condition[static::VERSION_FIELD] + 1;
        $affectedRow = $this->dataEntity::select()
            ->where($condition)
            ->update($saveData)
        ;

        if (1 !== $affectedRow) {
            throw new DataUpdateException(ErrorCode::ID2023033020572500);
        }

        $this->afterUpdateDataItem($condition, $saveData, $currentData, $oldData, ...$args);
    }

    protected function afterUpdateDataItem(array $condition, array $saveData, array $currentData, array $oldData, mixed ...$args): void
    {
    }

    protected function parseChangedData(array $currentData, array $oldData): array
    {
        $newData = [];
        foreach ($currentData as $k => $v) {
            $changeNumber = bc_sub($v, $oldData[$k]);
            if (0 !== bc_comp($changeNumber, 0)) {
                $newData[$k] = $changeNumber;
            }
        }

        return $newData;
    }

    protected function checkNumberGreaterThanZero(string $field, float $number): void
    {
        if (bc_comp($number, 0) < 1) {
            throw new BusinessException(
                ErrorCode::ID2023033017412773,
                sprintf('数据`%s`变更数量必须大于0', $this->dataEntity::columnName($field))
            );
        }
    }

    protected function checkNumberGreaterThanOrEqualToZero(string $field, float $number): void
    {
        if (bc_comp($number, 0) < 0) {
            throw new BusinessException(
                ErrorCode::ID2023033017452060,
                sprintf('数据`%s`变更数量必须大于等于0', $this->dataEntity::columnName($field))
            );
        }
    }
}
