<?php

declare(strict_types=1);

namespace Admin\Controller\Attachment;

use Admin\Controller\Support\Controller;
use Admin\Service\Attachment\Upload as Service;
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
