<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use App\Infra\Exceptions\BusinessException;
use App\Infra\Exceptions\ErrorCode;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\DuplicateKeyException;
use Leevel\Validate\Proxy\Validate;

trait ValidateEntity
{
    private function validateEntity(string $entityClass, array $data, string $validatorScenes): void
    {
        [$validatorRules, $validatorMessages] = $entityClass::columnValidators($validatorScenes);

        $validator = Validate::make(
            $data,
            $validatorRules,
            $entityClass::columnNames(),
            $validatorMessages,
        );

        if ($validator->fail()) {
            throw new BusinessException(
                ErrorCode::ID2023052723275780,
                $validator->error(),
                duration: 10
            );
        }
    }

    private function validateEntityDuplicateKey(Entity $entity, \Closure $call): void
    {
        try {
            $call();
        } catch (DuplicateKeyException $e) {
            $tableName = '';
            if ($entity::definedEntityConstant('TABLE_NAME')) {
                $tableName = '『'.$entity::entityConstant('TABLE_NAME').'』';
            }

            $errorMessage = __('数据');
            if ($entity::definedEntityConstant('UNIQUE_INDEX')) {
                $uniqueIndex = $entity::entityConstant('UNIQUE_INDEX');
                $errorMessage = $uniqueIndex[$e->getUniqueIndex()]['comment'] ?? $errorMessage;
            }

            throw new BusinessException(ErrorCode::ID2023052616455333, $tableName.$errorMessage.__('已存在'));
        }
    }
}
