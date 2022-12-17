<?php

declare(strict_types=1);

namespace App\Domain\Validate;

/**
 * 参数校验.
 */
trait ValidateParams
{
    public function baseValidate(
        IValidator $validator,
        string $scene,
        string $exceptionClass,
        int|object $code
    ): void
    {
        $validator = Validate::make($validator, $scene, $this->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new $exceptionClass($code, $e, true);
        }
    }
}
