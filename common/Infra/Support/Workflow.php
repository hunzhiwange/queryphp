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
trait Workflow
{
    /**
     * 执行工作流
     *
     * @param array $input
     *
     * @return array
     */
    private function workflow(array &$input): array
    {
        $result = [];

        foreach ($this->normalizeWorkflow() as $wf) {
            if (null !== ($_ = $this->{$wf}($input, $result))) {
                $result = $_;
            }
        }

        return $result;
    }

    /**
     * 整理工作流
     *
     * @return array
     */
    private function normalizeWorkflow(): array
    {
        $workflow = $this->workflow;

        if (!is_array($workflow)) {
            throw new InvalidArgumentException('Invalid workflow.');
        }

        /*
         * 工作流初始化.
         * 与 __construct 唯一不同的是会传入输入值.
         * 这是一个可选的值.
         */
        if (method_exists($this, 'new')) {
            array_unshift($workflow, 'new');
        }

        /*
         * 工作流主任务.
         * 必须拥有一个工作流主任务.
         */
        $workflow[] = 'main';

        /*
         * 工作流清理.
         * 与 __destruct 唯一不同的是会传入输入值.
         * 这是一个可选的值.
         */
        if (method_exists($this, 'drop')) {
            $workflow[] = 'drop';
        }

        return $workflow;
    }

    /**
     * 输入数据白名单基础方法.
     *
     * @param array $input
     * @param array $allowed
     */
    private function allowedInputBase(array &$input, array $allowed): void
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
            throw new HandleException(json_encode($validator->error()));
        }
    }
}
