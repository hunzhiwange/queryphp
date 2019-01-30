<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\App\Controller\Attachment;

use Admin\App\Service\Attachment\Upload as service;
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
        return $service->handle($this->input($request));
    }

    /**
     * 输入数据.
     *
     * @param \Leevel\Http\IRequest $request
     *
     * @return array
     */
    protected function input(IRequest $request): array
    {
        return $request->only([
            'file',
        ]);
    }
}
