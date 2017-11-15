<?php
// ©2017 http://your.domain.com All rights reserved.
namespace admin\app\service\user;

use queryyetsimple\mvc\model_not_found;
use common\is\repository\user as repository;

/**
 * 修改账号
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.12
 * @version 1.0
 */
class updateInfo
{

    /**
     * 后台菜单仓储
     *
     * @var \admin\is\repository\user
     */
    protected $oRepository;

    /**
     * 构造函数
     *
     * @param \admin\is\repository\user $oRepository
     * @return void
     */
    public function __construct(repository $oRepository)
    {
        $this->oRepository = $oRepository;
    }

    /**
     * 响应方法
     *
     * @param int $intId
     * @param array $arrData
     * @return \queryyetsimple\mvc\imodel
     */
    public function run($intId, array $aData)
    {
        return $this->oRepository->update($this->entify($intId, $aData));
    }

    /**
     * 验证参数
     *
     * @param int $intId
     * @param array $aData
     * @return \admin\domain\entity\user
     */
    protected function entify($intId, array $aData)
    {
        $objUser = $this->find($intId);

        $objUser->forceProps($this->data($aData));

        return $objUser;
    }

    /**
     * 查找实体
     *
     * @param int $intId
     * @return \admin\domain\entity\user|void
     */
    protected function find($intId)
    {
        try {
            return $this->oRepository->findOrFail($intId);
        } catch (model_not_found $oE) {
            throw new updateInfo_failed($oE->getMessage());
        }
    }

    /**
     * 组装 POST 数据
     *
     * @param array $aData
     * @return array
     */
    protected function data(array $aData)
    {
        return [
                'nikename' => trim($aData ['nikename']),
                'email' => trim($aData ['email']),
                'mobile' => trim($aData ['mobile'])
        ];
    }
}
