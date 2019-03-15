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

namespace Common\Domain\Service\Support;

use Common\Infra\Support\Workflow as Workflows;
use InvalidArgumentException;

/**
 * 服务工作流抽象.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
trait Workflow
{
    use Workflows;

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
}
