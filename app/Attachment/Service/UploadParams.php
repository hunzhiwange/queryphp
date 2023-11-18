<?php

declare(strict_types=1);

namespace App\Attachment\Service;

use Leevel\Support\Dto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadParams extends Dto
{
    public ?UploadedFile $file = null;

    public ?string $name = null;
}
