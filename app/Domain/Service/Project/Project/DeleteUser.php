<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectUser;
use App\Domain\Entity\Project\ProjectUserDataTypeEnum;
use App\Domain\Entity\Project\ProjectUserTypeEnum;
use App\Domain\Validate\Project\ProjectUser as ProjectProjectUser;
use App\Domain\Validate\Validate;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 删除成员.
 */
class DeleteUser
{
    public function __construct(
        private UnitOfWork $w
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(DeleteUserParams $params): array
    {
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     *
     * @throws \Exception
     */
    private function save(DeleteUserParams $params): ProjectUser
    {
        $this->w->persist($entity = $this->entity($params));
        $this->w->delete($entity);
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * @throws \Exception
     */
    private function entity(DeleteUserParams $params): ProjectUser
    {
        $this->findProject($params->projectId);

        return $this->findProjectUser($params);
    }

    /**
     * @throws \App\Exceptions\ProjectBusinessException
     * @throws \Exception
     */
    private function findProjectUser(DeleteUserParams $params): ProjectUser
    {
        $map = [
            'user_id' => $params->userId,
            'type' => ProjectUserTypeEnum::MEMBER->value,
            'data_id' => $params->projectId,
            'data_type' => ProjectUserDataTypeEnum::PROJECT->value,
        ];

        $entity = $this->w
            ->repository(ProjectUser::class)
            ->where($map)
            ->findOne()
        ;
        if (!$entity->id) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_MEMBER_NOT_EXIST);
        }

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
     * @throws \App\Exceptions\ProjectBusinessException
     * @throws \Exception
     */
    private function validateArgs(DeleteUserParams $params): void
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
