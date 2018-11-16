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

// use admin\domain\entity\position_category as entity;
// use admin\is\repository\position_category as repository;

use Common\Domain\Entity\Resource;
use Leevel\Database\Ddd\IUnitOfWork;

/**
 * 后台职位删除.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.10.23
 *
 * @version 1.0
 */
class Destroy
{
    protected $w;

    /**
     * 构造函数.
     *
     * @param \queryyetsimple\http\request $oRequest
     * @param \common\is\repository\menu   $oRepository
     */
    public function __construct(IUnitOfWork $w/*request $oRequest, repository $oRepository*/)
    {
        $this->w = $w;
        // $this->oRepository = $oRepository;
    }

    // /**
    //  * 响应方法.
    //  *
    //  * @param int $intId
    //  *
    //  * @return array
    //  */
    // public function handel($intId)
    // {
    //     return $this->delete($this->oRepository->find($intId));
    // }

    /**
     * 响应方法.
     *
     * @param array $aCategory
     *
     * @return array
     */
    public function handle(array $input)
    {
        $resource = $this->find($input['id']);
//echo '111';
        //die;
        $this->w->persist($resource)->
        remove($resource)->
        flush();

       // $result =  $resource->toArray();

       //  $result['status_name'] = $this->statusName($result['status']);
return [];
        // return $this->oRepository->create(
        //     $this->entity($aCategory)
        // );
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
        //echo $id;
        return $this->w->repository(Resource::class)->findOrFail($id);
        //die;
        // try {
        //     return $this->oRepository->findOrFail($intId);
        // } catch (model_not_found $oE) {
        //     throw new update_failed($oE->getMessage());
        // }
    }

    /**
     * 删除实体.
     *
     * @param \admin\domain\entity\admin_position $objStructure
     *
     * @return int
     */
    protected function delete($objStructure)
    {
        $this->checkChildren($objStructure->id);

        return $this->oRepository->delete($objStructure);
    }

    /**
     * 判断是否存在子职位.
     *
     * @param int $intId
     */
    protected function checkChildren($intId)
    {
        if ($this->oRepository->hasChildren($intId)) {
            throw new destroy_failed('职位包含子职位，无法删除');
        }
    }
}
