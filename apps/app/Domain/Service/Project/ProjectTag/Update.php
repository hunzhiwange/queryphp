<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Entity\Project\ProjectTag;
use App\Domain\Validate\Project\ProjectTag as ProjectProjectTag;
use App\Domain\Validate\Validate;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\UniqueRule;

/**
 * 项目标签更新.
 */
class Update
{
    private ?ProjectTag $entity = null;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UpdateParams $params): array
    {
        $this->entity = $this->find($params->id);
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): ProjectTag
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
    private function entity(UpdateParams $params): ProjectTag
    {
        $entity = $this->entity;
        $entity->withProps($this->data($params));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): ProjectTag
    {
        return $this->w
            ->repository(ProjectTag::class)
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
            ProjectTag::class,
            exceptId:$params->id,
            additional:['project_id' => $this->entity->projectId]
        );

        $validator = Validate::make(new ProjectProjectTag($uniqueRule), 'update', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_MODULE_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }
}
