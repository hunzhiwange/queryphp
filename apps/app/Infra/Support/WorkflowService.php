<?php

declare(strict_types=1);

namespace App\Infra\Support;

use App\Exceptions\BusinessException;
use App\Exceptions\ErrorCode;
use InvalidArgumentException;
use Leevel\Support\Arr;
use Leevel\Validate\Proxy\Validate;

/**
 * 工作流.
 */
trait WorkflowService
{
    use Workflow;

    /**
     * 输入数据白名单.
     */
    private function allowedInput(array &$input): void
    {
        $this->allowedInputBase($input);
    }

    /**
     * 过滤输入数据.
     */
    private function filterInput(array &$input): void
    {
        $this->filterInputBase($input);
    }

    /**
     * 校验输入数据.
     */
    private function validateInput(array $input): void
    {
        $this->validateInputBase($input);
    }

    /**
     * 输入数据白名单基础方法.
     */
    private function allowedInputBase(array &$input): void
    {
        $input = Arr::only($input, $this->allowedInput);
    }

    /**
     * 过滤输入数据基础方法.
     */
    private function filterInputBase(array &$input): void
    {
        $rules = $this->filterInputRules();
        $input = Arr::filter($input, $rules);
    }

    /**
     * 校验输入数据基础方法.
     *
     * @throws \App\Exceptions\BusinessException
     * @throws \InvalidArgumentException
     */
    private function validateInputBase(array $input): void
    {
        $inputRules = $this->validateInputRules($input);
        if (count($inputRules) < 2) {
            throw new InvalidArgumentException('Invalid validate input rules.');
        }
        if (!isset($inputRules[2])) {
            $inputRules[2] = [];
        }
        list($rules, $names, $messages) = $inputRules;

        $validator = Validate::make($input, $rules, $names, $messages);
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);
            throw new BusinessException(ErrorCode::SERVICE_INVALID_ARGUMENT, $e, true);
        }
    }

    /**
     * 填充输入数据.
     */
    private function fillDefaultInput(array &$input, array $defaultInput): void
    {
        foreach ($defaultInput as $k => $v) {
            if (!isset($input[$k])) {
                $input[$k] = $v;
            }
        }
    }

    /**
     * 过滤空字符串值.
     */
    private function filterEmptyStringInput(array $input): array
    {
        return array_map(fn (mixed $v) => '' === $v ? null : $v, $input);
    }
}
