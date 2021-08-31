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
 * 取消项目收藏.
 */
class CancelFavor
{
    public function __construct(
        private UnitOfWork $w
    )
    {
    }

    public function handle(CancelFavorParams $params): array
    {
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(CancelFavorParams $params): ProjectUser
    {
        $this->w->persist($entity = $this->entity($params));
        $this->w->delete($entity);
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    private function entity(CancelFavorParams $params): ProjectUser
    {
        $this->findProject($params->projectId);
        return $this->findProjectUser($params);
    }

    /**
     * @throws \App\Exceptions\UserBusinessException
     */
    private function findProjectUser(CancelFavorParams $params): ProjectUser
    {
        $map = [
            'user_id' => $params->userId,
            'type' => ProjectUser::TYPE_FAVOR,
            'data_id' => $params->projectId,
            'data_type' => ProjectUser::DATA_TYPE_PROJECT,
        ];

        $entity = $this->w
            ->repository(ProjectUser::class)
            ->where($map)
            ->findOne();
        if (!$entity->id) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_FAVOR_NOT_EXIST);
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
            ->findOrFail($id);
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\ProjectBusinessException
     */
    private function validateArgs(CancelFavorParams $params): void
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
