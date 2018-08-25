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

use queryyetsimple\bootstrap\auth\change_password as change_passwords;
use queryyetsimple\http\request;

/**
 * 修改密码
 *
 * @author Name Your <your@mail.com>
 *
 * @since 2017.11.21
 *
 * @version 1.0
 */
class change_password
{
    use change_passwords;

    /**
     * HTTP REQUEST.
     *
     * @var \queryyetsimple\http\request
     */
    protected $oRequest;

    /**
     * 构造函数.
     *
     * @param \queryyetsimple\http\request $oRequest
     */
    public function __construct(request $oRequest)
    {
        $this->oRequest = $oRequest;
    }

    /**
     * 响应方法.
     *
     * @param int   $intId
     * @param array $arrData
     *
     * @return array|\queryyetsimple\http\response
     */
    public function run($intId, array $aData)
    {
        $this->request($intId, $aData);

        return $this->changeUserPassword($this->oRequest);
    }

    /**
     * 设置 request 数据.
     *
     * @param int   $intId
     * @param array $aData
     */
    protected function request($intId, array $aData)
    {
        $this->oRequest->setPuts(
            [
                'id'               => $intId,
                'old_password'     => trim($aData['old_pwd']),
                'password'         => trim($aData['new_pwd']),
                'comfirm_password' => trim($aData['confirm_pwd']),
            ]
        );
    }
}
