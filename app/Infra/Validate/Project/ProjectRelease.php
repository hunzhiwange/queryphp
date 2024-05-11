<?php

declare(strict_types=1);

namespace App\Infra\Validate\Project;

use App\Infra\Validate\IValidator;
use App\Project\Entity\ProjectRelease as EntityProjectRelease;
use App\Project\Entity\ProjectReleaseStatusEnum;
use Leevel\Validate\IValidator as ValidateIValidator;

/**
 * 项目版本验证.
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
                ':name' => ValidateIValidator::OPTIONAL,
                ':sort' => ValidateIValidator::OPTIONAL,
                ':status' => ValidateIValidator::OPTIONAL,
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
            'id' => 'required|type:int|greater_than:0',
            'name' => ['required|chinese_alpha_num|max_length:50', $this->uniqueRule],
            'sort' => 'required|type:int|equal_greater_than:0',
            'project_id' => 'required|type:int|greater_than:0',
            'status' => [
                ['in', ProjectReleaseStatusEnum::values()],
            ],
        ];
    }
}
