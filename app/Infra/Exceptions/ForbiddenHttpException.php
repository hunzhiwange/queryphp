<?php

declare(strict_types=1);

namespace App\Infra\Exceptions;

use Leevel\Kernel\Exceptions\ForbiddenHttpException as BaseForbiddenHttpException;

class ForbiddenHttpException extends BaseForbiddenHttpException
{
}
