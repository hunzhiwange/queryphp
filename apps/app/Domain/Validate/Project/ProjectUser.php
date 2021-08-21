<?php

declare(strict_types=1);

namespace App\Domain\Validate\Project;

use App\Domain\Entity\Project\ProjectUser as ProjectProjectUser;
use App\Domain\Validate\IValidator;

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
            'user_id' => 'required|type:int|gt:0',
            'data_id' => 'required|type:int|gt:0',
        ];
    }
}
