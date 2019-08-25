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

namespace Admin\App\Controller\Resource;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Resource\Update as Service;
use Leevel\Http\IRequest;

/**
 * 资源更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 * @codeCoverageIgnore
 */
class Update
{
    use Controller;

    /**
     * 允许的输入字段.
     *
     * @var array
     */
    private $allowedInput = [
        'id',
        'name',
        'num',
        'status',
    ];

    /**
     * 响应方法.
     *
     * @param \Leevel\Http\IRequest              $request
     * @param \Admin\App\Service\Resource\Update $service
     *
     * @return array
     */
    public function handle(IRequest $request, Service $service): array
    {
        return $this->main($request, $service);
    }

    /**
     * 输入数据.
     *
     * @param \Leevel\Http\IRequest $request
     *
     * @return array
     */
    private function extendInput(IRequest $request): array
    {
        return $this->restfulInput($request);
    }
}
