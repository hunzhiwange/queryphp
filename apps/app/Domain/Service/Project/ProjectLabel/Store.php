<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\ProjectLabel;

use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Validate\Project\ProjectLabel as ProjectProjectLabel;
use App\Domain\Validate\Validate;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\UniqueRule;

/**
 * 项目分类保存.
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
    private function save(StoreParams $params): ProjectLabel
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
    private function entity(StoreParams $params): ProjectLabel
    {
        return new ProjectLabel($this->data($params));
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
            ProjectLabel::class,
            additional:['project_id' => $params->projectId]
        );

        $validator = Validate::make(new ProjectProjectLabel($uniqueRule), 'store', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new ProjectBusinessException(ProjectErrorCode::PROJECT_MODULE_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
