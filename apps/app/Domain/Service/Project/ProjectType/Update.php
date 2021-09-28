<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectType;

use App\Domain\Entity\Project\ProjectType;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Validate\Validate;
use Leevel\Validate\UniqueRule;
use App\Domain\Validate\Project\ProjectType as ProjectProjectType;

/**
 * 项目类型更新.
 */
class Update
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UpdateParams $params): array
    {
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): ProjectType
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
    private function entity(UpdateParams $params): ProjectType
    {
        $entity = $this->find($params->id);
        $entity->withProps($this->data($params));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): ProjectType
    {
        return $this->w
            ->repository(ProjectType::class)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     */
    private function data(UpdateParams $params): array
    {
        return $params->except(['id'])->toArray();
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\ProjectBusinessException
     */
    private function validateArgs(UpdateParams $params): void
    {
        $uniqueRule = UniqueRule::rule(
            ProjectType::class,
            exceptId:$params->id,
            additional:['project_id' => $this->entity->projectId]
        );

        $validator = Validate::make(new ProjectProjectType($uniqueRule), 'update', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_MODULE_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }
}
