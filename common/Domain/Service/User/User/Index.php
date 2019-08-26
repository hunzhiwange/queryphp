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
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\IEntity;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Database\Ddd\Select;

/**
 * 用户列表.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.23
 *
 * @version 1.0
 */
class Index
{
    use Read;
    use WorkflowService;

    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

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
    ];

    /**
     * 构造函数.
     *
     * @param \Leevel\Database\Ddd\IUnitOfWork $w
     */
    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
    }

    /**
     * 响应方法.
     *
     * @param array $input
     *
     * @return array
     */
    public function handle(array $input): array
    {
        return $this->workflow($input);
    }

    /**
     * 准备数据.
     *
     * @param \Leevel\Collection\Collection $data
     *
     * @return array
     */
    protected function prepareData(Collection $data): array
    {
        return (new PrepareForUser())->handleMulti($data);
    }

    /**
     * 查询条件.
     *
     * @param array $input
     *
     * @return \Closure
     */
    protected function condition(array $input): Closure
    {
        return function (Select $select, IEntity $entity) use ($input) {
            $select->eager(['role']);
            $select->withoutSoftDeleted();
            $this->spec($select, $input);
        };
    }

    /**
     * 过滤输入数据.
     *
     * @param array $input
     *
     * @return array
     */
    private function main(array &$input): array
    {
        $repository = $this->w->repository(User::class);

        list($page, $entitys) = $repository->findPage(
            $input['page'],
            $input['size'],
            $this->condition($input),
        );

        $data['page'] = $page;
        $data['data'] = $this->prepareData($entitys);

        return $data;
    }

    /**
     * 默认数据填充.
     *
     * @param array $input
     */
    private function defaultInput(array &$input): void
    {
        $input['column'] = 'id,name,num,email,mobile,status,create_at';
        $input['order_by'] = 'id DESC';
        $input['key_column'] = ['id', 'name', 'num'];

        if (!isset($input['page'])) {
            $input['page'] = 1;
        }

        if (!isset($input['size'])) {
            $input['size'] = 10;
        }
    }

    /**
     * 过滤数据规则.
     *
     * @param array $input
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
