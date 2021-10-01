<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectTag;

use App\Domain\Entity\Project\ProjectTag;
use App\Domain\Validate\Project\ProjectTag as ProjectProjectTag;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Validate\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 项目标签保存.
 */
class Store
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(StoreParams $params): array
    {
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 保存.
     */
    private function save(StoreParams $params): ProjectTag
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 创建实体.
     */
    private function entity(StoreParams $params): ProjectTag
    {
        return new ProjectTag($this->data($params));
    }

    /**
     * 组装实体数据.
     */
    private function data(StoreParams $params): array
    {
        return $params->toArray();
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\ProjectBusinessException
     */
    private function validateArgs(StoreParams $params): void
    {
        $uniqueRule = UniqueRule::rule(
            ProjectTag::class,
            additional:['project_id' => $params->projectId]
        );

        $validator = Validate::make(new ProjectProjectTag($uniqueRule), 'store', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_MODULE_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
