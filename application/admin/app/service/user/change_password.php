<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace admin\app\service\user;

use queryyetsimple\http\request;
use queryyetsimple\bootstrap\auth\change_password as change_passwords;

/**
 * 修改密码
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.21
 * @version 1.0
 */
class change_password
{
    use change_passwords;

    /**
     * HTTP REQUEST
     *
     * @var \queryyetsimple\http\request
     */
    protected $oRequest;

    /**
     * 构造函数
     *
     * @param \queryyetsimple\http\request $oRequest
     * @return void
     */
    public function __construct(request $oRequest)
    {
        $this->oRequest = $oRequest;
    }

    /**
     * 响应方法
     *
     * @param int $intId
     * @param array $arrData
     * @return \queryyetsimple\http\response|array
     */
    public function run($intId, array $aData)
    {
        $this->request($intId, $aData);
        return $this->changeUserPassword($this->oRequest);
    }

    /**
     * 设置 request 数据
     *
     * @param int $intId
     * @param array $aData
     * @return void
     */
    protected function request($intId, array $aData)
    {
        $this->oRequest->setPuts(
            [
                'id' => $intId,
                'old_password' => trim($aData['old_pwd']),
                'password' => trim($aData['new_pwd']),
                'comfirm_password' => trim($aData['confirm_pwd'])
            ]
        );
    }
}
