<?php

declare(strict_types=1);

namespace App\Domain\Validate\Project;

use App\Domain\Entity\Project\ProjectRelease as EntityProjectRelease;
use App\Domain\Validate\IValidator;

/**
 * 项目发行版验证.
 */
class ProjectRelease implements IValidator
{
    public function __construct(private string $uniqueRule)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function scenes(): array
    {
        return [
            'update' => [
                'id',
                'name',
                'num',
                'status',
            ],
            'store' => [
                'name',
                'num',
                'status',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function names(): array
    {
        return EntityProjectRelease::columnNames();
    }

    /**
     * {@inheritDoc}
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            'id' => 'required|type:int|gt:0',
            'name' => ['required|chinese_alpha_num|max_length:50', $this->uniqueRule],
            'num'  => ['required', $this->uniqueRule],
            'status' => [
                ['in', EntityProjectRelease::values('status')],
            ],
        ];
    }
}
