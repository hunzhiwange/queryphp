<?php

declare(strict_types=1);

namespace App\Infra\Dto;

class ParamsData extends ParamsDto
{
    public array $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }
}
