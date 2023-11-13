<?php

declare(strict_types=1);

namespace App\Infra\Service\Support;

use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Validator\StateMachineValidator;

abstract class StatusWorkflow
{
    public const WORKFLOW_PROPERTY = 'currentWorkflowState';

    public const STATUS_ENUM = '';

    public function handle(?string $initialPlace = null): StateMachine
    {
        return $this->createWorkflow($initialPlace);
    }

    protected function preparePlace(array|object|string|null $place): array|string|null
    {
        if (null === $place || \is_string($place)) {
            return $place;
        }

        return array_map(
            fn (string|object $item) => \is_object($item) ? $item->name : $item,
            \is_array($place) ? $place : [$place],
        );
    }

    protected function prepareWorkflow(array $workflow): array
    {
        if ($workflow['initial_places']) {
            $workflow['initial_places'] = $this->preparePlace($workflow['initial_places']);
        }

        foreach ($workflow['transitions'] as &$v) {
            $v['from'] = $this->preparePlace($v['from']);
            $v['to'] = $this->preparePlace($v['to']);
        }

        return $workflow;
    }

    protected function makeWorkflow(array $workflow): StateMachine
    {
        $definitionBuilder = new DefinitionBuilder();
        $definitionBuilder = $definitionBuilder
            ->addPlaces($workflow['places'])
            ->setInitialPlaces($workflow['initial_places'])
        ;
        foreach ($workflow['transitions'] as $name => $v) {
            $definitionBuilder->addTransition(new Transition($name, $v['from'], $v['to']));
        }
        $definition = $definitionBuilder->build();
        (new StateMachineValidator())->validate($definition, static::class);

        $marking = new MethodMarkingStore(true, static::WORKFLOW_PROPERTY);

        return new StateMachine($definition, $marking);
    }

    protected function createWorkflow(?string $initialPlace = null): StateMachine
    {
        $workflow = $this->getWorkflow($initialPlace);
        $workflow = $this->prepareWorkflow($workflow);

        return $this->makeWorkflow($workflow);
    }

    protected function getWorkflow(?string $initialPlace = null): array
    {
        return [
            'initial_places' => $initialPlace,
            'places' => $this->getPlaces(),
            'transitions' => $this->getTransitions(),
        ];
    }

    protected function getTransitions(): array
    {
        return [];
    }

    protected function getPlaces(): array
    {
        $statusEnum = static::STATUS_ENUM;
        if (!enum_exists($statusEnum)) {
            throw new \RuntimeException(sprintf('Enum %s not found', $statusEnum));
        }

        return $statusEnum::names();
    }
}
