<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Project\Entity\Project;
use App\Project\Entity\ProjectUser;
use App\Project\Entity\ProjectUserDataTypeEnum;
use App\Project\Exceptions\ProjectBusinessException;
use App\Project\Exceptions\ProjectErrorCode;
use App\User\Entity\User;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\VectorInt;

/**
 * 项目新增成员.
 */
class AddUsers
{
    public function __construct(private UnitOfWork $w)
    {
    }

    /**
     * @throws \App\Project\Exceptions\ProjectBusinessException
     */
    public function handle(AddUsersParams $params): array
    {
        $this->verifyProject($params->projectId);
        $this->verifyUsers($params->userIds);

        $baseData = [
            'type' => \App\Project\Entity\ProjectUserTypeEnum::MEMBER->value,
            'data_id' => $params->projectId,
            'data_type' => ProjectUserDataTypeEnum::PROJECT->value,
        ];
        $existUserIds = $this->findExistUserIds($baseData);

        $newUserIds = array_diff($params->userIds->toArray(), $existUserIds);
        if (!$newUserIds) {
            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_USER_MEMBER_TO_BE_ADDED_ALREADY_EXIST);
        }

        foreach ($newUserIds as $userId) {
            $entity = new ProjectUser(array_merge($baseData, ['user_id' => $userId]));
            $this->w->persist($entity);
        }
        $this->w->flush();

        return [];
    }

    private function findExistUserIds(array $baseData): array
    {
        $users = $this->w
            ->repository(\App\Project\Entity\ProjectUser::class)
            ->where($baseData)
            ->setColumns('user_id')
            ->findMany()
        ;

        return array_column($users->toArray(), 'user_id');
    }

    private function verifyProject(int $projectId): \App\Project\Entity\Project
    {
        return $this->w
            ->repository(Project::class)
            ->findOrFail($projectId)
        ;
    }

    /**
     * @throws \Exception
     */
    private function verifyUsers(VectorInt $userIds): void
    {
        User::repository()->verifyUsersByIds($userIds->toArray());
    }
}
