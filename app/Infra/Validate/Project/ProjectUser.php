<?php

declare(strict_types=1);

namespace App\Infra\Validate\Project;

use App\Infra\Validate\IValidator;
use App\Project\Entity\ProjectUser as ProjectProjectUser;

/**
 * 项目用户验证.
 */
class ProjectUser implements IValidator
{
    /**
     * {@inheritDoc}
     */
    public function scenes(): array
    {
        return [
            'update' => [
            ],
            'store' => [
                'user_id',
                'data_id',
            ],
            'delete' => [
                'user_id',
                'data_id',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function names(): array
    {
        return ProjectProjectUser::columnNames();
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
            'user_id' => 'required|type:int|greater_than:0',
            'data_id' => 'required|type:int|greater_than:0',
        ];
    }
}
