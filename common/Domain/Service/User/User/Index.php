<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\User;

use Closure;
use Common\Domain\Entity\User\User;
use Common\Domain\Service\Support\Read;
use Common\Infra\Support\WorkflowService;
use Leevel\Database\Ddd\Select;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 用户列表.
 */
class Index
{
    use Read;
    use WorkflowService;

    private array $workflow = [
        'filterSearchInput',
        'allowedInput',
        'defaultInput',
        'filterInput',
    ];

    private array $allowedInput = [
        'key',
        'status',
        'page',
        'size',
        'column',
        'order_by',
    ];

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    /**
     * 准备用户数据.
     */
    private function prepareItem(User $user): array
    {
        $data = $user->toArray();
        $data['role'] = $user->role->toArray();

        return $data;
    }

    /**
     * 查询条件.
     */
    private function condition(array $input): Closure
    {
        return function (Select $select) use ($input) {
            $select->eager(['role']);
            $this->spec($select, $input);
        };
    }

    /**
     * 过滤输入数据.
     */
    private function main(array &$input): array
    {
        $repository = $this->w->repository(User::class);

        return $this->findPage($input, $repository);
    }

    /**
     * 默认数据填充.
     */
    private function defaultInput(array &$input): void
    {
        $defaultInput = [
            'column'   => 'id,name,num,email,mobile,status,create_at',
            'order_by' => 'id DESC',
            'page'     => 1,
            'size'     => 10,
        ];
        $this->fillDefaultInput($input, $defaultInput);

        $input['key_column'] = ['id', 'name', 'num'];
    }

    /**
     * 过滤数据规则.
     */
    private function filterInputRules(): array
    {
        return [
            'status'   => ['intval'],
            'page'     => ['intval'],
            'size'     => ['intval'],
        ];
    }
}
