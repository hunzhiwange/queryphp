<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectUser;
use App\Domain\Entity\Project\ProjectUserDataTypeEnum;
use App\Domain\Entity\Project\ProjectUserTypeEnum;
use App\Domain\Entity\User\User;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Support\TypedIntArray;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 项目新增成员.
 */
class AddUsers
{
    public function __construct(private UnitOfWork $w)
    {
    }

    /**
     * @throws \App\Exceptions\ProjectBusinessException
     */
    public function handle(AddUsersParams $params): array
    {
        $this->verifyProject($params->projectId);
        $this->verifyUsers($params->userIds);

        $baseData = [
            'type'      => ProjectUserTypeEnum::MEMBER->value,
            'data_id'   => $params->projectId,
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
            ->repository(ProjectUser::class)
            ->where($baseData)
            ->setColumns('user_id')
            ->findAll();

        return array_column($users->toArray(), 'user_id');
    }

    private function verifyProject(int $projectId): Project
    {
        return $this->w
            ->repository(Project::class)
            ->findOrFail($projectId);
    }

    private function verifyUsers(TypedIntArray $userIds): void
    {
        User::repository()->verifyUsersByIds($userIds->toArray());
    }
}
