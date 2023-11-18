<?php

declare(strict_types=1);

namespace App\Infra\Entity;

trait WorkflowStateTrait
{
    private ?string $currentWorkflowState = null;

    public function getCurrentWorkflowState(): ?string
    {
        return $this->currentWorkflowState;
    }

    public function setCurrentWorkflowState(string $currentWorkflowState, array $context = []): void
    {
        $this->currentWorkflowState = $currentWorkflowState;
    }
}
