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

namespace Admin\App\Service\Resource;

use Common\Domain\Entity\Resource;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Kernel\HandleException;

/**
 * 后台部门编辑更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Statuses
{
    protected $w;

    /**
     * 构造函数.
     *
     * @param \queryyetsimple\http\request $oRequest
     * @param \common\is\repository\menu   $oRepository
     */
    public function __construct(IUnitOfWork $w)
    {
        $this->w = $w;
    }

    /**
     * 响应方法.
     *
     * @param array $aCategory
     *
     * @return array
     */
    public function handle(array $input)
    {
        $resources = $this->w->repository(Resource::class)->

        findAll(function ($select) use ($input) {
            $select->whereIn('id', $input['ids']);
        });

        if (0 === count($resources)) {
            throw new HandleException(__('未发现资源'));
        }

        foreach ($resources as $resource) {
            $resource->status = $input['status'];
            $this->w->persist($resource);
        }

        $this->w->flush();

        return [];
    }
}
