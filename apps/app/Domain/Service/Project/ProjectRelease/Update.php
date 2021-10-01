<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectRelease;

use App\Domain\Entity\Common;
use App\Domain\Entity\Project\ProjectRelease;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Validate\Validate;
use Leevel\Validate\UniqueRule;
use App\Domain\Validate\Project\ProjectRelease as ProjectProjectRelease;

/**
 * 项目版本更新.
 */
class Update
{
    private ?ProjectRelease $entity = null;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UpdateParams $params): array
    {
        $this->entity = $this->find($params->id);

        if (isset($params->completed) &&
            ProjectRelease::COMPLETED_PUBLISHED === $params->completed &&
            !isset($params->completedDate)) {
            $params->completedDate = Common::getCurrentDate();
        }

        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): ProjectRelease
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): ProjectRelease
    {
        $entity = $this->entity;
        $entity->withProps($this->data($params));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): ProjectRelease
    {
        return $this->w
            ->repository(ProjectRelease::class)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     */
    private function data(UpdateParams $params): array
    {
        return $params
            ->except(['id'])
            ->withoutNull()
            ->toArray();
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\ProjectBusinessException
     */
    private function validateArgs(UpdateParams $params): void
    {
        $uniqueRule = UniqueRule::rule(
            ProjectRelease::class,
            exceptId:$params->id,
            additional:['project_id' => $this->entity->projectId]
        );

        $validator = Validate::make(new ProjectProjectRelease($uniqueRule), 'update', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_RELEASE_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }
}
