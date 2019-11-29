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
class WorkflowServiceTest extends TestCase
{
    public function testBaseUse(): void
    {
        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new WorkflowService1();
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

        $m = new WorkflowService2();
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

        $m = new WorkflowService3();
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
        $this->expectException(\Common\Infra\Exception\BusinessException::class);
        $this->expectExceptionMessage(
            '{"foo":["nikeFoo 必须是数字"]}'
        );

        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new WorkflowService4();
        $m->handle($input);
    }

    public function testValidateInputRulesIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid validate input rules.'
        );

        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new WorkflowService5();
        $result = $m->handle($input);
    }
}

/**
 * @codeCoverageIgnore
 */
class WorkflowService1
{
    use WorkflowService;

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
class WorkflowService2
{
    use WorkflowService;

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
        $this->filterInputBase($input);
    }

    private function filterInputRules(): array
    {
        $rule = [
            'foo'   => ['intval'],
            'hello' => [
                function ($v) {
                    return (string) $v.' extends';
                },
            ],
        ];

        return $rule;
    }
}

/**
 * @codeCoverageIgnore
 */
class WorkflowService3
{
    use WorkflowService;

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
        $this->validateInputBase($input);
    }

    private function validateInputRules(): array
    {
        $rules = [
            'foo' => ['required', 'alpha_dash'],
        ];
        $names = [
            'foo' => 'nikeFoo',
        ];
        $messages = [];

        return [$rules, $names, $messages];
    }
}

/**
 * @codeCoverageIgnore
 */
class WorkflowService4
{
    use WorkflowService;

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
        $this->validateInputBase($input);
    }

    private function validateInputRules(): array
    {
        $rules = [
            'foo' => ['number'],
        ];
        $names = [
            'foo' => 'nikeFoo',
        ];
        $messages = [];

        return [$rules, $names, $messages];
    }
}

/**
 * @codeCoverageIgnore
 */
class WorkflowService5
{
    use WorkflowService;

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

    private function validateInputRules(): array
    {
        return [];
    }
}
