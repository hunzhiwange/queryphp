<?php

declare(strict_types=1);

namespace Admin\App\Service\Attachment;

use Common\Domain\Service\Attachment\Upload as Service;

/**
 * 上传服务.
 */
class Upload
{
    public function __construct(private Service $service)
    {
    }

    public function handle(array $input): array
    {
        return $this->service->handle($input);
    }
}
