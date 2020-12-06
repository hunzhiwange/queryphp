<?php

declare(strict_types=1);

namespace Common\Infra\Support;

use InvalidArgumentException;

/**
 * 工作流.
 */
trait Workflow
{
    /**
     * 执行工作流.
     *
     * @throws \InvalidArgumentException
     */
    private function workflow(array &$input): array
    {
        $result = $args = [];

        foreach ($this->normalizeWorkflow() as $wf) {
            if (!method_exists($this, $wf)) {
                $e = sprintf('Workflow `%s` was not found.', $wf);

                throw new InvalidArgumentException($e);
            }

            if (null !== ($tmp = $this->{$wf}($input, $args))) {
                $result = $tmp;
            }

            $args[$wf] = $tmp;
        }

        return $result;
    }

    /**
     * 整理工作流.
     *
     * @throws \InvalidArgumentException
     */
    private function normalizeWorkflow(): array
    {
        $workflow = $this->workflow;

        if (!is_array($workflow)) {
            throw new InvalidArgumentException('Invalid workflow.');
        }

        /*
         * 工作流初始化.
         *
         * - 与 __construct 唯一不同的是会传入输入值.
         * - 这是一个可选的值.
         */
        if (method_exists($this, 'init')) {
            array_unshift($workflow, 'init');
        }

        /*
         * 工作流主任务.
         * 必须拥有一个工作流主任务.
         */
        $workflow[] = 'main';

        /*
         * 工作流清理.
         *
         * - 与 __destruct 唯一不同的是会传入输入值.
         * - 这是一个可选的值.
         */
        if (method_exists($this, 'drop')) {
            $workflow[] = 'drop';
        }

        return $workflow;
    }
}
