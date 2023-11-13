<?php

declare(strict_types=1);

namespace App\Infra\Console;

use Leevel\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Workflow\Dumper\MermaidDumper;
use Symfony\Component\Workflow\Workflow;

class WorkflowDump extends Command
{
    /**
     * 命令名字.
     */
    protected string $name = 'workflow:dump';

    /**
     * 命令行描述.
     */
    protected string $description = 'OutStorageWorkflow dump.';

    /**
     * 命令帮助.
     */
    protected string $help = <<<'EOF'
        The <info>%command.name%</info> command to show how to make workflow dump:

          <info>php %command.full_name%</info>

          <info>Ex: php %command.full_name% \\App\\Doc\\Service\\Order\\OrderStatusWorkflow</info>

          <info>Preview workflow https://mermaid.live/edit</info>

          <info>Ex: php %command.full_name% \\App\\Doc\\Service\\Order\\OrderStatusWorkflow | mmdc -o ./workflow.svg</info
        EOF;

    /**
     * 响应命令.
     */
    public function handle(): int
    {
        $workflowClass = $this->getArgument('class');
        if (!class_exists($workflowClass)) {
            throw new \Exception(sprintf('OutStorageWorkflow class `%s` not exists.', $workflowClass));
        }

        if (!\is_callable([$workflowObject = new $workflowClass(), 'handle'])) {
            throw new \Exception(sprintf('OutStorageWorkflow class `%s:%s` must be callable.', $workflowClass, 'handle'));
        }

        $workflow = $workflowObject->handle();
        if (!$workflow instanceof Workflow) {
            throw new \Exception(sprintf('OutStorageWorkflow class `%s` must be subclass of `%s`.', $workflowClass, Workflow::class));
        }

        $dumper = new MermaidDumper(MermaidDumper::TRANSITION_TYPE_STATEMACHINE);
        echo $dumper->dump($workflow->getDefinition());

        return self::SUCCESS;
    }

    /**
     * 命令参数.
     */
    protected function getArguments(): array
    {
        return [
            [
                'class',
                InputArgument::REQUIRED,
                'This is workflow class name.',
            ],
        ];
    }
}
