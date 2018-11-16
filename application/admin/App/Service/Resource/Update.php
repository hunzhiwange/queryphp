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

/**
 * 资源更新.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Update
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
       $this->w->persist($resource = $this->entity($input));
       $this->w->flush();

       $result =  $resource->toArray();

        $result['status_name'] = $this->statusName($result['status']);

        return $result;
    }

    /**
     * 状态名字.
     *
     * @param string $strStatus
     *
     * @return string
     */
    protected function statusName($strStatus)
    {
        return Resource::STRUCT['status']['enum'][$strStatus];
    }

    /**
     * 验证参数.
     *
     * @param array $aStructure
     *
     * @return \admin\domain\entity\structure
     */
    protected function entity(array $input)
    {
        $resource = $this->find((int) $input['id']);

        $resource->props($this->data($input));

        return $resource;
    }

    /**
     * 查找实体.
     *
     * @param int $intId
     *
     * @return \admin\domain\entity\structure|void
     */
    protected function find(int $id)
    {
        return $this->w->repository(Resource::class)->findOrFail($id);
    }

    /**
     * 组装 POST 数据.
     *
     * @param array $aCategory
     *
     * @return array
     */
    protected function data(array $input)
    {
        return [
            'name'   => trim($input['name']),
            'identity'   => trim($input['identity']),
            'status' => $input['status'],
        ];
    }
}
