<?php

declare(strict_types=1);

namespace App\Domain\Service\Project\Project;

use App\Domain\Entity\Project\Project;
use App\Domain\Entity\Project\ProjectLabel;
use App\Domain\Service\Support\Store as CommonStore;

/**
 * 项目保存.
 */
class Store
{
    use CommonStore;

    protected string $entityClass = Project::class;

    /**
     * 保存.
     */
    private function save(StoreParams $params): Project
    {
        $this->w->persist($entity = $this->entity($params));
        if ($params->template->key) {
            $this->w->on($entity, function (Project $entity) use ($params): void {
                // 保存模板
                // @phpstan-ignore-next-line
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
     * 组装实体数据.
     */
    private function data(StoreParams $params): array
    {
        return $params->except(['template'])->toArray();
    }
}
