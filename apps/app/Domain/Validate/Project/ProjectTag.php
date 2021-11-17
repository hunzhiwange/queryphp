<?php

declare(strict_types=1);

namespace App\Domain\Validate\Project;

use App\Domain\Entity\Project\ProjectTag as EntityProjectTag;
use App\Domain\Validate\IValidator;

/**
 * 项目标签验证.
 */
class ProjectTag implements IValidator
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
                'sort',
                'status',
            ],
            'store' => [
                'name',
                'sort',
                'status',
                'project_id',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function names(): array
    {
        return EntityProjectTag::columnNames();
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
            'id'          => 'required|type:int|gt:0',
            'name'        => ['required|chinese_alpha_num|max_length:50', $this->uniqueRule],
            'sort'        => 'required|type:int|egt:0',
            'project_id'  => 'required|type:int|gt:0',
            'status'      => [
                ['in', EntityProjectTag::values('status')],
            ],
        ];
    }
}
