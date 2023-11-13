<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Infra\Validate\Validate;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use App\Infra\Validate\Project\ProjectUser as ProjectProjectUser;
use App\Project\Entity\ProjectUser;
use App\Project\Entity\ProjectUserDataTypeEnum;
use App\Project\Entity\ProjectUserTypeEnum;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 取消项目收藏.
 */
class CancelFavor
{
    public function __construct(
        private UnitOfWork $w
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(CancelFavorParams $params): array
    {
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     *
     * @throws \Exception
     */
    private function save(CancelFavorParams $params): ProjectUser
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
    private function entity(CancelFavorParams $params): ProjectUser
    {
        $this->findProject($params->projectId);

        return $this->findProjectUser($params);
    }

    /**
     * @throws \App\Exceptions\ProjectBusinessException
     * @throws \Exception
     */
    private function findProjectUser(CancelFavorParams $params): ProjectUser
    {
        $map = [
            'user_id' => $params->userId,
            'type' => ProjectUserTypeEnum::FAVOR->value,
            'data_id' => $params->projectId,
            'data_type' => ProjectUserDataTypeEnum::PROJECT->value,
        ];

        $entity = $this->w
            ->repository(\App\Project\Entity\ProjectUser::class)
            ->where($map)
            ->findEntity()
        ;
        if (!$entity->id) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_FAVOR_NOT_EXIST);
        }

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function findProject(int $id): \App\Project\Entity\Project
    {
        return $this->w
            ->repository(\App\Project\Entity\Project::class)
            ->findOrFail($id)
        ;
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\ProjectBusinessException
     * @throws \Exception
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

            // @phpstan-ignore-next-line
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_FAVOR_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
