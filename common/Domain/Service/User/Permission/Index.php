<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\Permission;

use Common\Domain\Entity\User\Permission;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Tree\Tree;

/**
 * 权限列表.
 */
class Index
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(): array
    {
        $repository = $this->w->repository(Permission::class);
        $permission = $repository
            ->setColumns('id,pid,name,num,status,create_at')
            ->findAll();

        return $this->normalizeTree($permission);
    }

    /**
     * 将节点载入节点树并返回树结构.
     */
    private function normalizeTree(Collection $entitys): array
    {
        return $this
            ->createTree($entitys)
            ->toArray(function (array $item) {
                return array_merge(['id' => $item['value'], 'expand' => true], $item['data']);
            });
    }

    /**
     * 生成节点树.
     */
    private function createTree(Collection $entitys): Tree
    {
        return new Tree($this->parseToNode($entitys));
    }

    /**
     * 转换为节点数组.
     */
    private function parseToNode(Collection $entitys): array
    {
        $node = [];
        foreach ($entitys as $e) {
            $node[] = [
                $e->id,
                $e->pid,
                $e->toArray(),
            ];
        }

        return $node;
    }
}
