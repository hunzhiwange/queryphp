<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\App\Service\User;

use Common\Domain\Entity\User;
use Common\Domain\Service\User\UserRole;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 用户更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Update
{
    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $w;

    /**
     * 事务工作单元.
     *
     * @var \Leevel\Database\Ddd\IUnitOfWork
     */
    protected $userRole;

    /**
     * 构造函数.
     *
     * @param \Leevel\Database\Ddd\IUnitOfWork $w
     */
    public function __construct(IUnitOfWork $w, UserRole $userRole)
    {
        $this->w = $w;
        $this->userRole = $userRole;
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
        $result = $this->save($input)->toArray();

        return $result;
    }

    /**
     * 保存.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\User
     */
    protected function save(array $input): User
    {
        $this->w->persist($entity = $this->entity($input));

        // $this->w->on($entity, function ($p) use ($input) {
        //     //$guest_book->content = 'guest_book content was post id is '.$p->id;
        //
        // });

        $this->userRole->handle([
            'user_id'  => $input['id'],
            'userRole' => $input['userRole'],
        ]);

        //
        // var_dump([
        //     'user_id' => $p->id,
        //     'userRole' => $input['userRole'],
        // ]);
        //var_dump($this->w);

        $this->w->flush();

        return $entity;
    }

    /**
     * 验证参数.
     *
     * @param array $input
     *
     * @return \Common\Domain\Entity\User
     */
    protected function entity(array $input)
    {
        $entity = $this->find((int) $input['id']);

        $entity->withProps($this->data($input));

        return $entity;
    }

    /**
     * 查找实体.
     *
     * @param int $id
     *
     * @return \Common\Domain\Entity\User
     */
    protected function find(int $id): User
    {
        return $this->w->repository(User::class)->findOrFail($id);
    }

    /**
     * 组装实体数据.
     *
     * @param array $input
     *
     * @return array
     */
    protected function data(array $input): array
    {
        return [
            'name'       => trim($input['name']),
            'identity'   => trim($input['identity']),
            'status'     => $input['status'],
        ];
    }
}
