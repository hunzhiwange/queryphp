<?php

declare(strict_types=1);

namespace App\Domain\Validate;

use App\Exceptions\BusinessException;
use App\Exceptions\ErrorCode;

/**
 * 参数校验.
 */
trait ValidateParams
{
    public function baseValidate(
        IValidator $validator,
        string $scene,
        string $exceptionClass = BusinessException::class,
        object|int $code = ErrorCode::BASE_INVALID_ARGUMENT
    ): void {
        $validator = Validate::make($validator, $scene, $this->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new $exceptionClass($code, $e, true);
        }
    }
}
