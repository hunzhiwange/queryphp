<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use App\Infra\Dto\ParamsDto;
use Symfony\Component\HttpFoundation\Response;

trait ParseEntityMethod
{
    protected function parseEntityMethod(string $entityClass, string $entityMethod): array
    {
        $app = 'base';
        if (str_contains($entityClass, ':')) {
            // 第一步解析出应用
            $colonPos = (int) strpos($entityClass, ':');
            $app = substr($entityClass, 0, $colonPos);
            $entityClass = substr($entityClass, $colonPos + 1);

            // 剩余的路径为目录，暂时不支持
            // @todo 移除目录的设计
            if (str_contains($entityClass, ':')) {
                $entityClass = implode('\\', array_map(fn ($v) => ucfirst($v), explode(':', $entityClass)));
            }
        }
        if (str_contains($entityClass, '_')) {
            $entityClass = implode('', array_map(fn ($v) => ucfirst($v), explode('_', $entityClass)));
        }

        if (str_contains($entityMethod, ':')) {
            $entityMethod = implode('\\', array_map(fn ($v) => ucfirst($v), explode(':', $entityMethod)));
        }
        if (str_contains($entityMethod, '_')) {
            $entityMethod = implode('', array_map(fn ($v) => ucfirst($v), explode('_', $entityMethod)));
        }

        $app = ucfirst($app);
        $entityServiceClass = "App\\{$app}\\Service\\".ucfirst($entityClass).'\\'.ucfirst($entityMethod);
        if (!class_exists($entityServiceClass)) {
            throw new \Exception(sprintf('Entity service %s is not exists.', $entityServiceClass));
        }

        $entityServiceParamsClass = $entityServiceClass.'Params';
        if (!class_exists($entityServiceParamsClass)) {
            // 支持公共参数，可以降低大量重复的参数类
            $entityServiceParamsClassCommon = "App\\{$app}\\Service\\".ucfirst($entityClass).'Params';
            if (!class_exists($entityServiceParamsClassCommon)) {
                throw new \Exception(sprintf('Entity service params %s is not exists.', $entityServiceParamsClass));
            }
            $entityServiceParamsClass = $entityServiceParamsClassCommon;
        }

        if (!is_subclass_of($entityServiceParamsClass, ParamsDto::class)) {
            throw new \Exception(sprintf('Entity service params %s must be subclass of %s.', $entityServiceParamsClass, ParamsDto::class));
        }

        return [$entityServiceClass, $entityServiceParamsClass];
    }

    private function runEntityMethod(string $sourceEntityClass, ParamsDto $params): array|Response
    {
        [$entityServiceClass, $entityServiceParamsClass] = $this->parseEntityMethod($sourceEntityClass, $params->entityMethod);
        $entityService = \App::make($entityServiceClass);
        if (!\is_object($entityService)) {
            throw new \Exception(sprintf('Entity service %s is not object.', $entityServiceClass));
        }
        $entityServiceParams = new $entityServiceParamsClass($params->entityData);
        if (!\is_callable([$entityService, 'handle'])) {
            throw new \Exception(sprintf('Entity service %s:%s is not callable.', $entityServiceClass, 'handle'));
        }

        return $entityService->handle($entityServiceParams);
    }
}
