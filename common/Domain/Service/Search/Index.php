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

use Common\Infra\Exception\SearchItemNotFoundException;
use Leevel;

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
     * 顶级命名空间.
     *
     * @var string
     */
    private $topNamespace;

    /**
     * 特殊的语言保留关键字.
     *
     * 遇到一个新增加即可，不需要全部添加.
     *
     * @var array
     */
    private $keyMap = [
        'return' => 'returns',
        'list'   => 'lists',
        'new'    => 'news',
    ];

    /**
     * 构造函数.
     *
     * 加入顶层命名空间以便于做单元测试
     *
     * @param string $topNamespace
     */
    public function __construct(string $topNamespace = 'Admin')
    {
        $this->topNamespace = $topNamespace;
    }

    /**
     * 响应方法.
     *
     * @param array $input
     *
     * @throws \Common\Infra\Exception\SearchItemNotFoundException
     *
     * @return array
     */
    public function handle(array $input): array
    {
        $result = [];
        $keyMap = $this->keyMap;

        foreach ($input as $service => $method) {
            if (!is_array($method)) {
                continue;
            }

            $convertService = $this->convertService($keyMap[$service] ?? $service);
            $serviceClass = '\\'.$this->topNamespace.'\\App\\Service\\Search\\'.$convertService.'\\';

            foreach ($method as $v) {
                if (isset($keyMap[$v])) {
                    $v = $keyMap[$v];
                }

                $convertMethod = $this->convertService($v);
                $serviceHandle = $serviceClass.$convertMethod;

                if (!class_exists($serviceHandle)) {
                    $e = sprintf('Service `%s` was not found.', $serviceHandle);

                    throw new SearchItemNotFoundException($e);
                }

                $serviceObj = Leevel::make($serviceHandle);

                if (!is_object($serviceObj) || !is_callable([$serviceObj, 'handle'])) {
                    $e = sprintf('Service `%s:%s` was invalid.', $serviceHandle, 'handle');

                    throw new SearchItemNotFoundException($e);
                }

                $result[lcfirst($convertService)][lcfirst($convertMethod)] = Leevel::call([$serviceObj, 'handle'], [$input]);
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
