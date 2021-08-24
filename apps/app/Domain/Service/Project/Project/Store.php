<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectLabel as ProjectLabel;
use App\Domain\Service\Project\Project\StoreParams;
use App\Exceptions\ProjectBusinessException;
use App\Exceptions\ProjectErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Validate\Validate;
use Leevel\Validate\UniqueRule;
use App\Domain\Validate\Project\Project as ProjectProject;

/**
 * 项目保存.
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
    private function save(StoreParams $params): Project
    {
        $this->w->persist($entity = $this->entity($params));
        if ($params->template->key) {
            $this->w->on($entity, function(Project $entity) use($params) {
                // 保存模板
                foreach ($params->template->data as $key => $item) {
                    $projectLabel = new ProjectLabel([
                        'project_id' => $entity->id,
                        'name' => $item['title'],
                        'sort' => $key,
                    ]);
                    $this->w->persist($projectLabel);
                }
            });
        }
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 创建实体.
     */
    private function entity(StoreParams $params): Project
    {
        return new Project($this->data($params));
    }

    /**
     * 组装实体数据.
     */
    private function data(StoreParams $params): array
    {
        return $params->except(['template'])->toArray();
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\ProjectBusinessException
     */
    private function validateArgs(StoreParams $params): void
    {
        // $uniqueRule = UniqueRule::rule(
        //     Project::class, 
        //     additional:['delete_at' => 0]
        // );

        // $validator = Validate::make(new ProjectProject($uniqueRule), 'store', $params->toArray())->getValidator();
        // if ($validator->fail()) {
        //     $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

        //     throw new ProjectBusinessException(ProjectErrorCode::ROLE_STORE_INVALID_ARGUMENT, $e, true);
        // }
    }
}
