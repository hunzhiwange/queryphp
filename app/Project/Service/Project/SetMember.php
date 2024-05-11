<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Infra\Validate\Project\ProjectUser as ProjectProjectUser;
use App\Infra\Validate\Validate;
use App\Project\Entity\Project;
use App\Project\Entity\ProjectUser;
use App\Project\Entity\ProjectUserTypeEnum;
use App\Project\Exceptions\ProjectBusinessException;
use App\Project\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 设为成员.
 */
class SetMember
{
    public function __construct(
        private UnitOfWork $w
    ) {
    }

    public function handle(SetMemberParams $params): array
    {
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(SetMemberParams $params): ProjectUser
    {
        $this->w->persist($entity = $this->entity($params));
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    private function entity(SetMemberParams $params): ProjectUser
    {
        $this->findProject($params->projectId);

        return $this->findProjectUser($params);
    }

    /**
     * @throws \App\Project\Exceptions\ProjectBusinessException
     */
    private function findProjectUser(SetMemberParams $params): ProjectUser
    {
        $map = [
            'user_id' => $params->userId,
            'type' => ProjectUserTypeEnum::MEMBER->value,
            'data_id' => $params->projectId,
            'data_type' => \App\Project\Entity\ProjectUserDataTypeEnum::PROJECT->value,
        ];

        $entity = $this->w
            ->repository(ProjectUser::class)
            ->where($map)
            ->findEntity()
        ;
        if (!$entity->id) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_MEMBER_NOT_EXIST);
        }

        if (\App\Project\Entity\ProjectUserExtendTypeEnum::ADMINISTRATOR->value !== $entity->extendType) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_MEMBER_IS_NOT_ADMINISTRATOR);
        }

        $entity->extendType = \App\Project\Entity\ProjectUserExtendTypeEnum::MEMBER->value;

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function findProject(int $id): Project
    {
        return $this->w
            ->repository(Project::class)
            ->findOrFail($id)
        ;
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Project\Exceptions\ProjectBusinessException
     */
    private function validateArgs(SetMemberParams $params): void
    {
        $input = [
            'data_id' => $params->projectId,
            'user_id' => $params->userId,
        ];
        $validator = Validate::make(new ProjectProjectUser(), 'delete', $input)->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            // @phpstan-ignore-next-line
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_FAVOR_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
