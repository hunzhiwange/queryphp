<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Infra\Support;

use Common\Infra\Exception\BusinessException;
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
     * @throws \Common\Infra\Exception\BusinessException
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

            throw new BusinessException($e);
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
        $input = array_map(function ($v) {
            if ('' === $v) {
                $v = null;
            }

            return $v;
        }, $input);

        return $input;
    }
}
