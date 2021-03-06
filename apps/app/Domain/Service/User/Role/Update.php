<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Infra\Support\WorkflowService;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\UniqueRule;

/**
 * 角色更新.
 */
class Update
{
    use WorkflowService;

    private array $workflow = [
        'allowedInput',
        'filterInput',
        'validateInput',
    ];

    private array $allowedInput = [
        'id',
        'name',
        'num',
        'status',
    ];

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    /**
     * 过滤输入数据.
     */
    private function main(array &$input): array
    {
        return $this->save($input)->toArray();
    }

    /**
     * 验证参数.
     */
    private function entity(array $input): Role
    {
        $entity = $this->find($input['id']);
        $entity->withProps($this->data($input));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Role
    {
        return $this->w
            ->repository(Role::class)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     */
    private function data(array $input): array
    {
        return [
            'name'       => $input['name'],
            'num'        => $input['num'],
            'status'     => $input['status'],
        ];
    }

    /**
     * 保存.
     */
    private function save(array $input): Role
    {
        $this->w
            ->persist($entity = $this->entity($input))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 过滤数据规则.
     */
    private function filterInputRules(): array
    {
        return [
            'id'     => ['intval'],
            'status' => ['intval'],
        ];
    }

    /**
     * 校验数据规则.
     */
    private function validateInputRules(array $input): array
    {
        $uniqueRule = UniqueRule::rule(
            Role::class,
            exceptId:$input['id'], 
            additional:['delete_at' => 0]
        );

        $rules = [
            'id' => [
                'required',
            ],
            'name' => [
                'required',
                'chinese_alpha_num',
                'max_length:50',
                $uniqueRule,
            ],
            'num' => [
                'required',
                'alpha_dash',
                $uniqueRule,
            ],
            'status' => [
                ['in', Role::values('status')],
            ],
        ];

        $names = [
            'id'            => 'ID',
            'name'          => __('名字'),
            'num'           => __('编号'),
            'status' => __('状态值'),
        ];

        return [$rules, $names];
    }
}
