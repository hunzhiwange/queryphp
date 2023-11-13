<?php

declare(strict_types=1);

namespace App\Project\Service\Project;

use App\Infra\Service\Support\Store as CommonStore;
use App\Project\Entity\Project;
use function inject_snowflake_id;

/**
 * 项目保存.
 */
class Store
{
    use CommonStore;

    /**
     * 保存.
     */
    private function save(StoreParams $params): Project
    {
        $this->w->persist($entity = $this->entity($params));
        if ($params->template->key) {
            $this->w->on($entity, function (\App\Project\Entity\Project $entity) use ($params): void {
                // 保存模板
                // @phpstan-ignore-next-line
                foreach ($params->template->data as $key => $item) {
                    $projectLabel = new \App\Project\Entity\ProjectLabel(inject_snowflake_id([
                        'project_id' => $entity->id,
                        'name' => $item['title'],
                        'sort' => $key,
                    ]));
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
