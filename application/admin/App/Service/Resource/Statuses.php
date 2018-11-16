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
    public function __construct(IUnitOfWork $w/*request $oRequest, repository $oRepository*/)
    {
        $this->w = $w;
        // $this->oRepository = $oRepository;
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

        findAll(function($select) use($input) {
            $select->whereIn('id', $input['ids']);
        });

        if (count($resources) === 0) {
            throw new HandleException(__('未发现资源'));
        }

        foreach ($resources as $resource) {
            $resource->status = $input['status'];
            $this->w->persist($resource);
        }

        $this->w->flush();

        return [];
        // return $this->oRepository->create(
        //     $this->entity($aCategory)
        // );
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
        //return $this->oStatus->{$strStatus};
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
       // $intOldPid = $objStructure->pid;

        // $aStructure['pid'] = $this->parseParentId($aStructure['pid']);
        // if ($aStructure['id'] === $aStructure['pid']) {
        //     throw new update_failed(__('部门父级不能为自己'));
        // }

        // if ($this->createTree()->hasChildren($aStructure['id'], [
        //     $aStructure['pid'],
        // ])) {
        //     throw new update_failed(__('部门父级不能为自己的子部门'));
        // }

        // if ($intOldPid !== $aStructure['pid']) {
        //     $aStructure['sort'] = $this->parseSiblingSort($aStructure['pid']);
        // }
        // $objStructure->forceProps($this->data($aStructure));

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
     * 生成节点树.
     *
     * @return \common\is\tree\tree
     */
    protected function createTree()
    {
        return new tree($this->parseToNode($this->oRepository->all()));
    }

    /**
     * 转换为节点数组.
     *
     * @param \queryyetsimple\support\collection $objStructure
     *
     * @return array
     */
    protected function parseToNode($objStructure)
    {
        $arrNode = [];
        foreach ($objStructure as $oStructure) {
            $arrNode[] = [
                $oStructure->id,
                $oStructure->pid,
                $oStructure->name,
            ];
        }

        return $arrNode;
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
            //'remark' => trim($input['remark']),
            'status' => $input['status'],
        ];
    }

    /**
     * 分析父级数据.
     *
     * @param
     *            array $aPid
     *
     * @return int
     */
    protected function parseParentId(array $aPid)
    {
        $intPid = (int) (array_pop($aPid));
        if ($intPid < 0) {
            $intPid = 0;
        }

        return $intPid;
    }

    /**
     * 分析兄弟节点最靠下面的排序值
     *
     * @param int $nPid
     *
     * @return int
     */
    protected function parseSiblingSort($nPid)
    {
        $mixSibling = $this->oRepository->siblingNodeBySort($nPid);

        return $mixSibling ? $mixSibling->sort - 1 : 500;
    }
}
