<?php

declare(strict_types=1);

namespace App\Attachment\Controller\ApiQL\V1\Attachment;

use App\Attachment\Service\Upload as AttachmentUpload;
use App\Attachment\Service\UploadParams;
use App\Controller\Support\CloseDebug;
use Leevel\Http\Request;

/**
 * 文件上传.
 *
 * @codeCoverageIgnore
 */
class Upload
{
    use CloseDebug;

    /**
     * @throws \Exception
     */
    public function handle(Request $request, AttachmentUpload $service): array
    {
        $this->closeDebug();

        $params = new UploadParams($request->all());
        // @phpstan-ignore-next-line
        $params->file = $request->files->get('file');

        return $service->handle($params);
    }
}
