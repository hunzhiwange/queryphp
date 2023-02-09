<?php

declare(strict_types=1);

namespace App\Domain\Service\Attachment;

use Leevel\Support\Dto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadParams extends Dto
{
    public ?UploadedFile $file = null;
}
