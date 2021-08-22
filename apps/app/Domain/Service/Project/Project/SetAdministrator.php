<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectUser;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Validate\Validate;
use App\Domain\Validate\Project\ProjectUser as ProjectProjectUser;

/**
 * 设为管理.
 */
class SetAdministrator
{
    public function __construct(
        private UnitOfWork $w
    )
    {
    }

    public function handle(SetAdministratorParams $params): array
    {
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(SetAdministratorParams $params): ProjectUser
    {
        $this->w->persist($entity = $this->entity($params));
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    private function entity(SetAdministratorParams $params): ProjectUser
    {
        $this->findProject($params->projectId);
        return $this->findProjectUser($params);
    }

    /**
     * @throws \App\Exceptions\UserBusinessException
     */
    private function findProjectUser(SetAdministratorParams $params): ProjectUser
    {
        $map = [
            'user_id' => $params->userId,
            'type' => ProjectUser::TYPE_MEMBER,
            'data_id' => $params->projectId,
            'data_type' => ProjectUser::DATA_TYPE_PROJECT,
        ];

        $entity = $this->w
            ->repository(ProjectUser::class)
            ->where($map)
            ->findOne();
        if (!$entity->id) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_MEMBER_NOT_EXIST);
        }

        if (ProjectUser::EXTEND_TYPE_MEMBER !== $entity->extendType) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_MEMBER_ALREADY_ADMINISTRATOR);
        }

        $entity->extendType = ProjectUser::EXTEND_TYPE_ADMINISTRATOR;

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function findProject(int $id): Project
    {
        return $this->w
            ->repository(Project::class)
            ->findOrFail($id);
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\ProjectBusinessException
     */
    private function validateArgs(SetAdministratorParams $params): void
    {
        $input = [
            'data_id' => $params->projectId,
            'user_id' => $params->userId,
        ];
        $validator = Validate::make(new ProjectProjectUser(), 'delete', $input)->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_FAVOR_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
