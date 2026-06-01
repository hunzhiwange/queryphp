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
        [$validatorRules, $validatorMessages] = $entityClass::getColumnValidators($validatorScenes);

        $validator = Validate::proxy()->make(
            $data,
            $validatorRules,
            $entityClass::getColumnNames(),
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
            if ($entity::isDefinedEntityConstant('TABLE_NAME')) {
                $tableName = '『'.(string) $entity::getEntityConstant('TABLE_NAME').'』';
            }

            $errorMessage = (string) __('数据');
            if ($entity::isDefinedEntityConstant('UNIQUE_INDEX')) {
                $uniqueIndex = $entity::getEntityConstant('UNIQUE_INDEX');
                if (\is_array($uniqueIndex)) {
                    $errorMessage = (string) ($uniqueIndex[$e->getUniqueIndex()]['comment'] ?? $errorMessage);
                }
            }

            throw new BusinessException(ErrorCode::ID2023052616455333, $tableName.$errorMessage.(string) __('已存在'));
        }
    }
}
