<?php

declare(strict_types=1);

namespace App\Infra\Service;

use Leevel\Support\Dto;

class DemoParams extends Dto
{
    public string $no = '';

    /**
     * @throw \InvalidArgumentException
     */
    public function validate(): void
    {
        if (!$this->no) {
            throw new \InvalidArgumentException(__('未指定编号'));
        }
    }
}
