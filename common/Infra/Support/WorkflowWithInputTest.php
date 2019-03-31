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

use Tests\TestCase;

/**
 * @codeCoverageIgnore
 */
class WorkflowWithInputTest extends TestCase
{
    public function testBaseUse(): void
    {
        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new WorkflowWithInput1();
        $result = $m->handle($input);

        $json = <<<'eot'
{
    "main": {
        "foo": "bar"
    }
}
eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testFilterInput(): void
    {
        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new WorkflowWithInput2();
        $result = $m->handle($input);

        $json = <<<'eot'
{
    "main": {
        "foo": 0,
        "hello": "world extends"
    }
}
eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testValidateOk(): void
    {
        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new WorkflowWithInput3();
        $result = $m->handle($input);

        $json = <<<'eot'
{
    "main": {
        "foo": "bar",
        "hello": "world"
    }
}
eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }

    public function testValidateFailed(): void
    {
        $this->expectException(\Leevel\Kernel\HandleException::class);
        $this->expectExceptionMessage(
            '{"foo":["nikeFoo 必须是数字"]}'
        );

        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new WorkflowWithInput4();
        $m->handle($input);
    }
}

/**
 * @codeCoverageIgnore
 */
class WorkflowWithInput1
{
    use WorkflowWithInput;

    private $workflow = [
        'allowedInput',
    ];

    private $allowedInput = [
        'foo',
    ];

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    private function main(array $input): array
    {
        return ['main' => $input];
    }

    private function allowedInput(array &$input)
    {
        $this->allowedInputBase($input);
    }
}

/**
 * @codeCoverageIgnore
 */
class WorkflowWithInput2
{
    use WorkflowWithInput;

    private $workflow = [
        'filterInput',
    ];

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    private function main(array $input): array
    {
        return ['main' => $input];
    }

    private function filterInput(array &$input)
    {
        $rule = [
            'foo'   => ['intval'],
            'hello' => [
                function ($v) {
                    return (string) $v.' extends';
                },
            ],
        ];

        $this->filterInputBase($input, $rule);
    }
}

/**
 * @codeCoverageIgnore
 */
class WorkflowWithInput3
{
    use WorkflowWithInput;

    private $workflow = [
        'validateInput',
    ];

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    private function main(array $input): array
    {
        return ['main' => $input];
    }

    private function validateInput(array &$input)
    {
        $rules = [
            'foo' => ['required', 'alpha_dash'],
        ];
        $names = [
            'foo' => 'nikeFoo',
        ];
        $messages = [];

        $this->validateInputBase($input, $rules, $names, $messages);
    }
}

/**
 * @codeCoverageIgnore
 */
class WorkflowWithInput4
{
    use WorkflowWithInput;

    private $workflow = [
        'validateInput',
    ];

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    private function main(array $input): array
    {
        return ['main' => $input];
    }

    private function validateInput(array &$input)
    {
        $rules = [
            'foo' => ['number'],
        ];
        $names = [
            'foo' => 'nikeFoo',
        ];
        $messages = [];

        $this->validateInputBase($input, $rules, $names, $messages);
    }
}
