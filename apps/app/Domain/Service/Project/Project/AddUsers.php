<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use Leevel\Collection\TypedIntArray;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectUser;
use App\Domain\Entity\User\User;

/**
 * 项目新增成员.
 */
class AddUsers
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(AddUsersParams $params): array
    {
        $this->verifyProject($params->projectId);
        $this->verifyUsers($params->userIds);

        $baseData = [
            'type' => ProjectUser::TYPE_MEMBER,
            'data_id' => $params->projectId,
            'data_type' => ProjectUser::DATA_TYPE_PROJECT,
        ];
        $existUserIds = $this->findExistUserIds($baseData);

        foreach (array_diff($params->userIds->toArray(), $existUserIds) as $userId) {
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
