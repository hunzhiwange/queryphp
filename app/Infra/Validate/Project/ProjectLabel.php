<?php

declare(strict_types=1);

namespace App\Infra\Validate\Project;

use App\Infra\Validate\IValidator;
use App\Project\Entity\ProjectLabel as EntityProjectLabel;
use App\Project\Entity\ProjectLabelStatusEnum;

/**
 * 项目分类验证.
 */
class ProjectLabel implements IValidator
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
        return EntityProjectLabel::columnNames();
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
            'id' => 'required|type:int|greater_than:0',
            'name' => ['required|chinese_alpha_num|max_length:50', $this->uniqueRule],
            'sort' => 'required|type:int|equal_greater_than:0',
            'project_id' => 'required|type:int|greater_than:0',
            'status' => [
                ['in', ProjectLabelStatusEnum::values()],
            ],
        ];
    }
}
