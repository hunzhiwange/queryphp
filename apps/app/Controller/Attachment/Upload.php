<?php

declare(strict_types=1);

namespace App\Controller\Attachment;

use App\Controller\Support\CloseDebug;
use App\Controller\Support\Controller;
use App\Domain\Service\Attachment\Upload as AttachmentUpload;
use App\Domain\Service\Attachment\UploadParams;
use Leevel\Http\Request;

/**
 * 文件上传.
 *
 * @codeCoverageIgnore
 */
class Upload
{
    use Controller;
    use CloseDebug;

    public function handle(Request $request, AttachmentUpload $service): array 
    {
        $this->closeDebug();
        $params = new UploadParams($this->input($request));

        return $service->handle($params);
    }

    private function input(Request $request): array
    {
        return ['file' => $request->files->get('file')];
    }
}
