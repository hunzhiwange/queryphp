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

namespace Admin\App\Controller\Attachment;

use Admin\App\Controller\Support\Controller;
use Admin\App\Service\Attachment\Upload as Service;
use Leevel\Http\IRequest;

/**
 * 文件上传.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.01.11
 *
 * @version 1.0
 */
class Upload
{
    use Controller;

    /**
     * 允许的输入字段.
     *
     * @var array
     */
    private $allowedInput = [
        'file',
    ];

    /**
     * 响应方法.
     *
     * @param \Leevel\Http\IRequest               $request
     * @param \Admin\App\Service\Attachment\Index $service
     *
     * @return string
     */
    public function handle(IRequest $request, Service $service): string
    {
        return $this->main($request, $service)[0];
    }
}
