<?php

declare(strict_types=1);

namespace App\Infra\Validate;

interface IValidator
{
    /**
     * 返回验证场景.
     */
    public function scenes(): array;

    /**
     * 返回字段名字.
     */
    public function names(): array;

    /**
     * 返回字段自定义消息.
     */
    public function messages(): array;

    /**
     * 返回验证规则.
     */
    public function rules(): array;
}
