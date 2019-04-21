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

use InvalidArgumentException;
use Leevel\Kernel\HandleException;
use Leevel\Support\Arr;
use Leevel\Validate\Facade\Validate;

/**
 * 工作流.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2019.03.13
 *
 * @version 1.0
 */
trait WorkflowService
{
    use Workflow;

    /**
     * 输入数据白名单.
     *
     * @param array $input
     */
    private function allowedInput(array &$input): void
    {
        $this->allowedInputBase($input, $this->allowedInput);
    }

    /**
     * 过滤输入数据.
     *
     * @param array $input
     */
    private function filterInput(array &$input): void
    {
        $rules = $this->filterInputRules();

        $this->filterInputBase($input, $rules);
    }

    /**
     * 校验输入数据.
     *
     * @param array $input
     */
    private function validateInput(array $input): void
    {
        $_ = $this->validateInputRules($input);

        if (2 > count($_)) {
            throw new InvalidArgumentException('Invalid validate input rules.');
        }

        if (!isset($_[2])) {
            $_[2] = [];
        }

        list($rules, $names, $messages) = $_;

        $this->validateInputBase($input, $rules, $names, $messages);
    }

    /**
     * 输入数据白名单基础方法.
     *
     * @param array $input
     */
    private function allowedInputBase(array &$input): void
    {
        $input = Arr::only($input, $this->allowedInput);
    }

    /**
     * 过滤输入数据基础方法.
     *
     * @param array $input
     * @param array $rules
     */
    private function filterInputBase(array &$input, array $rules): void
    {
        $input = Arr::filter($input, $rules);
    }

    /**
     * 校验输入数据基础方法.
     *
     * @param array $input
     * @param array $rules
     * @param array $names
     * @param array $messages
     */
    private function validateInputBase(array $input, array $rules = [], array $names = [], array $messages = []): void
    {
        $validator = Validate::make(
            $input,
            $rules,
            $names,
            $messages
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new HandleException($e);
        }
    }
}
