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
class WorkflowTest extends TestCase
{
    public function testBaseUse(): void
    {
        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new Workflow1();
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

    public function testWithCustoms(): void
    {
        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new Workflow2();
        $result = $m->handle($input);

        $json = <<<'eot'
            {
                "main": {
                    "foo": "bar",
                    "hello": "world"
                },
                "args": {
                    "foo": {
                        "foo": {
                            "foo": "bar",
                            "hello": "world"
                        }
                    },
                    "bar": {
                        "bar": {
                            "foo": "bar",
                            "hello": "world"
                        }
                    }
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

    public function testWorkflowWasNotFound(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Workflow `notfound` was not found.'
        );

        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new Workflow3();
        $m->handle($input);
    }

    public function testWorkflowWasInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid workflow.'
        );

        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new Workflow4();
        $m->handle($input);
    }

    public function testInitDropWorkflow(): void
    {
        $input = [
            'foo'   => 'bar',
            'hello' => 'world',
        ];

        $m = new Workflow5();
        $result = $m->handle($input);

        $json = <<<'eot'
            {
                "main": {
                    "foo": "bar",
                    "hello": "world"
                },
                "args": {
                    "init": {
                        "init": {
                            "foo": "bar",
                            "hello": "world"
                        }
                    }
                }
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $result
            )
        );

        $this->assertTrue($GLOBALS['drop_here']);
        unset($GLOBALS['drop_here']);
    }
}

/**
 * @codeCoverageIgnore
 */
class Workflow1
{
    use Workflow;

    private array $workflow = [];

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    private function main(array $input): array
    {
        return ['main' => $input];
    }
}

/**
 * @codeCoverageIgnore
 */
class Workflow2
{
    use Workflow;

    private array $workflow = [
        'foo',
        'bar',
    ];

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    private function main(array $input, array $args): array
    {
        return ['main' => $input, 'args' => $args];
    }

    private function foo(array $input): array
    {
        return ['foo' => $input];
    }

    private function bar(array $input): array
    {
        return ['bar' => $input];
    }
}

/**
 * @codeCoverageIgnore
 */
class Workflow3
{
    use Workflow;

    private array $workflow = [
        'notfound',
    ];

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    private function main(array $input, array $args): array
    {
        return ['main' => $input, 'args' => $args];
    }
}

/**
 * @codeCoverageIgnore
 */
class Workflow4
{
    use Workflow;

    private $workflow = 'notarray';

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    private function main(array $input, array $args): array
    {
        return ['main' => $input, 'args' => $args];
    }
}

/**
 * @codeCoverageIgnore
 */
class Workflow5
{
    use Workflow;

    private array $workflow = [];

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    private function main(array $input, array $args): array
    {
        return ['main' => $input, 'args' => $args];
    }

    private function init(array $input): array
    {
        return ['init' => $input];
    }

    private function drop(array $input): void
    {
        $GLOBALS['drop_here'] = true;
    }
}
