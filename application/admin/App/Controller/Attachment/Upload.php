<?php

declare(strict_types=1);

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
