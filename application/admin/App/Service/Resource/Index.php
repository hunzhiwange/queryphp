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

// use common\is\repository\menu as repository;
// use queryyetsimple\bootstrap\auth\login;
// use queryyetsimple\http\request;
// use queryyetsimple\support\tree;
use Common\Domain\Entity\App;
use Leevel\Kernel\HandleException;
use Leevel\Auth;
use Leevel\Database\Ddd\IUnitOfWork;
use Common\Domain\Entity\Resource;
use Leevel\Tree\Tree;
use Leevel\Database\Ddd\SpecificationExpression;
use Leevel\Database\Ddd\IEntity;
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
   // // use login;

   //  /**
   //   * HTTP 请求
   //   *
   //   * @var \queryyetsimple\http\request
   //   */
   //  protected $oRequest;

   //  /**
   //   * 后台菜单仓储.
   //   *
   //   * @var \common\is\repository\menu
   //   */
   //  protected $oRepository;
   //  
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
     * @param array  $input
     * @param string $strCode
     *
     * @return array
     */
    public function handle(array $input=[]/*, $strCode*/)
    {
        $repository = $this->w->repository(Resource::class);

        //$re

        // $specExpr = new SpecificationExpression(function (IEntity $entity) use ($input) {
        //     return !empty($input['key']);
        // }, function (Select $select, IEntity $entity) use ($input) {
        //     $select->where(function ($select) use($input) {
        //         $select->orWhere('name', 'like', '%'.$input['key'].'%')->
        //         orWhere('identity', 'like', '%'.$input['key'].'%');
        //     });
        // });

        // $specExpr->andClosure(function (IEntity $entity) use ($input) {
        //     return !empty($input['status']);
        // }, function (Select $select, IEntity $entity) use ($input) {
        //     $select->where('status', $input['status']);
        // });


        $resource = $repository->findPage(
            (int) ($input['page'] ?: 1),
            (int) ($input['size'] ?? 10),
            function(Select $select, IEntity $entity) use ($input)  {
                if (null !== $input['key']) {
                     $select->where(function ($select) use($input) {
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

        // var_dump($repository->databaseConnect()->lastSql());
        // var_dump($repository->findPage(null, 10, true));


        // $resource[1]->each(function(&$item, $key){
        //     $item = $item->toArray();
        //     $item['status_name'] = Resource::STRUCT['status']['enum'][$item['status']];
        // });

        $data['page'] = $resource[0];
        $data['data'] = $resource[1]->toArray();

        $statusName = Resource::STRUCT['status']['enum'];

        foreach ($data['data'] as &$item) {
            $item['status_name'] = $statusName[$item['status']];
        }

        return $data;
    }

    /**
     * 转换为节点数组.
     *
     * @param \queryyetsimple\support\collection $objMenu
     *
     * @return array
     */
    protected function parseToNode($objMenu)
    {
        $arrNode = [];

        foreach ($objMenu as $oMenu) {
            $arrNode[] = [
                $oMenu->id,
                $oMenu->pid,
                $oMenu->toArray(),
            ];
        }

        return $arrNode;
    }

    /**
     * 获取权限.
     *
     * @return array
     */
    protected function getAuth()
    {
        return [];
    }

    /**
     * 取得菜单.
     *
     * @return array
     */
    protected function getMenu()
    {
        $arrList = $this->oRepository->all(function ($objSelect) {
            $objSelect->

            where('status', 'enable')->

            where('app', 'admin');
        });

        $arrNode = [];
        foreach ($arrList as $arr) {
            $arrNode[] = [
                $arr['id'],
                $arr['pid'],
                $this->formatData($arr->toArray()),
            ];
        }

        $oTree = new tree($arrNode);

        return $oTree->toArray(function ($arrItem, $oTree) {
            return $arrItem['data'];
        });
    }

    /**
     * 对比验证码
     *
     * @param string $strInputCode
     * @param string $strCode
     *
     * @return bool
     */
    protected function checkCode($strInputCode, $strCode)
    {
        return strtoupper($strInputCode) === strtoupper($strCode);
    }

    /**
     * 格式化菜单.
     *
     * @param array $arrData
     *
     * @return array
     */
    protected function formatData(array $arrData)
    {
        return [
            'title'     => $arrData['title'],
            'name'      => $arrData['name'],
            'path'      => $arrData['path'],
            'component' => $arrData['component'],
            'icon'      => $arrData['icon'],
        ];
    }
}
