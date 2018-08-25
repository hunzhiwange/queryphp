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

namespace admin\app\service\user;

use common\is\repository\user as repository;
use queryyetsimple\mvc\model_not_found;

/**
 * 修改账号.
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.12
 *
 * @version 1.0
 */
class update_info
{
    /**
     * 后台菜单仓储.
     *
     * @var \admin\is\repository\user
     */
    protected $oRepository;

    /**
     * 构造函数.
     *
     * @param \admin\is\repository\user $oRepository
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法.
     *
     * @param int   $intId
     * @param array $arrData
     *
     * @return \queryyetsimple\mvc\imodel
     */
    public function run($intId, array $aData)
    {
        return $this->oRepository->update($this->entify($intId, $aData));
    }

    /**
     * 验证参数.
     *
     * @param int   $intId
     * @param array $aData
     *
     * @return \admin\domain\entity\user
     */
    protected function entify($intId, array $aData)
    {
        $objUser = $this->find($intId);

        $objUser->forceProps($this->data($aData));

        return $objUser;
    }

    /**
     * 查找实体.
     *
     * @param int $intId
     *
     * @return \admin\domain\entity\user|void
     */
    protected function find($intId)
    {
        try {
            return $this->oRepository->findOrFail($intId);
        } catch (model_not_found $oE) {
            throw new update_info_failed($oE->getMessage());
        }
    }

    /**
     * 组装 POST 数据.
     *
     * @param array $aData
     *
     * @return array
     */
    protected function data(array $aData)
    {
        return [
            'nikename' => trim($aData['nikename']),
            'email'    => trim($aData['email']),
            'mobile'   => trim($aData['mobile']),
        ];
    }
}
