<?php

declare(strict_types=1);

/*
 * This file is part of the your app package.
 *
 * The PHP Application For Code Poem For You.
 * (c) 2018-2099 http://yourdomian.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Common\Domain\Service\User\User;

use Closure;
use Common\Domain\Entity\User\User;
use Common\Domain\Service\Support\Read;
use Common\Infra\Support\WorkflowService;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Database\Ddd\Select;

/**
 * 用户列表.
 */
class Index
{
    use Read;
    use WorkflowService;

    private IUnitOfWork $w;

    /**
     * 工作流.
     *
     * @var array
     */
    private $workflow = [
        'filterSearchInput',
        'allowedInput',
        'defaultInput',
        'filterInput',
    ];

    /**
     * 允许的输入字段.
     *
     * @var array
     */
    private $allowedInput = [
        'key',
        'status',
        'page',
        'size',
        'column',
        'order_by',
    ];

    /**
     * 构造函数.
     */
    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
    }

    /**
     * 响应方法.
     */
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
        $data = $this->findPage($input, $repository);

        return $data;
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
