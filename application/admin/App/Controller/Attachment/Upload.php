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
use Leevel\Http\Request;

/**
 * 文件上传.
 *
 * @codeCoverageIgnore
 */
class Upload
{
    use Controller;

    public function handle(Request $request, Service $service): string
    {
        return $this->main($request, $service)[0];
    }

    private function input(Request $request): array
    {
        return ['file' => $request->files->get('file')];
    }
}
