<?php

declare(strict_types=1);

namespace App\Infra\Validate;

use App\Infra\Exceptions\BusinessException;
use App\Infra\Exceptions\ErrorCode;

/**
 * 参数校验.
 */
trait ValidateParams
{
    public function baseValidate(
        IValidator $validator,
        string $scene,
        ?string $exceptionClass = null,
        ?object $code = null
    ): void {
        $validator = Validate::make($validator, $scene, $this->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);
            $exceptionClass ??= BusinessException::class;
            // @phpstan-ignore-next-line
            throw new $exceptionClass($code ?? ErrorCode::BASE_INVALID_ARGUMENT, $e, true);
        }
    }
}
