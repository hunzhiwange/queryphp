<?php

declare(strict_types=1);

namespace App\Job\Service;

trait JobNumber
{
    protected int $importSuccess = 0;

    protected int $importFail = 0;

    protected ?\Closure $importEachCallback = null;

    public function initNumber(): void
    {
        $this->importSuccess = 0;
        $this->importFail = 0;
    }

    public function getImportSuccess(): int
    {
        return $this->importSuccess;
    }

    public function getImportFail(): int
    {
        return $this->importFail;
    }

    protected function runImportEachCallback(?\Throwable $throwable = null): void
    {
        if (!$this->importEachCallback) {
            if ($throwable) {
                throw $throwable;
            }

            return;
        }

        $importEachCallback = $this->importEachCallback;
        $importEachCallback($this, $throwable);
    }
}
