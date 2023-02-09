<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Support\Collection;
use Leevel\Support\Tree as BaseTree;

/**
 * 权限树列表.
 */
class Tree
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(TreeParams $params): array
    {
        $repository = $this->w->repository(Permission::class);
        $permission = $repository
            ->if(null !== $params->status)
            ->where('status', $params->status)
            ->fi()
            ->setColumns('id,pid,name,num,status,create_at')
            ->findAll()
        ;

        return $this->normalizeTree($permission);
    }

    /**
     * 将节点载入节点树并返回树结构.
     */
    private function normalizeTree(Collection $entities): array
    {
        return $this
            ->createTree($entities)
            ->toArray(function (array $item) {
                return array_merge(['id' => $item['value'], 'expand' => true], $item['data']);
            })
        ;
    }

    /**
     * 生成节点树.
     */
    private function createTree(Collection $entities): BaseTree
    {
        return new BaseTree($this->parseToNode($entities));
    }

    /**
     * 转换为节点数组.
     */
    private function parseToNode(Collection $entities): array
    {
        $node = [];
        foreach ($entities as $e) {
            $node[] = [
                $e->id,
                $e->pid,
                // @phpstan-ignore-next-line
                $e->toArray(),
            ];
        }

        return $node;
    }
}
