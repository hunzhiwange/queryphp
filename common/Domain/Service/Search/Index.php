<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Service\Search;

use Leevel;
use Leevel\Kernel\HandleException;

/**
 * 搜索列表.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.23
 *
 * @version 1.0
 */
class Index
{
    /**
     * 响应方法.
     *
     * @param array $input
     *
     * @return array
     */
    public function handle(array $input): array
    {
        $result = [];

        foreach ($input as $service => $method) {
            if (!is_array($method)) {
                continue;
            }

            $convertService = $this->convertService($service);
            $serviceClass = '\\Admin\\App\\Service\\'.$convertService.'\\Search\\';

            foreach ($method as $v) {
                $convertMethod = $this->convertService($v);
                $serviceHandle = $serviceClass.$convertMethod;

                if (!class_exists($serviceHandle)) {
                    throw new HandleException(sprintf('Service %s was not found.', $serviceHandle));
                }

                $serviceObj = Leevel::make($serviceHandle);

                if (!is_object($serviceObj) || !is_callable([$serviceObj, 'handle'])) {
                    throw new HandleException(sprintf('Service %s:%s was invalid.', $serviceHandle, 'handle'));
                }

                $result[lcfirst($convertService)][lcfirst($convertMethod)] = Leevel::call([$serviceObj, 'handle']);
            }
        }

        return $result;
    }

    /**
     * 转换搜索服务.
     *
     * @param string $service
     *
     * @return string
     */
    protected function convertService(string $service): string
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
