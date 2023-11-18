<?php

declare(strict_types=1);

namespace App\Infra\Exceptions;

use Leevel\Kernel\Exceptions\TooManyRequestsHttpException as BaseTooManyRequestsHttpException;

class TooManyRequestsHttpException extends BaseTooManyRequestsHttpException
{
}
