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
use Leevel\Database\Ddd\IEntity;
use Leevel\Database\Ddd\IUnitOfWork;
use Leevel\Database\Ddd\Select;

/**
 * 用户登出.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.23
 *
 * @version 1.0
 */
class Index
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
     * @param array  $input
     * @param string $strCode
     *
     * @return array
     */
    public function handle(array $input = []/*, $strCode*/)
    {
        $repository = $this->w->repository(Resource::class);

        $resource = $repository->findPage(
            (int) ($input['page'] ?: 1),
            (int) ($input['size'] ?? 10),
            function (Select $select, IEntity $entity) use ($input) {
                if (null !== $input['key']) {
                    $select->where(function ($select) use ($input) {
                        $select->orWhere('name', 'like', '%'.$input['key'].'%')->
                         orWhere('identity', 'like', '%'.$input['key'].'%');
                    });
                }

                if ((int) ($input['status']) > 0) {
                    $select->where('status', $input['status']);
                }

                $select->orderBy('id DESC');
            }
        );

        $data['page'] = $resource[0];
        $data['data'] = $resource[1]->toArray();

        $statusName = Resource::STRUCT['status']['enum'];

        foreach ($data['data'] as &$item) {
            $item['status_name'] = $statusName[$item['status']];
        }

        return $data;
    }
}
