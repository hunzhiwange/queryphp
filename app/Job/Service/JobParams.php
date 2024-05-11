<?php

declare(strict_types=1);

namespace App\Job\Service;

use App\Infra\Dto\ParamsDto;
use App\Job\Service\Job\Progress;

class JobParams extends ParamsDto
{
    public Progress $progress;

    public int $jobId = 0;

    public array $jobContent = [];
}
