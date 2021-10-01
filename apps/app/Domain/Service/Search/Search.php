<?php

declare(strict_types=1);

namespace App\Domain\Service\Search;

use RuntimeException;
use Leevel;

/**
 * 搜索项.
 */
class Search
{
    /**
     * 构造函数.
     *
     * 加入顶层命名空间以便于做单元测试
     */
    public function __construct(private string $topNamespace = 'App')
    {
    }

    /**
     * 响应方法.
     *
     * @throws \RuntimeException
     */
    public function handle(array $input): array
    {
        $result = [];
        foreach ($input as $service => $method) {
            if (!is_array($method)) {
                continue;
            }

            $subService = null;
            if (strpos($service, ':')) {
                $tempService = explode(':', $service);
                $service = $tempService[0];
                $subService = $tempService[1];
            }

            $convertService = $this->convertService($service);
            $serviceClass = $this->topNamespace.'\\Service\\Search\\'.$convertService.'\\';

            foreach ($method as $v) {
                $convertMethod = $this->convertService($subService ? $subService : $v);
                $serviceHandle = $serviceClass.$convertMethod;
                if (!class_exists($serviceHandle)) {
                    $e = sprintf('Search condition `%s` was not found.', $serviceHandle);

                    throw new RuntimeException($e);
                }

                $serviceObj = Leevel::make($serviceHandle);
                if (!is_object($serviceObj) || !is_callable([$serviceObj, 'handle'])) {
                    $e = sprintf('Search condition `%s:%s` was invalid.', $serviceHandle, 'handle');

                    throw new RuntimeException($e);
                }

                if ($subService) {
                    $result[$service][$subService][$v] = Leevel::call([$serviceObj, 'handle'], [$v, $input]);
                } else {
                    $result[$service][$v] = Leevel::call([$serviceObj, 'handle'], [$v, $input]);
                }
            }
        }

        return $result;
    }

    /**
     * 转换搜索项.
     */
    private function convertService(string $service): string
    {
        if (false !== strpos($service, '-')) {
            $service = str_replace('-', '_', $service);
        }

        if (false !== strpos($service, '_')) {
            $service = '_'.str_replace('_', ' ', $service);
            $service = ltrim(str_replace(' ', '', ucwords($service)), '_');
        }

        return ucfirst($service);
    }
}
